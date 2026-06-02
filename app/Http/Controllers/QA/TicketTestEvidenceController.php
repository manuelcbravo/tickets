<?php

namespace App\Http\Controllers\QA;

use App\Http\Controllers\Controller;
use App\Http\Requests\QA\StoreTicketTestEvidenceRequest;
use App\Models\Ticket;
use App\Models\TicketTestEvidence;
use App\Services\QA\TicketEvidenceService;
use Illuminate\Http\RedirectResponse;

class TicketTestEvidenceController extends Controller
{
    public function store(StoreTicketTestEvidenceRequest $request, Ticket $ticket, TicketEvidenceService $service): RedirectResponse
    {
        $service->create($ticket, $request->validated(), $request->user()->id);

        return back()->with('success', 'Evidencia QA agregada.');
    }

    public function destroy(Ticket $ticket, TicketTestEvidence $evidence, TicketEvidenceService $service): RedirectResponse
    {
        $service->delete($ticket, $evidence, auth()->id());

        return back()->with('success', 'Evidencia QA eliminada.');
    }
}
