<?php

namespace App\Services\Tickets;

use App\Models\AiAction;
use App\Models\AiAnalysis;
use App\Models\Ticket;

class TicketAiActionService
{
    public function createFromAnalysis(AiAnalysis $analysis, array $payload): void
    {
        $this->createAction($analysis, 'summarize_ticket', 'Resumen del ticket', $analysis->summary, [
            'confidence' => $analysis->confidence,
        ]);

        $this->createAction($analysis, 'classify_ticket', 'Clasificacion sugerida', null, [
            'type_id' => $analysis->suggested_type_id,
            'priority_id' => $analysis->suggested_priority_id,
            'impact_id' => $analysis->suggested_impact_id,
            'urgency_id' => $analysis->suggested_urgency_id,
            'risk_id' => $analysis->suggested_risk_id,
            'difficulty' => $analysis->suggested_difficulty,
        ]);

        if ($analysis->missing_information) {
            $this->createAction($analysis, 'detect_missing_information', 'Informacion faltante detectada', null, [
                'items' => $analysis->missing_information,
            ]);
        }

        if ($analysis->suggested_reply) {
            $this->createAction($analysis, 'suggest_customer_reply', 'Respuesta sugerida al cliente', $analysis->suggested_reply);
        }

        if ($analysis->suggested_checklist) {
            $this->createAction($analysis, 'generate_checklist', 'Checklist tecnico sugerido', null, [
                'items' => $analysis->suggested_checklist,
            ]);
        }

        if ($analysis->requires_quote) {
            $this->createAction($analysis, 'suggest_quote_flag', 'Sugerencia de cotizacion', 'La IA sugiere revisar si requiere cotizacion.');
        }

        if ($analysis->requires_code_change) {
            $this->createAction($analysis, 'suggest_code_flag', 'Sugerencia de cambio de codigo', 'La IA sugiere posible cambio de codigo.');
        }

        $articleIds = data_get($payload, 'metadata.used_knowledge_article_ids', []);
        if ($articleIds) {
            $this->createAction($analysis, 'search_knowledge', 'Base de conocimiento consultada', null, [
                'used_knowledge_article_ids' => $articleIds,
            ]);
        }
    }

    public function rejectAnalysis(AiAnalysis $analysis, int $userId, ?string $reason = null): void
    {
        $analysis->update(['status' => 'rejected']);
        $analysis->actions()->whereIn('status', ['draft', 'pending_review'])->update([
            'status' => 'rejected',
            'rejected_by_id' => $userId,
            'rejected_at' => now(),
            'rejection_reason' => $reason,
        ]);

        app(TicketHistoryService::class)->log(
            $analysis->ticket,
            'ai_suggestion_rejected',
            $userId,
            descripcion: 'Sugerencia de IA rechazada.',
            metadata: ['ai_analysis_id' => $analysis->id, 'reason' => $reason],
        );
    }

    public function apply(AiAction $action, int $userId): void
    {
        $action->update([
            'status' => 'applied',
            'applied_by_id' => $userId,
            'applied_at' => now(),
        ]);
    }

    public function reject(AiAction $action, int $userId, string $reason): void
    {
        $action->update([
            'status' => 'rejected',
            'rejected_by_id' => $userId,
            'rejected_at' => now(),
            'rejection_reason' => $reason,
        ]);

        app(TicketHistoryService::class)->log(
            $action->ticket,
            'ai_suggestion_rejected',
            $userId,
            descripcion: 'Accion sugerida por IA rechazada.',
            metadata: ['ai_action_id' => $action->id, 'type' => $action->type, 'reason' => $reason],
        );
    }

    private function createAction(AiAnalysis $analysis, string $type, string $title, ?string $response = null, ?array $metadata = null): AiAction
    {
        return AiAction::query()->create([
            'ticket_id' => $analysis->ticket_id,
            'ai_analysis_id' => $analysis->id,
            'user_id' => $analysis->user_id,
            'type' => $type,
            'status' => 'draft',
            'title' => $title,
            'prompt' => $analysis->prompt,
            'response' => $response,
            'metadata' => $metadata,
        ]);
    }
}
