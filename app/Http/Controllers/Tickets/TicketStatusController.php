<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\ChangeTicketStatusRequest;
use App\Http\Requests\Tickets\CloseTicketRequest;
use App\Http\Requests\Tickets\ReopenTicketRequest;
use App\Models\Ticket;
use App\Services\Tickets\TicketStatusService;
use Illuminate\Http\RedirectResponse;

class TicketStatusController extends Controller
{
    public function update(ChangeTicketStatusRequest $request, Ticket $ticket, TicketStatusService $service): RedirectResponse
    {
        $service->changeStatus($ticket, (int) $request->validated('estado_id'), $request->user()->id);

        return back()->with('success', 'Estado actualizado correctamente.');
    }

    public function close(CloseTicketRequest $request, Ticket $ticket, TicketStatusService $service): RedirectResponse
    {
        $service->close($ticket, $request->validated('resolution'), $request->user(), $request->validated('force_reason'));

        return back()->with('success', 'Ticket cerrado correctamente.');
    }

    public function reopen(ReopenTicketRequest $request, Ticket $ticket, TicketStatusService $service): RedirectResponse
    {
        $validated = $request->validated();
        $service->reopen($ticket, $validated['reason'] ?? $validated['motivo'], $request->user()->id, $validated['root_cause'] ?? null, $validated['notes'] ?? null);

        return back()->with('success', 'Ticket reabierto correctamente.');
    }
}
