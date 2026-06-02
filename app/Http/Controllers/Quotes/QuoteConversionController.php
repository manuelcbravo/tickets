<?php

namespace App\Http\Controllers\Quotes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quotes\ConvertQuoteRequest;
use App\Models\Cotizacion;
use App\Services\Quotes\QuoteConversionService;
use Illuminate\Http\RedirectResponse;

class QuoteConversionController extends Controller
{
    public function convert(ConvertQuoteRequest $request, Cotizacion $quote, QuoteConversionService $service): RedirectResponse
    {
        $created = $service->convert($quote, $request->validated(), $request->user()->id);

        return back()->with('success', 'Cotizacion convertida en '.count($created).' ticket(s).');
    }
}
