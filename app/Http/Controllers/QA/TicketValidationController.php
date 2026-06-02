<?php

namespace App\Http\Controllers\QA;

use App\Http\Controllers\Controller;
use App\Http\Requests\QA\RejectTicketValidationRequest;
use App\Http\Requests\QA\StoreTicketValidationRequest;
use App\Models\Ticket;
use App\Models\TicketValidation;
use App\Services\QA\TicketValidationService;
use Illuminate\Http\RedirectResponse;

class TicketValidationController extends Controller
{
    public function store(StoreTicketValidationRequest $request, Ticket $ticket, TicketValidationService $service): RedirectResponse
    {
        $service->create($ticket, $request->validated(), $request->user()->id);

        return back()->with('success', 'Validacion registrada.');
    }

    public function approve(Ticket $ticket, TicketValidation $validation, TicketValidationService $service): RedirectResponse
    {
        $service->approve($ticket, $validation, auth()->id());

        return back()->with('success', 'Validacion aprobada.');
    }

    public function reject(RejectTicketValidationRequest $request, Ticket $ticket, TicketValidation $validation, TicketValidationService $service): RedirectResponse
    {
        $service->reject($ticket, $validation, $request->validated('comentario'), $request->user()->id);

        return back()->with('success', 'Validacion rechazada.');
    }
}
