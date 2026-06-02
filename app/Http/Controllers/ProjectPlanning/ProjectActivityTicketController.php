<?php

namespace App\Http\Controllers\ProjectPlanning;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectPlanning\LinkProjectActivityTicketRequest;
use App\Models\Proyecto;
use App\Models\ProyectoActividad;
use App\Models\ProyectoActividadTicket;
use App\Models\Ticket;
use App\Services\ProjectPlanning\ProjectActivityService;
use App\Services\ProjectPlanning\ProjectActivityTicketService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProjectActivityTicketController extends Controller
{
    public function create(Proyecto $proyecto, ProyectoActividad $activity, ProjectActivityService $activityService): Response
    {
        $activityService->assertBelongsToProject($proyecto, $activity);

        $activity->load([
            'proyecto:id,nombre,client_id',
            'proyecto.cliente:id,nombre,razon_social',
            'responsable:id,name',
            'ticket:id,folio,titulo',
        ]);

        return Inertia::render('activities/tickets/create', [
            'proyecto' => $proyecto->only(['id', 'nombre']),
            'activity' => $activity,
            'tickets' => Ticket::query()
                ->where('proyecto_id', $proyecto->id)
                ->orderByDesc('created_at')
                ->limit(200)
                ->get(['id', 'proyecto_id', 'folio', 'titulo']),
            'ticketRelationTypes' => ProyectoActividadTicket::TIPOS,
        ]);
    }

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
