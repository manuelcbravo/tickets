<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\StoreTicketRequest;
use App\Http\Requests\Tickets\UpdateTicketRequest;
use App\Models\Ambiente;
use App\Models\CatTicketEstado;
use App\Models\CatTicketImpacto;
use App\Models\CatTicketPrioridad;
use App\Models\CatTicketRiesgo;
use App\Models\CatTicketTipo;
use App\Models\CatTicketUrgencia;
use App\Models\Client;
use App\Models\ClienteContacto;
use App\Models\Cotizacion;
use App\Models\KnowledgeArticle;
use App\Models\Proyecto;
use App\Models\ProyectoModulo;
use App\Models\Release;
use App\Models\Repositorio;
use App\Models\Ticket;
use App\Models\TicketDevelopmentTask;
use App\Models\User;
use App\Services\Tickets\TicketLifecycleService;
use App\Services\AI\AiClientService;
use App\Services\QA\TicketCloseGuardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TicketController extends Controller
{
    public function index(Request $request): Response
    {
        $tickets = Ticket::query()
            ->with(['cliente:id,nombre,razon_social', 'proyecto:id,nombre', 'responsable:id,name', 'estado:id,nombre', 'prioridad:id,nombre', 'tipo:id,nombre', 'sla'])
            ->when($request->string('search')->toString(), function ($query, string $search): void {
                $query->where(function ($nested) use ($search): void {
                    $nested->where('folio', 'ilike', "%{$search}%")
                        ->orWhere('titulo', 'ilike', "%{$search}%")
                        ->orWhere('descripcion', 'ilike', "%{$search}%");
                });
            })
            ->when($request->input('cliente_id'), fn ($query, $value) => $query->where('cliente_id', $value))
            ->when($request->input('proyecto_id'), fn ($query, $value) => $query->where('proyecto_id', $value))
            ->when($request->input('estado_id'), fn ($query, $value) => $query->where('estado_id', $value))
            ->when($request->input('prioridad_id'), fn ($query, $value) => $query->where('prioridad_id', $value))
            ->when($request->input('responsable_id'), fn ($query, $value) => $query->where('responsable_id', $value))
            ->when($request->input('tipo_id'), fn ($query, $value) => $query->where('tipo_id', $value))
            ->when($request->input('quick_filter'), function ($query, string $value): void {
                $query->when($value === 'pendientes_triage', fn ($nested) => $nested->whereHas('estado', fn ($state) => $state->whereIn('nombre', ['Nuevo', 'En triage', 'Reabierto'])))
                    ->when($value === 'falta_informacion', fn ($nested) => $nested->whereHas('estado', fn ($state) => $state->where('nombre', 'Falta informacion')))
                    ->when($value === 'priorizados', fn ($nested) => $nested->whereHas('estado', fn ($state) => $state->where('nombre', 'Priorizado')))
                    ->when($value === 'mis_por_analizar', fn ($nested) => $nested
                        ->where('responsable_id', auth()->id())
                        ->whereHas('estado', fn ($state) => $state->whereIn('nombre', ['Priorizado', 'En analisis'])))
                    ->when($value === 'vencidos', fn ($nested) => $nested->whereHas('sla', fn ($sla) => $sla->where('estado_sla', 'vencido')))
                    ->when($value === 'en_riesgo', fn ($nested) => $nested->whereHas('sla', fn ($sla) => $sla->where('estado_sla', 'en_riesgo')))
                    ->when($value === 'sin_tiempo', fn ($nested) => $nested->where('tiempo_real_min', 0))
                    ->when($value === 'con_tiempo_facturable', fn ($nested) => $nested->whereHas('tiempos', fn ($tiempos) => $tiempos->where('es_facturable', true)))
                    ->when($value === 'mis_vencidos', fn ($nested) => $nested->where('responsable_id', auth()->id())->whereHas('sla', fn ($sla) => $sla->where('estado_sla', 'vencido')));
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('tickets/index', [
            'tickets' => $tickets,
            'filters' => $request->only(['search', 'cliente_id', 'proyecto_id', 'estado_id', 'prioridad_id', 'responsable_id', 'tipo_id', 'quick_filter']),
            ...$this->options(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('tickets/create', $this->options());
    }

    public function store(StoreTicketRequest $request, TicketLifecycleService $service): RedirectResponse
    {
        $ticket = $service->create($request->validated(), $request->user()->id);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Ticket creado correctamente.');
    }

    public function show(Ticket $ticket): Response
    {
        $aiClient = app(AiClientService::class);
        $closeGuard = app(TicketCloseGuardService::class);

        $ticket->load([
            'cliente:id,nombre,razon_social',
            'proyecto:id,nombre,saldo_pendiente,saldo_vencido,ultimo_pago_at,proximo_vencimiento_at,billing_status',
            'modulo:id,nombre',
            'contacto:id,nombre,email,telefono',
            'ambiente:id,nombre,url',
            'creadoPor:id,name',
            'responsable:id,name',
            'cerradoPor:id,name',
            'reabiertoPor:id,name',
            'tipo:id,nombre',
            'estado:id,nombre',
            'prioridad:id,nombre',
            'impacto:id,nombre',
            'urgencia:id,nombre',
            'riesgo:id,nombre',
            'mensajes.usuario:id,name',
            'adjuntos.usuario:id,name',
            'historial.usuario:id,name',
            'checklistItems.completadoPor:id,name',
            'relacionesOrigen.relatedTicket:id,folio,titulo',
            'relacionesOrigen.createdBy:id,name',
            'triageBy:id,name',
            'prioritizedBy:id,name',
            'tiempos.usuario:id,name',
            'sla.politica:id,nombre',
            'sla.prioridad:id,nombre',
            'knowledgeArticles:id,titulo,estatus,visibilidad,tipo',
            'aiAnalyses.user:id,name',
            'aiAnalyses.suggestedType:id,nombre',
            'aiAnalyses.suggestedPriority:id,nombre',
            'aiAnalyses.suggestedImpact:id,nombre',
            'aiAnalyses.suggestedUrgency:id,nombre',
            'aiAnalyses.suggestedRisk:id,nombre',
            'aiActions.user:id,name',
            'developmentTasks.repositorio:id,nombre,url',
            'developmentTasks.asignadoA:id,name',
            'developmentTasks.reviewedBy:id,name',
            'proyectoActividades.proyecto:id,nombre',
            'proyectoActividades.responsable:id,name',
            'developmentLinks.createdBy:id,name',
            'releases:id,nombre,version,estado,ambiente_id,scheduled_at,released_at',
            'releases.ambiente:id,nombre',
            'testCases.createdBy:id,name',
            'testResults.testCase:id,titulo',
            'testResults.developmentTask:id,titulo',
            'testResults.executedBy:id,name',
            'testResults.evidences',
            'testEvidences.testResult:id,titulo',
            'testEvidences.adjunto:id,nombre_original,ruta,mime_type,size,disk',
            'testEvidences.uploadedBy:id,name',
            'validations.validatedBy:id,name',
            'reopenLogs.reopenedBy:id,name',
            'qaApprovedBy:id,name',
            'validatedBy:id,name',
            'cotizacionPrincipal:id,folio,titulo,estado,total',
            'cotizaciones:id,folio,titulo,estado,total',
            'notificationLogs.user:id,name',
            'notificationLogs.integration:id,nombre,tipo,proveedor',
            'webhookEvents.integration:id,nombre,tipo,proveedor',
            'externalMessages.integration:id,nombre,tipo,proveedor',
        ]);

        return Inertia::render('tickets/show', [
            'ticket' => $ticket,
            'knowledgeArticles' => KnowledgeArticle::query()
                ->where('estatus', '!=', 'archivado')
                ->orderByRaw("CASE estatus WHEN 'publicado' THEN 0 ELSE 1 END")
                ->orderByDesc('updated_at')
                ->limit(100)
                ->get(['id', 'titulo', 'estatus', 'visibilidad', 'tipo']),
            'aiConfig' => [
                'enabled' => (bool) config('ai.enabled'),
                'configured' => $aiClient->isConfigured(),
                'model' => config('ai.model'),
            ],
            'repositories' => Repositorio::query()
                ->when($ticket->proyecto_id, fn ($query) => $query->where('proyecto_id', $ticket->proyecto_id))
                ->orderBy('nombre')
                ->get(['id', 'proyecto_id', 'nombre', 'url', 'rama_principal', 'activo']),
            'developmentTaskOptions' => [
                'types' => TicketDevelopmentTask::TIPOS,
                'statuses' => TicketDevelopmentTask::ESTADOS,
            ],
            'releaseOptions' => Release::query()
                ->when($ticket->proyecto_id, fn ($query) => $query->where('proyecto_id', $ticket->proyecto_id))
                ->orderByDesc('created_at')
                ->get(['id', 'nombre', 'version', 'estado']),
            'qaOptions' => [
                'testCaseTypes' => \App\Models\TestCase::TIPOS,
                'testResultStatuses' => \App\Models\TicketTestResult::STATUSES,
                'evidenceTypes' => \App\Models\TicketTestEvidence::TIPOS,
                'validationTypes' => \App\Models\TicketValidation::TIPOS,
                'rootCauses' => \App\Models\TicketReopenLog::ROOT_CAUSES,
                'requiresQa' => $closeGuard->requiresQa($ticket),
                'closeBlockers' => $closeGuard->blockers($ticket),
            ],
            'quoteOptions' => [
                'relatedQuotes' => Cotizacion::query()
                    ->where('cliente_id', $ticket->cliente_id)
                    ->when($ticket->proyecto_id, fn ($query) => $query->where(function ($nested) use ($ticket) {
                        $nested->whereNull('proyecto_id')->orWhere('proyecto_id', $ticket->proyecto_id);
                    }))
                    ->latest()
                    ->limit(50)
                    ->get(['id', 'folio', 'titulo', 'estado', 'total']),
            ],
            'integrationOptions' => [
                'mailEnabled' => (bool) config('integrations.email.enabled'),
            ],
            'billingOptions' => [
                'overdueCharges' => \App\Models\ProyectoCargo::query()
                    ->when($ticket->proyecto_id, fn ($query) => $query->where('proyecto_id', $ticket->proyecto_id), fn ($query) => $query->whereRaw('1 = 0'))
                    ->where('estado', 'vencido')
                    ->orderBy('fecha_vencimiento')
                    ->limit(5)
                    ->get(['id', 'folio', 'concepto', 'fecha_vencimiento', 'saldo']),
            ],
            ...$this->options(),
        ]);
    }

    public function edit(Ticket $ticket): Response
    {
        return Inertia::render('tickets/edit', [
            'ticket' => $ticket,
            ...$this->options(),
        ]);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket, TicketLifecycleService $service): RedirectResponse
    {
        $service->update($ticket, $request->validated(), $request->user()->id);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Ticket actualizado correctamente.');
    }

    public function destroy(Ticket $ticket): RedirectResponse
    {
        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket eliminado correctamente.');
    }

    private function options(): array
    {
        return [
            'clientes' => Client::query()->orderBy('nombre')->get(['id', 'nombre', 'razon_social', 'estatus']),
            'proyectos' => Proyecto::query()->orderBy('nombre')->get(['id', 'client_id', 'nombre']),
            'modulos' => ProyectoModulo::query()->orderBy('orden')->orderBy('nombre')->get(['id', 'project_id', 'nombre']),
            'contactos' => ClienteContacto::query()->orderBy('nombre')->get(['id', 'client_id', 'nombre', 'email']),
            'ambientes' => Ambiente::query()->orderBy('nombre')->get(['id', 'project_id', 'nombre', 'url']),
            'users' => User::query()->orderBy('name')->get(['id', 'name']),
            'tipos' => CatTicketTipo::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
            'estados' => CatTicketEstado::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
            'prioridades' => CatTicketPrioridad::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
            'impactos' => CatTicketImpacto::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
            'urgencias' => CatTicketUrgencia::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
            'riesgos' => CatTicketRiesgo::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
        ];
    }
}
