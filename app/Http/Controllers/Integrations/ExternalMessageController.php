<?php

namespace App\Http\Controllers\Integrations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Integrations\ConvertExternalMessageToCommentRequest;
use App\Http\Requests\Integrations\LinkExternalMessageToTicketRequest;
use App\Models\ExternalMessage;
use App\Models\Ticket;
use App\Services\Integrations\ExternalMessageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ExternalMessageController extends Controller
{
    public function index(Request $request): Response
    {
        $messages = ExternalMessage::query()
            ->with(['ticket:id,folio,titulo', 'cliente:id,nombre,razon_social'])
            ->when($request->input('channel'), fn ($query, $value) => $query->where('channel', $value))
            ->when($request->input('direction'), fn ($query, $value) => $query->where('direction', $value))
            ->when($request->input('linked') === 'yes', fn ($query) => $query->whereNotNull('ticket_id'))
            ->when($request->input('linked') === 'no', fn ($query) => $query->whereNull('ticket_id'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('integrations/messages/index', [
            'messages' => $messages,
            'filters' => $request->only(['channel', 'direction', 'linked']),
            'channels' => ExternalMessage::CHANNELS,
        ]);
    }

    public function show(ExternalMessage $message): Response
    {
        $message->load(['ticket:id,folio,titulo', 'cliente:id,nombre,razon_social', 'contacto:id,nombre,email', 'integration:id,nombre,tipo,proveedor']);

        return Inertia::render('integrations/messages/show', [
            'message' => $message,
            'ticketOptions' => Ticket::query()->latest()->limit(50)->get(['id', 'folio', 'titulo']),
        ]);
    }

    public function linkToTicket(LinkExternalMessageToTicketRequest $request, ExternalMessage $message, ExternalMessageService $service): RedirectResponse
    {
        $service->linkToTicket($message, Ticket::query()->findOrFail($request->validated('ticket_id')), $request->user()->id);

        return back()->with('success', 'Mensaje vinculado al ticket.');
    }

    public function convertToComment(ConvertExternalMessageToCommentRequest $request, ExternalMessage $message, ExternalMessageService $service): RedirectResponse
    {
        $service->convertToComment($message, $request->boolean('es_interno'), $request->validated('mensaje'), $request->user()->id);

        return back()->with('success', 'Mensaje convertido en comentario.');
    }
}
