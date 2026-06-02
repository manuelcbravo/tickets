<?php

namespace App\Services\Tickets;

use App\Models\AiAnalysis;
use App\Models\Ticket;
use App\Models\TicketChecklistItem;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\DB;

class TicketAiApplyService
{
    public function __construct(
        private readonly TicketHistoryService $historyService,
        private readonly TicketSlaService $slaService,
    ) {}

    public function apply(Ticket $ticket, AiAnalysis $analysis, array $options, int $userId): array
    {
        abort_unless($analysis->ticket_id === $ticket->id, 404);

        return DB::transaction(function () use ($ticket, $analysis, $options, $userId): array {
            $updates = [];
            $applied = [];

            $this->maybeApply($options, 'apply_type', $analysis->suggested_type_id, 'tipo_id', $updates, $applied);
            $priorityChanged = $this->maybeApply($options, 'apply_priority', $analysis->suggested_priority_id, 'prioridad_id', $updates, $applied);
            $this->maybeApply($options, 'apply_impact', $analysis->suggested_impact_id, 'impacto_id', $updates, $applied);
            $this->maybeApply($options, 'apply_urgency', $analysis->suggested_urgency_id, 'urgencia_id', $updates, $applied);
            $this->maybeApply($options, 'apply_risk', $analysis->suggested_risk_id, 'riesgo_id', $updates, $applied);

            if (($options['apply_difficulty'] ?? false) && $analysis->suggested_difficulty) {
                $updates['dificultad'] = $analysis->suggested_difficulty;
                $applied[] = 'dificultad';
            }

            if ($options['apply_flags'] ?? false) {
                $updates['requires_code_change'] = $analysis->requires_code_change;
                $updates['requires_quote'] = $analysis->requires_quote;
                $applied[] = 'flags';
            }

            if ($updates) {
                $before = $ticket->only(array_keys($updates));
                $ticket->update($updates);
                $this->historyService->log($ticket, 'ai_suggestion_applied', $userId, descripcion: 'Sugerencias de IA aplicadas al ticket.', metadata: [
                    'ai_analysis_id' => $analysis->id,
                    'applied_fields' => $applied,
                    'before' => $before,
                    'after' => $updates,
                ]);
            }

            if ($priorityChanged) {
                $this->slaService->recalculate($ticket->refresh(), $userId);
            }

            if ($options['create_checklist'] ?? false) {
                $created = $this->createChecklist($ticket, $analysis, $userId);
                if ($created > 0) {
                    $applied[] = 'checklist';
                }
            }

            if (($options['create_internal_comment'] ?? false) || ($options['create_customer_reply_draft'] ?? false)) {
                $this->createReplyDraft($ticket, $analysis, $userId);
                $applied[] = 'reply_draft';
            }

            if ($applied) {
                $analysis->update(['status' => 'applied']);
                $analysis->actions()->where('status', 'draft')->update([
                    'status' => 'applied',
                    'applied_by_id' => $userId,
                    'applied_at' => now(),
                ]);
            }

            return $applied;
        });
    }

    private function maybeApply(array $options, string $option, mixed $value, string $field, array &$updates, array &$applied): bool
    {
        if (! ($options[$option] ?? false) || ! $value) {
            return false;
        }

        $updates[$field] = $value;
        $applied[] = $field;

        return true;
    }

    private function createChecklist(Ticket $ticket, AiAnalysis $analysis, int $userId): int
    {
        $items = collect($analysis->suggested_checklist ?? [])->filter(fn ($item) => filled(data_get($item, 'title')));
        $order = (int) $ticket->checklistItems()->max('orden');
        $count = 0;

        foreach ($items as $item) {
            TicketChecklistItem::query()->create([
                'ticket_id' => $ticket->id,
                'titulo' => data_get($item, 'title'),
                'descripcion' => data_get($item, 'description'),
                'tipo' => 'tecnico',
                'requerido' => (bool) data_get($item, 'required', false),
                'orden' => ++$order,
            ]);
            $count++;
        }

        if ($count > 0) {
            $this->historyService->log($ticket, 'ai_checklist_created', $userId, descripcion: 'Checklist sugerido por IA creado.', metadata: [
                'ai_analysis_id' => $analysis->id,
                'items_created' => $count,
            ]);
        }

        return $count;
    }

    private function createReplyDraft(Ticket $ticket, AiAnalysis $analysis, int $userId): void
    {
        if (! $analysis->suggested_reply) {
            return;
        }

        TicketMessage::query()->create([
            'ticket_id' => $ticket->id,
            'usuario_id' => $userId,
            'mensaje' => "Borrador IA de respuesta al cliente:\n\n".$analysis->suggested_reply,
            'es_interno' => true,
            'es_respuesta_cliente' => false,
        ]);

        $this->historyService->log($ticket, 'ai_reply_draft_created', $userId, descripcion: 'Borrador de respuesta de IA guardado como comentario interno.', metadata: [
            'ai_analysis_id' => $analysis->id,
        ]);
    }
}
