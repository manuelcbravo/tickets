<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\StoreTicketMessageRequest;
use App\Models\Ticket;
use App\Services\Tickets\TicketHistoryService;
use App\Services\Tickets\TicketSlaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class TicketMessageController extends Controller
{
    public function store(StoreTicketMessageRequest $request, Ticket $ticket, TicketHistoryService $history, TicketSlaService $sla): RedirectResponse
    {
        if ($ticket->closed_at) {
            throw ValidationException::withMessages([
                'mensaje' => 'No se puede comentar directamente un ticket cerrado. Reabre el ticket antes de responder.',
            ]);
        }

        $message = $ticket->mensajes()->create([
            ...$request->validated(),
            'usuario_id' => $request->user()->id,
        ]);

        $history->log(
            $ticket,
            'comment_added',
            $request->user()->id,
            descripcion: 'Comentario agregado.',
            metadata: ['message_id' => $message->id],
        );

        if (! $message->es_interno) {
            $sla->recordFirstResponse($ticket->refresh(), $request->user()->id, $message->created_at);
        }

        return back()->with('success', 'Comentario agregado correctamente.');
    }
}
