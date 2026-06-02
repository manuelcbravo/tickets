<?php

namespace App\Http\Controllers\ProjectPlanning;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectPlanning\MoveProjectActivityKanbanRequest;
use App\Models\Proyecto;
use App\Models\ProyectoActividad;
use App\Services\ProjectPlanning\ProjectActivityService;
use App\Services\ProjectPlanning\ProjectKanbanService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProjectKanbanController extends Controller
{
    public function edit(Proyecto $proyecto, ProyectoActividad $activity, ProjectActivityService $activityService): Response
    {
        $activityService->assertBelongsToProject($proyecto, $activity);

        $activity->load([
            'proyecto:id,nombre,client_id',
            'proyecto.cliente:id,nombre,razon_social',
            'responsable:id,name',
        ]);

        return Inertia::render('activities/kanban/edit', [
            'proyecto' => $proyecto->only(['id', 'nombre']),
            'activity' => $activity,
            'kanbanColumns' => ProyectoActividad::KANBAN_COLUMNS,
        ]);
    }

    public function updateColumn(MoveProjectActivityKanbanRequest $request, Proyecto $proyecto, ProyectoActividad $activity, ProjectKanbanService $service): RedirectResponse
    {
        $service->move($proyecto, $activity, $request->validated('kanban_column'), $request->validated('orden'), $request->user()->id);

        return back()->with('success', 'Actividad movida en el kanban.');
    }

    public function updateOrder(MoveProjectActivityKanbanRequest $request, Proyecto $proyecto, ProyectoActividad $activity, ProjectKanbanService $service): RedirectResponse
    {
        $service->move($proyecto, $activity, $request->validated('kanban_column'), $request->validated('orden'), $request->user()->id);

        return back()->with('success', 'Orden actualizado.');
    }
}
