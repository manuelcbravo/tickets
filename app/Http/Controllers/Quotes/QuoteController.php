<?php

namespace App\Http\Controllers\Quotes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quotes\CancelQuoteRequest;
use App\Http\Requests\Quotes\StoreQuoteRequest;
use App\Http\Requests\Quotes\UpdateQuoteRequest;
use App\Models\CatTicketPrioridad;
use App\Models\CatTicketTipo;
use App\Models\Client;
use App\Models\ClienteContacto;
use App\Models\Cotizacion;
use App\Models\CotizacionItem;
use App\Models\Proyecto;
use App\Services\Quotes\QuoteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class QuoteController extends Controller
{
    public function index(Request $request): Response
    {
        $quotes = Cotizacion::query()
            ->with(['cliente:id,nombre,razon_social', 'proyecto:id,nombre', 'ticketOrigen:id,folio,titulo'])
            ->when($request->string('search')->toString(), function ($query, string $search): void {
                $query->where(function ($nested) use ($search): void {
                    $nested->where('folio', 'ilike', "%{$search}%")
                        ->orWhere('titulo', 'ilike', "%{$search}%")
                        ->orWhereHas('cliente', fn ($client) => $client
                            ->where('nombre', 'ilike', "%{$search}%")
                            ->orWhere('razon_social', 'ilike', "%{$search}%"));
                });
            })
            ->when($request->input('cliente_id'), fn ($query, $value) => $query->where('cliente_id', $value))
            ->when($request->input('proyecto_id'), fn ($query, $value) => $query->where('proyecto_id', $value))
            ->when($request->input('estado'), fn ($query, $value) => $query->where('estado', $value))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('quotes/index', [
            'quotes' => $quotes,
            'filters' => $request->only(['search', 'cliente_id', 'proyecto_id', 'estado']),
            ...$this->options(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('quotes/create', [
            ...$this->options(),
            'itemTypes' => CotizacionItem::TIPOS,
        ]);
    }

    public function store(StoreQuoteRequest $request, QuoteService $service): RedirectResponse
    {
        $quote = $service->create($request->validated(), $request->user()->id);

        return redirect()->route('quotes.show', $quote)->with('success', 'Cotizacion creada correctamente.');
    }

    public function show(Cotizacion $quote): Response
    {
        $quote->load([
            'cliente:id,nombre,razon_social,email',
            'proyecto:id,nombre,client_id',
            'contacto:id,nombre,email',
            'ticketOrigen:id,folio,titulo',
            'creadoPor:id,name',
            'aprobadoInternamentePor:id,name',
            'aprobadoClientePor:id,name',
            'items',
            'aprobaciones.usuario:id,name',
            'tickets:id,folio,titulo,estado_id,prioridad_id,cliente_id,proyecto_id,quote_status',
            'tickets.estado:id,nombre',
            'tickets.prioridad:id,nombre',
        ]);

        return Inertia::render('quotes/show', [
            'quote' => $quote,
            ...$this->options(),
            'itemTypes' => CotizacionItem::TIPOS,
            'tipos' => CatTicketTipo::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
            'prioridades' => CatTicketPrioridad::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
        ]);
    }

    public function edit(Cotizacion $quote): Response
    {
        return Inertia::render('quotes/edit', [
            'quote' => $quote,
            ...$this->options(),
            'itemTypes' => CotizacionItem::TIPOS,
        ]);
    }

    public function update(UpdateQuoteRequest $request, Cotizacion $quote, QuoteService $service): RedirectResponse
    {
        $service->update($quote, $request->validated());

        return redirect()->route('quotes.show', $quote)->with('success', 'Cotizacion actualizada correctamente.');
    }

    public function destroy(Cotizacion $quote): RedirectResponse
    {
        if (in_array($quote->estado, ['aprobada_internamente', 'aprobada_cliente', 'convertida'], true)) {
            return back()->with('error', 'No se puede eliminar una cotizacion aprobada o convertida. Usa cancelar.');
        }

        $quote->delete();

        return redirect()->route('quotes.index')->with('success', 'Cotizacion eliminada.');
    }

    public function cancel(CancelQuoteRequest $request, Cotizacion $quote, QuoteService $service): RedirectResponse
    {
        $service->cancel($quote, $request->validated('comentario'), $request->user()->id);

        return back()->with('success', 'Cotizacion cancelada.');
    }

    private function options(): array
    {
        return [
            'clientes' => Client::query()->orderBy('nombre')->get(['id', 'nombre', 'razon_social', 'estatus']),
            'proyectos' => Proyecto::query()->orderBy('nombre')->get(['id', 'client_id', 'nombre']),
            'contactos' => ClienteContacto::query()->orderBy('nombre')->get(['id', 'client_id', 'nombre', 'email']),
            'estados' => Cotizacion::ESTADOS,
        ];
    }
}
