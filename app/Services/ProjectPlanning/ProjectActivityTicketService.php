<?php

namespace App\Services\ProjectPlanning;

use App\Models\Proyecto;
use App\Models\ProyectoActividad;
use App\Models\ProyectoActividadTicket;
use App\Models\Ticket;
use App\Services\Tickets\TicketHistoryService;
use App\Services\Tickets\TicketLifecycleService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProjectActivityTicketService
{
    public function link(ProyectoActividad $activity, string $ticketId, string $relationship, ?int $userId): ProyectoActividadTicket
    {
        $ticket = Ticket::query()->findOrFail($ticketId);
        $this->guardSameProject($activity, $ticket);

        try {
            $link = ProyectoActividadTicket::query()->firstOrCreate([
                'actividad_id' => $activity->id,
                'ticket_id' => $ticket->id,
                'tipo_relacion' => $relationship,
            ], [
                'created_by_id' => $userId,
            ]);
        } catch (QueryException) {
            throw ValidationException::withMessages(['ticket_id' => 'Este ticket ya esta relacionado con la actividad.']);
        }

        if ($activity->ticket_id === null) {
            $activity->update(['ticket_id' => $ticket->id]);
        }

        if ($link->wasRecentlyCreated) {
            app(TicketHistoryService::class)->log(
                $ticket,
                'project_activity_linked',
                $userId,
                descripcion: "Actividad de proyecto relacionada: {$activity->titulo}.",
                metadata: ['actividad_id' => $activity->id, 'tipo_relacion' => $relationship],
            );
        }

        return $link;
    }

    public function unlink(ProyectoActividad $activity, Ticket $ticket): void
    {
        ProyectoActividadTicket::query()
            ->where('actividad_id', $activity->id)
            ->where('ticket_id', $ticket->id)
            ->delete();

        if ($activity->ticket_id === $ticket->id) {
            $activity->update(['ticket_id' => null]);
        }
    }

    public function createTicketFromActivity(Proyecto $proyecto, ProyectoActividad $activity, array $data, int $userId): Ticket
    {
        abort_unless($activity->proyecto_id === $proyecto->id, 404);

        return DB::transaction(function () use ($proyecto, $activity, $data, $userId): Ticket {
            $ticket = app(TicketLifecycleService::class)->create([
                'cliente_id' => $proyecto->client_id,
                'proyecto_id' => $proyecto->id,
                'titulo' => $activity->titulo,
                'descripcion' => trim("Actividad de proyecto:\n\n".($activity->descripcion ?: $activity->titulo)),
                'tipo_id' => $data['tipo_id'],
                'prioridad_id' => $data['prioridad_id'],
                'responsable_id' => $activity->responsable_id,
            ], $userId);

            $activity->update(['ticket_id' => $ticket->id]);
            $this->link($activity, $ticket->id, 'ejecucion', $userId);

            return $ticket;
        });
    }

    private function guardSameProject(ProyectoActividad $activity, Ticket $ticket): void
    {
        if ($ticket->proyecto_id && $ticket->proyecto_id !== $activity->proyecto_id) {
            throw ValidationException::withMessages(['ticket_id' => 'El ticket seleccionado pertenece a otro proyecto.']);
        }
    }
}
