<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\StoreTicketChecklistItemRequest;
use App\Http\Requests\Tickets\UpdateTicketChecklistItemRequest;
use App\Models\Ticket;
use App\Models\TicketChecklistItem;
use App\Services\Tickets\TicketChecklistService;
use Illuminate\Http\RedirectResponse;

class TicketChecklistController extends Controller
{
    public function store(StoreTicketChecklistItemRequest $request, Ticket $ticket, TicketChecklistService $service): RedirectResponse
    {
        $service->create($ticket, $request->validated(), $request->user()->id);

        return back()->with('success', 'Item agregado al checklist.');
    }

    public function update(UpdateTicketChecklistItemRequest $request, Ticket $ticket, TicketChecklistItem $item, TicketChecklistService $service): RedirectResponse
    {
        abort_unless($item->ticket_id === $ticket->id, 404);

        $service->update($item, $request->validated(), $request->user()->id);

        return back()->with('success', 'Checklist actualizado.');
    }

    public function destroy(Ticket $ticket, TicketChecklistItem $item, TicketChecklistService $service): RedirectResponse
    {
        abort_unless($item->ticket_id === $ticket->id, 404);

        $service->delete($item, auth()->id());

        return back()->with('success', 'Item eliminado del checklist.');
    }
}
