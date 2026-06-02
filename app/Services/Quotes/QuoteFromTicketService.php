<?php

namespace App\Services\Quotes;

use App\Models\Ticket;
use App\Services\Tickets\TicketHistoryService;

class QuoteFromTicketService
{
    public function __construct(
        private readonly QuoteService $quoteService,
        private readonly TicketHistoryService $history,
    ) {}

    public function create(Ticket $ticket, array $data, int $userId): \App\Models\Cotizacion
    {
        $includeDescription = $data['incluir_descripcion_ticket'] ?? true;

        $cotizacion = $this->quoteService->create([
            'cliente_id' => $ticket->cliente_id,
            'proyecto_id' => $ticket->proyecto_id,
            'contacto_id' => $ticket->contacto_id,
            'ticket_origen_id' => $ticket->id,
            'titulo' => $data['titulo'] ?: "Cotizacion {$ticket->folio} - {$ticket->titulo}",
            'descripcion' => $includeDescription ? $ticket->descripcion : null,
            'alcance' => $data['alcance'] ?? "Definir alcance para {$ticket->folio}: {$ticket->titulo}",
            'moneda' => 'MXN',
        ], $userId);

        $ticket->update([
            'requires_quote' => true,
            'quote_status' => 'cotizado',
            'quote_id' => $cotizacion->id,
        ]);

        $this->history->log($ticket, 'ticket_marked_requires_quote', $userId, 'Ticket marcado como requiere cotizacion.', metadata: [
            'cotizacion_id' => $cotizacion->id,
            'folio' => $cotizacion->folio,
        ]);

        return $cotizacion;
    }

    public function markRequired(Ticket $ticket, int $userId): Ticket
    {
        $ticket->update([
            'requires_quote' => true,
            'quote_status' => $ticket->quote_status ?: 'pendiente',
        ]);

        $this->history->log($ticket, 'ticket_marked_requires_quote', $userId, 'Ticket marcado como sujeto a cotizacion.');

        return $ticket->refresh();
    }
}
