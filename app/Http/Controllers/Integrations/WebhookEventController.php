<?php

namespace App\Http\Controllers\Integrations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Integrations\LinkWebhookEventToTicketRequest;
use App\Http\Requests\Integrations\RetryWebhookEventRequest;
use App\Models\Ticket;
use App\Models\WebhookEvent;
use App\Services\Integrations\WebhookEventService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WebhookEventController extends Controller
{
    public function index(Request $request): Response
    {
        $events = WebhookEvent::query()
            ->with(['ticket:id,folio,titulo'])
            ->when($request->input('provider'), fn ($query, $value) => $query->where('provider', $value))
            ->when($request->input('event_type'), fn ($query, $value) => $query->where('event_type', $value))
            ->when($request->input('status'), fn ($query, $value) => $query->where('status', $value))
            ->when($request->input('linked') === 'yes', fn ($query) => $query->whereNotNull('ticket_id'))
            ->when($request->input('linked') === 'no', fn ($query) => $query->whereNull('ticket_id'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('integrations/webhooks/index', [
            'events' => $events,
            'filters' => $request->only(['provider', 'event_type', 'status', 'linked']),
            'statuses' => WebhookEvent::STATUSES,
        ]);
    }

    public function show(WebhookEvent $event): Response
    {
        $event->load(['ticket:id,folio,titulo', 'integration:id,nombre,tipo,proveedor']);

        return Inertia::render('integrations/webhooks/show', [
            'event' => $event,
            'ticketOptions' => Ticket::query()->latest()->limit(50)->get(['id', 'folio', 'titulo']),
        ]);
    }

    public function linkToTicket(LinkWebhookEventToTicketRequest $request, WebhookEvent $event, WebhookEventService $service): RedirectResponse
    {
        $service->linkToTicket($event, Ticket::query()->findOrFail($request->validated('ticket_id')), $request->user()->id);

        return back()->with('success', 'Evento vinculado al ticket.');
    }

    public function ignore(WebhookEvent $event, WebhookEventService $service): RedirectResponse
    {
        $service->ignore($event);

        return back()->with('success', 'Evento ignorado.');
    }

    public function retry(RetryWebhookEventRequest $request, WebhookEvent $event, WebhookEventService $service): RedirectResponse
    {
        $service->retry($event);

        return back()->with('success', 'Evento reprocesado.');
    }
}
