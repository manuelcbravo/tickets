<?php

namespace App\Http\Controllers\ProjectPlanning;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectPlanning\LinkProjectActivityTicketRequest;
use App\Models\Proyecto;
use App\Models\ProyectoActividad;
use App\Models\Ticket;
use App\Services\ProjectPlanning\ProjectActivityService;
use App\Services\ProjectPlanning\ProjectActivityTicketService;
use Illuminate\Http\RedirectResponse;

class ProjectActivityTicketController extends Controller
{
    public function store(LinkProjectActivityTicketRequest $request, Proyecto $proyecto, ProyectoActividad $activity, ProjectActivityService $activityService, ProjectActivityTicketService $service): RedirectResponse
    {
        $activityService->assertBelongsToProject($proyecto, $activity);
        $service->link($activity, $request->validated('ticket_id'), $request->validated('tipo_relacion'), $request->user()->id);

        return back()->with('success', 'Ticket relacionado con la actividad.');
    }

    public function destroy(Proyecto $proyecto, ProyectoActividad $activity, Ticket $ticket, ProjectActivityService $activityService, ProjectActivityTicketService $service): RedirectResponse
    {
        $activityService->assertBelongsToProject($proyecto, $activity);
        $service->unlink($activity, $ticket);

        return back()->with('success', 'Relacion eliminada correctamente.');
    }
}
