<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\StoreTicketTimeRequest;
use App\Http\Requests\Tickets\UpdateTicketTimeRequest;
use App\Models\Ticket;
use App\Models\TicketTiempo;
use App\Services\Tickets\TicketTimeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class TicketTimeController extends Controller
{
    public function index(Ticket $ticket): JsonResponse
    {
        return response()->json([
            'tiempos' => $ticket->tiempos()
                ->with('usuario:id,name')
                ->latest('fecha')
                ->latest()
                ->get(),
        ]);
    }

    public function store(StoreTicketTimeRequest $request, Ticket $ticket, TicketTimeService $service): RedirectResponse
    {
        $service->store($ticket, $request->validated(), $request->user()->id);

        return back()->with('success', 'Tiempo registrado correctamente.');
    }

    public function update(UpdateTicketTimeRequest $request, Ticket $ticket, TicketTiempo $tiempo, TicketTimeService $service): RedirectResponse
    {
        abort_unless($tiempo->ticket_id === $ticket->id, 404);

        $service->update($tiempo, $request->validated(), $request->user()->id);

        return back()->with('success', 'Tiempo actualizado correctamente.');
    }

    public function destroy(Ticket $ticket, TicketTiempo $tiempo, TicketTimeService $service): RedirectResponse
    {
        abort_unless($tiempo->ticket_id === $ticket->id, 404);

        $service->delete($tiempo, request()->user()->id);

        return back()->with('success', 'Tiempo eliminado correctamente.');
    }
}
