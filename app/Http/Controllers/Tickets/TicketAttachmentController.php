<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\StoreTicketAttachmentRequest;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Services\Tickets\TicketAttachmentService;
use App\Services\Tickets\TicketHistoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TicketAttachmentController extends Controller
{
    public function store(
        StoreTicketAttachmentRequest $request,
        Ticket $ticket,
        TicketAttachmentService $attachments,
        TicketHistoryService $history,
    ): RedirectResponse {
        $attachment = $attachments->store(
            $ticket,
            $request->file('archivo'),
            $request->user()->id,
            $request->string('descripcion')->toString() ?: null,
            $request->input('message_id'),
        );

        $history->log(
            $ticket,
            'attachment_added',
            $request->user()->id,
            descripcion: 'Adjunto agregado.',
            metadata: ['attachment_id' => $attachment->id],
        );

        return back()->with('success', 'Adjunto cargado correctamente.');
    }

    public function destroy(Ticket $ticket, TicketAttachment $attachment, TicketAttachmentService $attachments): RedirectResponse
    {
        abort_unless($attachment->ticket_id === $ticket->id, 404);

        $attachments->delete($attachment);

        return back()->with('success', 'Adjunto eliminado correctamente.');
    }

    public function download(Ticket $ticket, TicketAttachment $attachment): StreamedResponse
    {
        abort_unless($attachment->ticket_id === $ticket->id, 404);

        return Storage::disk($attachment->disk)->download($attachment->ruta, $attachment->nombre_original);
    }
}
