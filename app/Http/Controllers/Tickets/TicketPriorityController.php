<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\UpdateTicketPriorityRequest;
use App\Models\Ticket;
use App\Services\Tickets\TicketPriorityService;
use Illuminate\Http\RedirectResponse;

class TicketPriorityController extends Controller
{
    public function update(UpdateTicketPriorityRequest $request, Ticket $ticket, TicketPriorityService $service): RedirectResponse
    {
        $service->update($ticket, (int) $request->validated('prioridad_id'), $request->user()->id, $request->validated('motivo'));

        return back()->with('success', 'Prioridad actualizada.');
    }
}
