<?php

namespace App\Http\Controllers\ProjectPlanning;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectPlanning\MoveProjectActivityKanbanRequest;
use App\Models\Proyecto;
use App\Models\ProyectoActividad;
use App\Services\ProjectPlanning\ProjectKanbanService;
use Illuminate\Http\RedirectResponse;

class ProjectKanbanController extends Controller
{
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
