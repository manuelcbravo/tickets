<?php

namespace App\Http\Controllers\Quotes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quotes\CreateQuoteFromTicketRequest;
use App\Models\Ticket;
use App\Services\Quotes\QuoteFromTicketService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class QuoteFromTicketController extends Controller
{
    public function create(Ticket $ticket): Response
    {
        $ticket->load(['cliente:id,nombre,razon_social', 'proyecto:id,nombre', 'contacto:id,nombre,email']);

        return Inertia::render('quotes/from-ticket', [
            'ticket' => $ticket,
            'defaults' => [
                'titulo' => "Cotizacion {$ticket->folio} - {$ticket->titulo}",
                'alcance' => "Definir alcance para {$ticket->folio}: {$ticket->titulo}",
                'incluir_descripcion_ticket' => true,
            ],
        ]);
    }

    public function store(CreateQuoteFromTicketRequest $request, Ticket $ticket, QuoteFromTicketService $service): RedirectResponse
    {
        $quote = $service->create($ticket, $request->validated(), $request->user()->id);

        return redirect()->route('quotes.show', $quote)->with('success', 'Cotizacion creada desde ticket.');
    }

    public function markRequired(Ticket $ticket, QuoteFromTicketService $service): RedirectResponse
    {
        $service->markRequired($ticket, auth()->id());

        return back()->with('success', 'Ticket marcado como requiere cotizacion.');
    }
}
