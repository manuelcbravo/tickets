<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\ApplyTicketAiActionRequest;
use App\Http\Requests\Tickets\RejectTicketAiActionRequest;
use App\Models\AiAction;
use App\Models\Ticket;
use App\Services\Tickets\TicketAiActionService;
use Illuminate\Http\RedirectResponse;

class TicketAiActionController extends Controller
{
    public function apply(ApplyTicketAiActionRequest $request, Ticket $ticket, AiAction $action, TicketAiActionService $service): RedirectResponse
    {
        abort_unless($action->ticket_id === $ticket->id, 404);

        $service->apply($action, $request->user()->id);

        return back()->with('success', 'Accion de IA marcada como aplicada.');
    }

    public function reject(RejectTicketAiActionRequest $request, Ticket $ticket, AiAction $action, TicketAiActionService $service): RedirectResponse
    {
        abort_unless($action->ticket_id === $ticket->id, 404);

        $service->reject($action, $request->user()->id, $request->validated('reason'));

        return back()->with('success', 'Accion de IA rechazada.');
    }
}
