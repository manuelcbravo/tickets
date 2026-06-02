<?php

namespace App\Services\Tickets;

use App\Models\CatTicketEstado;
use App\Models\CatTicketPrioridad;
use App\Models\CatTicketTipo;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TicketTriageService
{
    public function start(Ticket $ticket, int $usuarioId): Ticket
    {
        return DB::transaction(function () use ($ticket, $usuarioId): Ticket {
            $old = $ticket->estado_id;
            $ticket->update(['estado_id' => $this->stateId('En triage') ?? $ticket->estado_id]);

            app(TicketHistoryService::class)->log(
                $ticket,
                'triage_started',
                $usuarioId,
                'estado_id',
                $old,
                $ticket->estado_id,
                'Triage iniciado.',
            );

            app(TicketChecklistService::class)->ensureSuggestedForTicket($ticket->refresh()->load('tipo'), $usuarioId);

            return $ticket->refresh();
        });
    }

    public function complete(Ticket $ticket, array $data, User $user): Ticket
    {
        return DB::transaction(function () use ($ticket, $data, $user): Ticket {
            $suggestion = app(TicketPriorityService::class)->suggest(
                (int) $data['tipo_id'],
                (int) $data['impacto_id'],
                (int) $data['urgencia_id'],
                (int) $data['riesgo_id'],
                $data['dificultad'] ?? null,
            );

            $tipo = CatTicketTipo::query()->find($data['tipo_id']);
            $tipoKey = $this->key($tipo?->nombre);
            $priority = CatTicketPrioridad::query()->find($data['prioridad_id']);
            $priorityKey = $this->key($priority?->nombre);

            if ($tipoKey === 'incidente critico' && (str_starts_with($priorityKey, 'p3') || str_starts_with($priorityKey, 'p4'))) {
                throw ValidationException::withMessages([
                    'prioridad_id' => 'Un incidente critico no puede quedar como P3 o P4.',
                ]);
            }

            $missing = $this->normalizeMissingInformation($data['missing_information'] ?? []);
            $hasRequiredMissing = collect($missing)->contains(fn (array $item): bool => ($item['required'] ?? false) && ! ($item['completed'] ?? false));
            $nextStatus = $data['next_status'] ?? 'priorizado';

            if ($hasRequiredMissing && $nextStatus !== 'falta_informacion' && ! $user->can('tickets.manage')) {
                throw ValidationException::withMessages([
                    'next_status' => 'Hay informacion requerida faltante; el ticket debe quedar en Falta informacion.',
                ]);
            }

            if ($hasRequiredMissing && $nextStatus !== 'falta_informacion' && $user->can('tickets.manage') && blank($data['triage_notes'] ?? null)) {
                throw ValidationException::withMessages([
                    'triage_notes' => 'Justifica en notas por que avanza con informacion requerida faltante.',
                ]);
            }

            $oldPriority = $ticket->prioridad_id;
            $oldStatus = $ticket->estado_id;
            $isNewDevelopment = $tipoKey === 'nuevo desarrollo';
            $isCommercial = $tipoKey === 'solicitud comercial';
            $requiresQuote = $isNewDevelopment || $isCommercial || (bool) ($data['requires_quote'] ?? false);

            if ($requiresQuote && $nextStatus === 'en_desarrollo') {
                throw ValidationException::withMessages([
                    'next_status' => 'Un ticket que requiere cotizacion no debe avanzar directo a desarrollo sin aprobacion.',
                ]);
            }

            $ticket->update([
                'tipo_id' => $data['tipo_id'],
                'impacto_id' => $data['impacto_id'],
                'urgencia_id' => $data['urgencia_id'],
                'riesgo_id' => $data['riesgo_id'],
                'dificultad' => $data['dificultad'] ?? null,
                'prioridad_id' => $data['prioridad_id'],
                'responsable_id' => $data['responsable_id'] ?? $ticket->responsable_id,
                'requires_code_change' => $isNewDevelopment || (bool) ($data['requires_code_change'] ?? false),
                'requires_quote' => $requiresQuote,
                'priority_score' => $suggestion['priority_score'],
                'triage_notes' => $data['triage_notes'] ?? null,
                'missing_information' => $missing,
                'triage_completed_at' => now(),
                'triage_by_id' => $user->id,
                'prioritized_at' => now(),
                'prioritized_by_id' => $user->id,
                'estado_id' => $this->nextStatusId($nextStatus, $hasRequiredMissing, (bool) ($data['responsable_id'] ?? $ticket->responsable_id)),
            ]);

            if ($ticket->responsable_id) {
                app(TicketLifecycleService::class)->assign($ticket, $ticket->responsable_id, $user->id);
            }

            app(TicketChecklistService::class)->ensureSuggestedForTicket($ticket->refresh()->load('tipo'), $user->id);

            app(TicketHistoryService::class)->log($ticket, 'priority_suggested', $user->id, descripcion: $suggestion['explanation'], metadata: $suggestion);

            if ((string) $oldPriority !== (string) $ticket->prioridad_id) {
                app(TicketHistoryService::class)->log($ticket, 'priority_changed', $user->id, 'prioridad_id', $oldPriority, $ticket->prioridad_id, 'Prioridad confirmada en triage.');
                app(TicketSlaService::class)->recalculate($ticket, $user->id);
            }

            if ((string) $oldStatus !== (string) $ticket->estado_id) {
                app(TicketHistoryService::class)->log($ticket, 'status_changed', $user->id, 'estado_id', $oldStatus, $ticket->estado_id, 'Estado actualizado por triage.');
            }

            app(TicketHistoryService::class)->log($ticket, 'missing_information_updated', $user->id, descripcion: 'Informacion faltante actualizada.', metadata: ['items' => $missing]);
            app(TicketHistoryService::class)->log($ticket, 'triage_completed', $user->id, descripcion: 'Triage completado.');

            if ($hasRequiredMissing) {
                app(TicketHistoryService::class)->log($ticket, 'ticket_marked_missing_information', $user->id, descripcion: 'Ticket marcado con informacion faltante.');
            } else {
                app(TicketHistoryService::class)->log($ticket, 'ticket_prioritized', $user->id, descripcion: 'Ticket priorizado.');
            }

            return $ticket->refresh();
        });
    }

    public function normalizeMissingInformation(array $items): array
    {
        return array_values(array_map(fn (array $item): array => [
            'key' => (string) ($item['key'] ?? Str::slug((string) ($item['label'] ?? 'item'), '_')),
            'label' => (string) ($item['label'] ?? ''),
            'required' => (bool) ($item['required'] ?? false),
            'completed' => (bool) ($item['completed'] ?? false),
        ], $items));
    }

    private function nextStatusId(string $nextStatus, bool $hasRequiredMissing, bool $hasResponsible): ?int
    {
        if ($hasRequiredMissing || $nextStatus === 'falta_informacion') {
            return $this->stateId('Falta informacion');
        }

        if ($nextStatus === 'en_analisis' || $hasResponsible) {
            return $this->stateId('En analisis');
        }

        return match ($nextStatus) {
            'en_desarrollo' => $this->stateId('En desarrollo'),
            'priorizado' => $this->stateId('Priorizado'),
            default => $this->stateId('Priorizado'),
        };
    }

    private function stateId(string $name): ?int
    {
        return CatTicketEstado::query()->where('nombre', $name)->value('id');
    }

    private function key(?string $value): string
    {
        return Str::of($value ?? '')->ascii()->lower()->trim()->toString();
    }
}
