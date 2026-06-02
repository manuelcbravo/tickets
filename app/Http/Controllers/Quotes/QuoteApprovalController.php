<?php

namespace App\Http\Controllers\Quotes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quotes\ApproveQuoteClientRequest;
use App\Http\Requests\Quotes\ApproveQuoteInternalRequest;
use App\Http\Requests\Quotes\RejectQuoteClientRequest;
use App\Models\Cotizacion;
use App\Services\Quotes\QuoteApprovalService;
use Illuminate\Http\RedirectResponse;

class QuoteApprovalController extends Controller
{
    public function approveInternal(ApproveQuoteInternalRequest $request, Cotizacion $quote, QuoteApprovalService $service): RedirectResponse
    {
        $service->approveInternal($quote, $request->user()->id, $request->validated('comentario'));

        return back()->with('success', 'Cotizacion aprobada internamente.');
    }

    public function approveClient(ApproveQuoteClientRequest $request, Cotizacion $quote, QuoteApprovalService $service): RedirectResponse
    {
        $service->approveClient($quote, $request->validated(), $request->user()->id);

        return back()->with('success', 'Aprobacion del cliente registrada.');
    }

    public function rejectClient(RejectQuoteClientRequest $request, Cotizacion $quote, QuoteApprovalService $service): RedirectResponse
    {
        $service->rejectClient($quote, $request->validated('comentario'), $request->user()->id);

        return back()->with('success', 'Rechazo del cliente registrado.');
    }
}
