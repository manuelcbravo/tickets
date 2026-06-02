<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Http\Requests\Development\StoreTicketDevelopmentLinkRequest;
use App\Models\Ticket;
use App\Models\TicketDevelopmentLink;
use App\Services\Development\TicketDevelopmentLinkService;
use Illuminate\Http\RedirectResponse;

class TicketDevelopmentLinkController extends Controller
{
    public function store(StoreTicketDevelopmentLinkRequest $request, Ticket $ticket, TicketDevelopmentLinkService $service): RedirectResponse
    {
        $service->create($ticket, $request->validated(), $request->user()->id);

        return back()->with('success', 'Enlace tecnico agregado correctamente.');
    }

    public function destroy(Ticket $ticket, TicketDevelopmentLink $link, TicketDevelopmentLinkService $service): RedirectResponse
    {
        $service->delete($ticket, $link, auth()->id());

        return back()->with('success', 'Enlace tecnico eliminado correctamente.');
    }
}
