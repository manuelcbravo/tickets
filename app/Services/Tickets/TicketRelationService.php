<?php

namespace App\Services\Tickets;

use App\Models\Ticket;
use App\Models\TicketRelacion;
use Illuminate\Validation\ValidationException;

class TicketRelationService
{
    public function create(Ticket $ticket, array $data, ?int $usuarioId): TicketRelacion
    {
        if ($ticket->id === $data['related_ticket_id']) {
            throw ValidationException::withMessages([
                'related_ticket_id' => 'Un ticket no puede relacionarse consigo mismo.',
            ]);
        }

        if ($ticket->relacionesOrigen()
            ->where('related_ticket_id', $data['related_ticket_id'])
            ->where('tipo', $data['tipo'])
            ->exists()) {
            throw ValidationException::withMessages([
                'related_ticket_id' => 'Esta relacion ya existe para el ticket.',
            ]);
        }

        $relation = $ticket->relacionesOrigen()->create([
            ...$data,
            'created_by_id' => $usuarioId,
        ]);

        app(TicketHistoryService::class)->log(
            $ticket,
            'ticket_relation_created',
            $usuarioId,
            descripcion: 'Relacion entre tickets creada.',
            metadata: ['relation_id' => $relation->id, 'tipo' => $relation->tipo],
        );

        return $relation;
    }

    public function delete(TicketRelacion $relation, ?int $usuarioId): void
    {
        $ticket = $relation->ticket;
        $relationId = $relation->id;
        $relation->delete();

        app(TicketHistoryService::class)->log(
            $ticket,
            'ticket_relation_deleted',
            $usuarioId,
            descripcion: 'Relacion entre tickets eliminada.',
            metadata: ['relation_id' => $relationId],
        );
    }
}
