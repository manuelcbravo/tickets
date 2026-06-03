<?php

namespace App\Http\Controllers\ProjectPlanning;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectPlanning\CreateTicketFromActivityRequest;
use App\Http\Requests\ProjectPlanning\MoveProjectActivityKanbanRequest;
use App\Http\Requests\ProjectPlanning\StoreGlobalProjectActivityRequest;
use App\Http\Requests\ProjectPlanning\StoreProjectActivityRequest;
use App\Http\Requests\ProjectPlanning\UpdateProjectActivityRequest;
use App\Models\CatTicketPrioridad;
use App\Models\CatTicketTipo;
use App\Models\Proyecto;
use App\Models\ProyectoActividad;
use App\Models\User;
use App\Services\ProjectPlanning\ProjectActivityService;
use App\Services\ProjectPlanning\ProjectActivityTicketService;
use App\Services\ProjectPlanning\ProjectKanbanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectActivityController extends Controller
{
    public function index(Request $request): Response
    {
        return $this->renderModule($request, 'list');
    }

    public function dashboard(Request $request): Response
    {
        return $this->renderModule($request, 'dashboard');
    }

    public function completed(Request $request): Response
    {
        return $this->renderModule($request, 'done');
    }

    public function show(ProyectoActividad $activity): Response
    {
        $activity->load([
            'proyecto:id,nombre,client_id',
            'proyecto.cliente:id,nombre,razon_social',
            'responsable:id,name',
            'reportadoPor:id,name',
            'createdBy:id,name',
            'updatedBy:id,name',
            'ticket:id,folio,titulo',
            'parent:id,titulo,estado',
            'children:id,parent_id,titulo,estado,prioridad,kanban_column',
            'tiempos.usuario:id,name',
            'ticketLinks.ticket:id,folio,titulo',
            'files',
        ]);

        return Inertia::render('activities/show', [
            'activity' => $activity,
            'estadoOptions' => ProyectoActividad::ESTADOS,
        ]);
    }

    private function renderModule(Request $request, string $initialView): Response
    {
        $initialView = $this->requestedActivityView($request, $initialView);

        $activities = ProyectoActividad::query()
            ->with([
                'proyecto:id,nombre,client_id',
                'proyecto.cliente:id,nombre,razon_social',
                'responsable:id,name',
                'reportadoPor:id,name',
                'createdBy:id,name',
                'updatedBy:id,name',
                'ticket:id,folio,titulo',
                'parent:id,titulo,estado,prioridad,kanban_column',
                'children:id,parent_id,titulo,estado,prioridad,kanban_column',
                'tiempos.usuario:id,name',
                'ticketLinks.ticket:id,folio,titulo',
                'files',
            ])
            ->orderByRaw('fecha_limite is null')
            ->orderBy('fecha_limite')
            ->latest()
            ->get();

        $userId = $request->user()->id;

        return Inertia::render('activities/index', [
            'activities' => $activities,
            'currentProject' => null,
            'projects' => Proyecto::query()
                ->with('cliente:id,nombre,razon_social')
                ->orderBy('nombre')
                ->get(['id', 'nombre', 'client_id']),
            'users' => User::query()->orderBy('name')->get(['id', 'name']),
            'estadoOptions' => ProyectoActividad::ESTADOS,
            'prioridadOptions' => ProyectoActividad::PRIORIDADES,
            'tipoOptions' => ProyectoActividad::TIPOS,
            'kanbanColumns' => array_values(array_filter(
                ProyectoActividad::KANBAN_COLUMNS,
                fn (string $column) => $column !== 'terminado',
            )),
            'initialView' => $initialView,
            'metrics' => [
                'total' => $activities->count(),
                'mine' => $activities->where('responsable_id', $userId)->count(),
                'completed' => $activities->where('estado', 'terminada')->count(),
                'in_progress' => $activities->whereIn('estado', ['en_proceso', 'en_revision'])->count(),
                'overdue' => $activities
                    ->filter(fn (ProyectoActividad $activity) => $activity->fecha_limite && $activity->fecha_limite->isPast() && ! in_array($activity->estado, ['terminada', 'cancelada'], true))
                    ->count(),
                'estimated_minutes' => $activities->sum('minutos_estimados'),
                'real_minutes' => $activities->sum('minutos_reales'),
            ],
        ]);
    }

    private function requestedActivityView(Request $request, string $fallback): string
    {
        $view = $request->query('view');

        return in_array($view, ['list', 'kanban', 'schedule'], true)
            ? $view
            : $fallback;
    }

    public function storeGlobal(StoreGlobalProjectActivityRequest $request, ProjectActivityService $service): RedirectResponse
    {
        $data = $request->validated();
        $proyecto = Proyecto::query()->findOrFail($data['proyecto_id']);
        unset($data['proyecto_id']);

        $service->create($proyecto, $data, $request->user()->id);

        return back()->with('success', 'Actividad creada correctamente.');
    }

    public function updateGlobal(UpdateProjectActivityRequest $request, ProyectoActividad $activity, ProjectActivityService $service): RedirectResponse
    {
        $service->update($activity->proyecto, $activity, $request->validated(), $request->user()->id);

        return back()->with('success', 'Actividad actualizada correctamente.');
    }

    public function destroyGlobal(ProyectoActividad $activity, ProjectActivityService $service): RedirectResponse
    {
        $service->delete($activity->proyecto, $activity);

        return back()->with('success', 'Actividad eliminada correctamente.');
    }

    public function completeGlobal(ProyectoActividad $activity, ProjectActivityService $service): RedirectResponse
    {
        $service->complete($activity->proyecto, $activity, auth()->id());

        return back()->with('success', 'Actividad marcada como terminada.');
    }

    public function cancelGlobal(ProyectoActividad $activity, ProjectActivityService $service): RedirectResponse
    {
        $service->cancel($activity->proyecto, $activity, auth()->id());

        return back()->with('success', 'Actividad cancelada.');
    }

    public function kanbanGlobal(MoveProjectActivityKanbanRequest $request, ProyectoActividad $activity, ProjectKanbanService $service): RedirectResponse
    {
        $data = $request->validated();

        $service->move(
            $activity->proyecto,
            $activity,
            $data['kanban_column'],
            $request->integer('orden') ?: null,
            $request->user()->id,
        );

        return back()->with('success', 'Actividad movida correctamente.');
    }

    public function store(StoreProjectActivityRequest $request, Proyecto $proyecto, ProjectActivityService $service): RedirectResponse
    {
        $service->create($proyecto, $request->validated(), $request->user()->id);

        return back()->with('success', 'Actividad creada correctamente.');
    }

    public function update(UpdateProjectActivityRequest $request, Proyecto $proyecto, ProyectoActividad $activity, ProjectActivityService $service): RedirectResponse
    {
        $service->update($proyecto, $activity, $request->validated(), $request->user()->id);

        return back()->with('success', 'Actividad actualizada correctamente.');
    }

    public function destroy(Proyecto $proyecto, ProyectoActividad $activity, ProjectActivityService $service): RedirectResponse
    {
        $service->delete($proyecto, $activity);

        return back()->with('success', 'Actividad eliminada correctamente.');
    }

    public function complete(Proyecto $proyecto, ProyectoActividad $activity, ProjectActivityService $service): RedirectResponse
    {
        $service->complete($proyecto, $activity, auth()->id());

        return back()->with('success', 'Actividad marcada como terminada.');
    }

    public function cancel(Proyecto $proyecto, ProyectoActividad $activity, ProjectActivityService $service): RedirectResponse
    {
        $service->cancel($proyecto, $activity, auth()->id());

        return back()->with('success', 'Actividad cancelada.');
    }

    public function createTicketForm(Proyecto $proyecto, ProyectoActividad $activity, ProjectActivityService $service): Response
    {
        $service->assertBelongsToProject($proyecto, $activity);

        $activity->load([
            'proyecto:id,nombre,client_id',
            'proyecto.cliente:id,nombre,razon_social',
            'responsable:id,name',
        ]);

        return Inertia::render('activities/tickets/from-activity', [
            'proyecto' => $proyecto->only(['id', 'nombre']),
            'activity' => $activity,
            'ticketTypes' => CatTicketTipo::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
            'ticketPriorities' => CatTicketPrioridad::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
        ]);
    }

    public function createTicket(CreateTicketFromActivityRequest $request, Proyecto $proyecto, ProyectoActividad $activity, ProjectActivityTicketService $service): RedirectResponse
    {
        $ticket = $service->createTicketFromActivity($proyecto, $activity, $request->validated(), $request->user()->id);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Ticket creado desde la actividad.');
    }
}
