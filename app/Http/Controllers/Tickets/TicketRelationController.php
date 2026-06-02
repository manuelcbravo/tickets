<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\StoreTicketRelationRequest;
use App\Models\Ticket;
use App\Models\TicketRelacion;
use App\Services\Tickets\TicketRelationService;
use Illuminate\Http\RedirectResponse;

class TicketRelationController extends Controller
{
    public function store(StoreTicketRelationRequest $request, Ticket $ticket, TicketRelationService $service): RedirectResponse
    {
        $service->create($ticket, $request->validated(), $request->user()->id);

        return back()->with('success', 'Relacion creada.');
    }

    public function destroy(Ticket $ticket, TicketRelacion $relacion, TicketRelationService $service): RedirectResponse
    {
        abort_unless($relacion->ticket_id === $ticket->id, 404);

        $service->delete($relacion, auth()->id());

        return back()->with('success', 'Relacion eliminada.');
    }
}
