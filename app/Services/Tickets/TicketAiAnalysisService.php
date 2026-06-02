<?php

namespace App\Services\Tickets;

use App\Exceptions\InvalidAiResponseException;
use App\Models\AiAnalysis;
use App\Models\CatTicketImpacto;
use App\Models\CatTicketPrioridad;
use App\Models\CatTicketRiesgo;
use App\Models\CatTicketTipo;
use App\Models\CatTicketUrgencia;
use App\Models\Ticket;
use App\Services\AI\AiClientService;
use Illuminate\Support\Str;
use Throwable;

class TicketAiAnalysisService
{
    public function __construct(
        private readonly AiClientService $client,
        private readonly TicketAiContextService $contextService,
        private readonly TicketAiPromptService $promptService,
        private readonly TicketAiActionService $actionService,
        private readonly TicketHistoryService $historyService,
    ) {}

    public function run(Ticket $ticket, array $options, int $userId): AiAnalysis
    {
        $analysis = AiAnalysis::query()->create([
            'ticket_id' => $ticket->id,
            'user_id' => $userId,
            'model' => config('ai.model'),
            'status' => 'pending',
            'analysis_type' => $options['analysis_type'] ?? 'full',
        ]);

        $this->historyService->log($ticket, 'ai_analysis_requested', $userId, descripcion: 'Analisis de IA solicitado.', metadata: [
            'ai_analysis_id' => $analysis->id,
            'analysis_type' => $analysis->analysis_type,
        ]);

        if (! $this->client->isConfigured()) {
            return $this->fail($analysis, $ticket, $userId, 'La IA no esta configurada o esta desactivada.');
        }

        try {
            $analysis->update(['status' => 'processing']);
            $context = $this->contextService->build($ticket, $options);
            $prompt = $this->promptService->build($context, $analysis->analysis_type);
            $result = $this->client->analyze($prompt);
            $json = $result['json'];
            $classification = data_get($json, 'suggested_classification', []);

            $analysis->update([
                'status' => 'completed',
                'summary' => data_get($json, 'summary'),
                'detected_problem' => data_get($json, 'detected_problem'),
                'suggested_type_id' => $this->catalogId(CatTicketTipo::class, data_get($classification, 'type')),
                'suggested_priority_id' => $this->catalogId(CatTicketPrioridad::class, data_get($classification, 'priority')),
                'suggested_impact_id' => $this->catalogId(CatTicketImpacto::class, data_get($classification, 'impact')),
                'suggested_urgency_id' => $this->catalogId(CatTicketUrgencia::class, data_get($classification, 'urgency')),
                'suggested_risk_id' => $this->catalogId(CatTicketRiesgo::class, data_get($classification, 'risk')),
                'suggested_difficulty' => data_get($classification, 'difficulty'),
                'missing_information' => data_get($json, 'missing_information', []),
                'suggested_reply' => data_get($json, 'suggested_reply'),
                'suggested_checklist' => data_get($json, 'suggested_checklist', []),
                'can_answer_directly' => (bool) data_get($json, 'can_answer_directly', false),
                'requires_code_change' => (bool) data_get($json, 'requires_code_change', false),
                'requires_quote' => (bool) data_get($json, 'requires_quote', false),
                'confidence' => $this->confidence(data_get($json, 'confidence')),
                'prompt' => $prompt,
                'raw_response' => [
                    'parsed' => $json,
                    'provider' => $result['raw'],
                    'metadata' => [
                        'used_knowledge_article_ids' => $context['used_knowledge_article_ids'] ?? [],
                    ],
                ],
                'executed_at' => now(),
            ]);

            $analysis->refresh();
            $this->actionService->createFromAnalysis($analysis, $analysis->raw_response ?? []);

            if ($context['used_knowledge_article_ids'] ?? []) {
                $this->historyService->log($ticket, 'ai_knowledge_context_used', $userId, descripcion: 'La IA uso articulos de conocimiento como contexto.', metadata: [
                    'ai_analysis_id' => $analysis->id,
                    'used_knowledge_article_ids' => $context['used_knowledge_article_ids'],
                ]);
            }

            $this->historyService->log($ticket, 'ai_analysis_completed', $userId, descripcion: 'Analisis de IA completado.', metadata: [
                'ai_analysis_id' => $analysis->id,
                'confidence' => $analysis->confidence,
            ]);

            return $analysis;
        } catch (InvalidAiResponseException $exception) {
            return $this->fail($analysis, $ticket, $userId, $exception->getMessage(), [
                'provider' => $exception->rawResponse,
                'text' => $exception->responseText,
            ]);
        } catch (Throwable $exception) {
            return $this->fail($analysis, $ticket, $userId, $exception->getMessage());
        }
    }

    private function fail(AiAnalysis $analysis, Ticket $ticket, int $userId, string $message, ?array $rawResponse = null): AiAnalysis
    {
        $analysis->update([
            'status' => 'failed',
            'error_message' => $message,
            'raw_response' => $rawResponse,
            'executed_at' => now(),
        ]);

        $this->historyService->log($ticket, 'ai_analysis_failed', $userId, descripcion: 'Analisis de IA fallido: '.$message, metadata: [
            'ai_analysis_id' => $analysis->id,
        ]);

        return $analysis->refresh();
    }

    private function catalogId(string $modelClass, ?string $name): ?int
    {
        if (! $name) {
            return null;
        }

        $needle = $this->normalize($name);

        return $modelClass::query()
            ->get(['id', 'nombre'])
            ->first(function ($item) use ($needle) {
                $haystack = $this->normalize($item->nombre);

                return $haystack === $needle
                    || str_contains($haystack, $needle)
                    || str_contains($needle, $haystack)
                    || Str::before($haystack, ' ') === Str::before($needle, ' ');
            })?->id;
    }

    private function normalize(string $value): string
    {
        return trim(Str::lower(Str::ascii($value)));
    }

    private function confidence(mixed $value): ?float
    {
        if (! is_numeric($value)) {
            return null;
        }

        $number = (float) $value;

        return $number > 1 ? min(100, $number) / 100 : max(0, min(1, $number));
    }
}
