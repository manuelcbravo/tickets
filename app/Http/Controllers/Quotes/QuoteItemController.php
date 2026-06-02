<?php

namespace App\Http\Controllers\Quotes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quotes\StoreQuoteItemRequest;
use App\Http\Requests\Quotes\UpdateQuoteItemRequest;
use App\Models\Cotizacion;
use App\Models\CotizacionItem;
use App\Services\Quotes\QuoteService;
use Illuminate\Http\RedirectResponse;

class QuoteItemController extends Controller
{
    public function store(StoreQuoteItemRequest $request, Cotizacion $quote, QuoteService $service): RedirectResponse
    {
        $service->createItem($quote, $request->validated());

        return back()->with('success', 'Partida agregada.');
    }

    public function update(UpdateQuoteItemRequest $request, Cotizacion $quote, CotizacionItem $item, QuoteService $service): RedirectResponse
    {
        $service->updateItem($quote, $item, $request->validated());

        return back()->with('success', 'Partida actualizada.');
    }

    public function destroy(Cotizacion $quote, CotizacionItem $item, QuoteService $service): RedirectResponse
    {
        $service->deleteItem($quote, $item);

        return back()->with('success', 'Partida eliminada.');
    }
}
