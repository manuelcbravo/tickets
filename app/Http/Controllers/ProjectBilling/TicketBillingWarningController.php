<?php

namespace App\Http\Controllers\ProjectBilling;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectBilling\AcknowledgeBillingWarningRequest;
use App\Models\Ticket;
use App\Services\Tickets\TicketHistoryService;
use Illuminate\Http\RedirectResponse;

class TicketBillingWarningController extends Controller
{
    public function acknowledge(AcknowledgeBillingWarningRequest $request, Ticket $ticket, TicketHistoryService $history): RedirectResponse
    {
        $ticket->forceFill([
            'billing_warning_acknowledged_at' => now(),
            'billing_warning_acknowledged_by_id' => $request->user()->id,
        ])->save();

        $history->log(
            $ticket,
            'project_billing_warning_acknowledged',
            $request->user()->id,
            descripcion: 'Alerta de cobranza del proyecto reconocida.',
            metadata: ['notes' => $request->input('notes'), 'proyecto_id' => $ticket->proyecto_id],
        );

        return back()->with('success', 'Alerta de cobranza reconocida.');
    }
}
