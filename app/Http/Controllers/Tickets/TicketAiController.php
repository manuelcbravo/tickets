<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\ApplyTicketAiAnalysisRequest;
use App\Http\Requests\Tickets\RejectTicketAiAnalysisRequest;
use App\Http\Requests\Tickets\RunTicketAiAnalysisRequest;
use App\Models\AiAnalysis;
use App\Models\Ticket;
use App\Services\AI\AiClientService;
use App\Services\Tickets\TicketAiActionService;
use App\Services\Tickets\TicketAiAnalysisService;
use App\Services\Tickets\TicketAiApplyService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TicketAiController extends Controller
{
    public function show(Ticket $ticket, AiClientService $client): Response
    {
        $ticket->load([
            'cliente:id,nombre,razon_social',
            'proyecto:id,nombre',
            'modulo:id,nombre',
            'responsable:id,name',
            'tipo:id,nombre',
            'estado:id,nombre',
            'prioridad:id,nombre',
            'impacto:id,nombre',
            'urgencia:id,nombre',
            'riesgo:id,nombre',
            'knowledgeArticles:id,titulo,estatus,visibilidad,tipo',
            'aiAnalyses.user:id,name',
            'aiAnalyses.suggestedType:id,nombre',
            'aiAnalyses.suggestedPriority:id,nombre',
            'aiAnalyses.suggestedImpact:id,nombre',
            'aiAnalyses.suggestedUrgency:id,nombre',
            'aiAnalyses.suggestedRisk:id,nombre',
            'aiActions.user:id,name',
        ]);

        return Inertia::render('tickets/ai/show', [
            'ticket' => $ticket,
            'aiConfig' => [
                'enabled' => (bool) config('ai.enabled'),
                'configured' => $client->isConfigured(),
                'model' => config('ai.model'),
            ],
        ]);
    }

    public function analyze(RunTicketAiAnalysisRequest $request, Ticket $ticket, TicketAiAnalysisService $service): RedirectResponse
    {
        $analysis = $service->run($ticket, $request->validated(), $request->user()->id);

        return redirect()
            ->route('tickets.ai.show', $ticket)
            ->with($analysis->status === 'completed' ? 'success' : 'error', $analysis->status === 'completed'
                ? 'Analisis de IA completado.'
                : ($analysis->error_message ?: 'No se pudo completar el analisis de IA.'));
    }

    public function showAnalysis(Ticket $ticket, AiAnalysis $analysis): Response
    {
        abort_unless($analysis->ticket_id === $ticket->id, 404);

        return $this->show($ticket, app(AiClientService::class));
    }

    public function apply(ApplyTicketAiAnalysisRequest $request, Ticket $ticket, AiAnalysis $analysis, TicketAiApplyService $service): RedirectResponse
    {
        $applied = $service->apply($ticket, $analysis, $request->validated(), $request->user()->id);

        return redirect()
            ->route('tickets.ai.show', $ticket)
            ->with($applied ? 'success' : 'error', $applied ? 'Sugerencias de IA aplicadas.' : 'No se selecciono ninguna sugerencia aplicable.');
    }

    public function reject(RejectTicketAiAnalysisRequest $request, Ticket $ticket, AiAnalysis $analysis, TicketAiActionService $service): RedirectResponse
    {
        abort_unless($analysis->ticket_id === $ticket->id, 404);

        $service->rejectAnalysis($analysis, $request->user()->id, $request->validated('reason'));

        return redirect()
            ->route('tickets.ai.show', $ticket)
            ->with('success', 'Sugerencia de IA rechazada.');
    }
}
