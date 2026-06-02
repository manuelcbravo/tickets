<?php

namespace App\Services\Development;

use App\Models\Ticket;
use App\Models\TicketDevelopmentLink;
use App\Services\Tickets\TicketHistoryService;
use Illuminate\Validation\ValidationException;

class TicketDevelopmentLinkService
{
    public function __construct(private readonly TicketHistoryService $history)
    {
    }

    public function create(Ticket $ticket, array $data, ?int $userId = null): TicketDevelopmentLink
    {
        if (in_array($data['tipo'], ['pull_request', 'merge_request'], true) && empty($data['url'])) {
            throw ValidationException::withMessages(['url' => 'La URL es obligatoria para pull request o merge request.']);
        }

        if ($data['tipo'] === 'commit' && empty($data['referencia'])) {
            throw ValidationException::withMessages(['referencia' => 'La referencia del commit es obligatoria.']);
        }

        $exists = TicketDevelopmentLink::query()
            ->where('ticket_id', $ticket->id)
            ->where('tipo', $data['tipo'])
            ->where('url', $data['url'] ?? null)
            ->where('referencia', $data['referencia'] ?? null)
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages(['url' => 'Este enlace tecnico ya esta relacionado con el ticket.']);
        }

        $link = TicketDevelopmentLink::query()->create([
            ...$data,
            'ticket_id' => $ticket->id,
            'created_by_id' => $userId,
        ]);

        $this->history->log($ticket, 'development_link_created', $userId, descripcion: "Enlace tecnico agregado: {$link->tipo}.", metadata: ['link_id' => $link->id, 'tipo' => $link->tipo, 'url' => $link->url, 'referencia' => $link->referencia]);

        return $link;
    }

    public function delete(Ticket $ticket, TicketDevelopmentLink $link, ?int $userId = null): void
    {
        abort_unless($link->ticket_id === $ticket->id, 404);

        $metadata = ['link_id' => $link->id, 'tipo' => $link->tipo, 'url' => $link->url, 'referencia' => $link->referencia];
        $link->delete();

        $this->history->log($ticket, 'development_link_deleted', $userId, descripcion: 'Enlace tecnico eliminado.', metadata: $metadata);
    }
}
