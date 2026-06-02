<?php

namespace App\Http\Controllers\Proyectos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Proyectos\StoreProyectoRequest;
use App\Http\Requests\Proyectos\UpdateProyectoRequest;
use App\Models\Client;
use App\Models\Proyecto;
use App\Models\Ticket;
use App\Models\User;
use App\Services\ProjectPlanning\ProjectPlanningService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProyectoController extends Controller
{
    public function index(): Response
    {
        $user = request()->user();
        $canViewProjectFiles = $user?->can('project-planning.documents.view')
            || $user?->can('project-planning.documents.manage');
        $relations = ['cliente:id,nombre,razon_social,estatus', 'responsableTecnico:id,name'];

        if ($canViewProjectFiles) {
            $relations[] = 'files';
        }

        return Inertia::render('proyectos/index', [
            'proyectos' => Proyecto::query()
                ->with($relations)
                ->latest()
                ->get(),
            'estadoOptions' => Proyecto::ESTADOS,
            'criticidadOptions' => Proyecto::CRITICIDADES,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('proyectos/create', $this->formProps());
    }

    public function store(StoreProyectoRequest $request): RedirectResponse
    {
        $proyecto = Proyecto::query()->create($request->validated());

        return redirect()
            ->route('proyectos.show', $proyecto)
            ->with('success', 'Proyecto creado correctamente.');
    }

    public function show(Proyecto $proyecto, ProjectPlanningService $planningService): Response
    {
        $proyecto->load([
            'cliente:id,nombre,razon_social,estatus',
            'responsableTecnico:id,name',
            'responsablePlaneacion:id,name',
            'planCobro:id,proyecto_id,tipo_cobro,estado,activo,monto_total,monto_mensual,fecha_inicio,fecha_fin',
        ]);

        $planningMetrics = $planningService->metrics($proyecto);
        $openTicketStatuses = ['cerrado', 'resuelto', 'cancelado'];

        return Inertia::render('proyectos/show', [
            'proyecto' => $proyecto,
            'summary' => [
                'total_documentos' => $proyecto->files()->count(),
                'total_actividades' => $planningMetrics['actividades_totales'],
                'actividades_pendientes' => $planningMetrics['actividades_pendientes'],
                'actividades_vencidas' => $planningMetrics['actividades_vencidas'],
                'avance_calculado' => $planningMetrics['avance_calculado'],
                'tiempo_estimado' => $planningMetrics['tiempo_estimado'],
                'tiempo_real' => $planningMetrics['tiempo_real'],
                'total_tickets' => Ticket::query()->where('proyecto_id', $proyecto->id)->count(),
                'tickets_abiertos' => Ticket::query()
                    ->where('proyecto_id', $proyecto->id)
                    ->whereDoesntHave('estado', fn ($query) => $query->whereIn('nombre', $openTicketStatuses))
                    ->count(),
                'saldo_pendiente' => (float) $proyecto->saldo_pendiente,
                'saldo_vencido' => (float) $proyecto->saldo_vencido,
                'total_cargos' => $proyecto->cargos()->count(),
                'total_pagos' => $proyecto->pagos()->count(),
                'total_ambientes' => $proyecto->ambientes()->count(),
                'total_modulos' => $proyecto->modulos()->count(),
            ],
        ]);
    }

    public function edit(Proyecto $proyecto): Response
    {
        return Inertia::render('proyectos/edit', [
            ...$this->formProps(),
            'proyecto' => $proyecto,
        ]);
    }

    public function update(UpdateProyectoRequest $request, Proyecto $proyecto): RedirectResponse
    {
        $proyecto->update($request->validated());

        return redirect()
            ->route('proyectos.show', $proyecto)
            ->with('success', 'Proyecto actualizado correctamente.');
    }

    public function destroy(Proyecto $proyecto): RedirectResponse
    {
        $proyecto->delete();

        return redirect()
            ->route('proyectos.index')
            ->with('success', 'Proyecto eliminado correctamente.');
    }

    private function formProps(): array
    {
        return [
            'clientes' => Client::query()
                ->orderByRaw("case when estatus in ('suspendido', 'moroso') then 1 else 0 end")
                ->orderBy('nombre')
                ->get(['id', 'nombre', 'razon_social', 'estatus']),
            'users' => User::query()->orderBy('name')->get(['id', 'name']),
            'estadoOptions' => Proyecto::ESTADOS,
            'criticidadOptions' => Proyecto::CRITICIDADES,
        ];
    }
}
