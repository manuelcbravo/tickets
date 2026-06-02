<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Http\Requests\Development\StoreReleaseTicketRequest;
use App\Models\Release;
use App\Models\Ticket;
use App\Services\Development\ReleaseService;
use Illuminate\Http\RedirectResponse;

class ReleaseTicketController extends Controller
{
    public function store(StoreReleaseTicketRequest $request, Release $release, ReleaseService $service): RedirectResponse
    {
        $service->addTicket($release, $request->validated(), $request->user()->id);

        return back()->with('success', 'Ticket agregado al release.');
    }

    public function destroy(Release $release, Ticket $ticket, ReleaseService $service): RedirectResponse
    {
        $service->removeTicket($release, $ticket, auth()->id());

        return back()->with('success', 'Ticket removido del release.');
    }
}
