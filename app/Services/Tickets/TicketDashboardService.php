<?php

namespace App\Services\Tickets;

use App\Models\Ticket;
use App\Models\TicketSla;
use App\Models\TicketTiempo;
use App\Models\CatTicketEstado;
use App\Models\CatTicketTipo;
use App\Models\KnowledgeArticle;
use App\Models\AiAction;
use App\Models\AiAnalysis;
use App\Models\Release;
use App\Models\TicketDevelopmentTask;
use App\Models\Cotizacion;
use App\Models\ExternalMessage;
use App\Models\Integracion;
use App\Models\NotificationLog;
use App\Models\WebhookEvent;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TicketDashboardService
{
    public function data(?int $usuarioId = null): array
    {
        $weekStart = Carbon::now()->startOfWeek();
        $today = Carbon::today();

        return [
            'metrics' => [
                'openTickets' => Ticket::query()->whereNull('closed_at')->count(),
                'newToday' => Ticket::query()->whereDate('created_at', $today)->count(),
                'closedThisWeek' => Ticket::query()->whereNotNull('closed_at')->where('closed_at', '>=', $weekStart)->count(),
                'slaOverdue' => $this->openSlaQuery('vencido')->count(),
                'slaAtRisk' => $this->openSlaQuery('en_riesgo')->count(),
                'assignedToMe' => $usuarioId ? Ticket::query()->whereNull('closed_at')->where('responsable_id', $usuarioId)->count() : 0,
                'unassigned' => Ticket::query()->whereNull('closed_at')->whereNull('responsable_id')->count(),
                'timeThisWeek' => (int) TicketTiempo::query()->where('fecha', '>=', $weekStart->toDateString())->sum('minutos'),
                'pendingTriage' => Ticket::query()->whereIn('estado_id', $this->stateIds(['Nuevo', 'En triage', 'Reabierto']))->count(),
                'missingInformation' => Ticket::query()->where('estado_id', $this->stateId('Falta informacion'))->count(),
                'prioritized' => Ticket::query()->where('estado_id', $this->stateId('Priorizado'))->count(),
                'criticalIncidents' => Ticket::query()
                    ->whereNull('closed_at')
                    ->where('tipo_id', CatTicketTipo::query()->where('nombre', 'Incidente critico')->value('id'))
                    ->count(),
                'reopenedPendingTriage' => Ticket::query()->where('estado_id', $this->stateId('Reabierto'))->count(),
                'knowledgeTotal' => KnowledgeArticle::query()->count(),
                'knowledgePublished' => KnowledgeArticle::query()->where('estatus', 'publicado')->count(),
                'documentedTickets' => Ticket::query()->whereHas('knowledgeArticles')->count(),
                'closedWithoutDocumentation' => Ticket::query()->whereNotNull('closed_at')->whereDoesntHave('knowledgeArticles')->count(),
                'aiTicketsAnalyzed' => AiAnalysis::query()->distinct('ticket_id')->count('ticket_id'),
                'aiAnalysesCompleted' => AiAnalysis::query()->where('status', 'completed')->count(),
                'aiAnalysesFailed' => AiAnalysis::query()->where('status', 'failed')->count(),
                'aiSuggestionsApplied' => AiAnalysis::query()->where('status', 'applied')->count(),
                'aiSuggestionsRejected' => AiAnalysis::query()->where('status', 'rejected')->count(),
                'aiAverageConfidence' => round((float) AiAnalysis::query()->whereNotNull('confidence')->avg('confidence') * 100, 1),
                'aiSuggestedReplies' => AiAction::query()->where('type', 'suggest_customer_reply')->count(),
                'aiChecklistsGenerated' => AiAction::query()->where('type', 'generate_checklist')->count(),
                'ticketsWithCodeChanges' => Ticket::query()->where('has_code_changes', true)->count(),
                'developmentTasksPending' => TicketDevelopmentTask::query()->where('estado', 'pendiente')->count(),
                'developmentTasksInProgress' => TicketDevelopmentTask::query()->where('estado', 'en_desarrollo')->count(),
                'developmentTasksInReview' => TicketDevelopmentTask::query()->whereIn('estado', ['pr_abierto', 'en_revision'])->count(),
                'registeredPullRequests' => TicketDevelopmentTask::query()->whereNotNull('pull_request_url')->count(),
                'ticketsReadyForRelease' => Ticket::query()->where('development_status', 'listo_para_release')->count(),
                'scheduledReleases' => Release::query()->where('estado', 'programado')->count(),
                'releasedThisMonth' => Release::query()->where('estado', 'liberado')->where('released_at', '>=', Carbon::now()->startOfMonth())->count(),
                'qaPending' => Ticket::query()->where(fn ($query) => $query->whereNull('qa_status')->orWhere('qa_status', 'pendiente'))->count(),
                'qaInTesting' => Ticket::query()->where('qa_status', 'en_pruebas')->count(),
                'qaApproved' => Ticket::query()->where('qa_status', 'aprobado')->count(),
                'qaRejected' => Ticket::query()->where('qa_status', 'rechazado')->count(),
                'qaBlocked' => Ticket::query()->where('qa_status', 'bloqueado')->count(),
                'reopenedTickets' => Ticket::query()->where('reopen_count', '>', 0)->count(),
                'forcedClosedTickets' => Ticket::query()->whereHas('historial', fn ($query) => $query->where('accion', 'ticket_close_blocked_by_qa')->where('metadata->forced_close', true))->count(),
                'averageTestsPerTicket' => round((float) DB::table('ticket_test_results')->selectRaw('COUNT(*) * 1.0 / NULLIF(COUNT(DISTINCT ticket_id), 0) as average')->value('average'), 1),
                'ticketsWithFailedTests' => Ticket::query()->whereHas('testResults', fn ($query) => $query->where('status', 'fallido'))->count(),
                'quotesCreatedThisMonth' => Cotizacion::query()->where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
                'quotesDraft' => Cotizacion::query()->where('estado', 'borrador')->count(),
                'quotesPendingInternalApproval' => Cotizacion::query()->where('estado', 'en_revision_interna')->count(),
                'quotesApprovedClient' => Cotizacion::query()->where('estado', 'aprobada_cliente')->count(),
                'quotesRejected' => Cotizacion::query()->where('estado', 'rechazada_cliente')->count(),
                'quotesConverted' => Cotizacion::query()->where('estado', 'convertida')->count(),
                'quotedAmountTotal' => (float) Cotizacion::query()->sum('total'),
                'quotedAmountApproved' => (float) Cotizacion::query()->whereIn('estado', ['aprobada_cliente', 'convertida'])->sum('total'),
                'ticketsRequiresQuote' => Ticket::query()->where('requires_quote', true)->count(),
                'ticketsOutOfScopeDetected' => Ticket::query()->where('requires_quote', true)->whereIn('quote_status', ['pendiente', 'cotizado'])->count(),
                'activeIntegrations' => Integracion::query()->where('activo', true)->count(),
                'webhooksReceivedToday' => WebhookEvent::query()->whereDate('created_at', $today)->count(),
                'webhooksFailed' => WebhookEvent::query()->where('status', 'failed')->count(),
                'unlinkedEvents' => WebhookEvent::query()->whereNull('ticket_id')->whereNotIn('status', ['ignored'])->count(),
                'notificationsSent' => NotificationLog::query()->where('status', 'sent')->count(),
                'notificationsFailed' => NotificationLog::query()->where('status', 'failed')->count(),
                'externalMessagesReceived' => ExternalMessage::query()->where('direction', 'inbound')->count(),
                'externalMessagesWithoutTicket' => ExternalMessage::query()->whereNull('ticket_id')->count(),
                'linkedPullRequests' => WebhookEvent::query()->whereNotNull('ticket_id')->where(function ($query): void {
                    $query->where('event_type', 'ilike', '%pull%')->orWhere('event_type', 'ilike', '%merge%');
                })->count(),
                'linkedCommits' => WebhookEvent::query()->whereNotNull('ticket_id')->where(function ($query): void {
                    $query->where('event_type', 'ilike', '%push%')->orWhereRaw('payload::text ilike ?', ['%commit%']);
                })->count(),
            ],
            'overdueTickets' => $this->ticketSlaRows('vencido'),
            'riskTickets' => $this->ticketSlaRows('en_riesgo'),
            'loadByResponsible' => $this->loadByResponsible($weekStart),
            'ticketsByPriority' => $this->ticketsByPriority(),
        ];
    }

    private function openSlaQuery(string $status)
    {
        return TicketSla::query()
            ->where('estado_sla', $status)
            ->whereHas('ticket', fn ($query) => $query->whereNull('closed_at'));
    }

    private function ticketSlaRows(string $status)
    {
        return TicketSla::query()
            ->with([
                'ticket:id,folio,titulo,cliente_id,proyecto_id,responsable_id,prioridad_id,closed_at',
                'ticket.cliente:id,nombre',
                'ticket.proyecto:id,nombre',
                'ticket.responsable:id,name',
                'prioridad:id,nombre',
            ])
            ->where('estado_sla', $status)
            ->whereHas('ticket', fn ($query) => $query->whereNull('closed_at'))
            ->orderBy('vence_resolucion_at')
            ->limit(10)
            ->get();
    }

    private function loadByResponsible(Carbon $weekStart)
    {
        return Ticket::query()
            ->leftJoin('users', 'tickets.responsable_id', '=', 'users.id')
            ->leftJoin('ticket_sla', 'ticket_sla.ticket_id', '=', 'tickets.id')
            ->leftJoin('ticket_tiempos', function ($join) use ($weekStart): void {
                $join->on('ticket_tiempos.ticket_id', '=', 'tickets.id')
                    ->whereNull('ticket_tiempos.deleted_at')
                    ->where('ticket_tiempos.fecha', '>=', $weekStart->toDateString());
            })
            ->whereNull('tickets.closed_at')
            ->selectRaw('tickets.responsable_id, COALESCE(users.name, ?) as responsable, COUNT(DISTINCT tickets.id) as open_tickets, COUNT(DISTINCT CASE WHEN ticket_sla.estado_sla = ? THEN tickets.id END) as overdue_tickets, COALESCE(SUM(ticket_tiempos.minutos), 0) as time_this_week', ['Sin responsable', 'vencido'])
            ->groupBy('tickets.responsable_id', 'users.name')
            ->orderByDesc('open_tickets')
            ->limit(10)
            ->get();
    }

    private function ticketsByPriority()
    {
        return Ticket::query()
            ->join('cat_ticket_prioridades', 'cat_ticket_prioridades.id', '=', 'tickets.prioridad_id')
            ->whereNull('tickets.closed_at')
            ->select('cat_ticket_prioridades.nombre as prioridad', DB::raw('COUNT(*) as total'))
            ->groupBy('cat_ticket_prioridades.nombre', 'cat_ticket_prioridades.orden')
            ->orderBy('cat_ticket_prioridades.orden')
            ->get();
    }

    private function stateId(string $name): ?int
    {
        return CatTicketEstado::query()->where('nombre', $name)->value('id');
    }

    private function stateIds(array $names): array
    {
        return CatTicketEstado::query()->whereIn('nombre', $names)->pluck('id')->all();
    }
}
