<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\AssignTicketRequest;
use App\Models\Ticket;
use App\Services\Tickets\TicketLifecycleService;
use Illuminate\Http\RedirectResponse;

class TicketAssignmentController extends Controller
{
    public function update(AssignTicketRequest $request, Ticket $ticket, TicketLifecycleService $service): RedirectResponse
    {
        $service->assign($ticket, (int) $request->validated('responsable_id'), $request->user()->id);

        return back()->with('success', 'Ticket asignado correctamente.');
    }
}
