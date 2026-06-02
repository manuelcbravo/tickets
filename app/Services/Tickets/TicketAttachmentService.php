<?php

namespace App\Services\Tickets;

use App\Models\Ticket;
use App\Models\TicketAttachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketAttachmentService
{
    public function store(
        Ticket $ticket,
        UploadedFile $file,
        ?int $usuarioId,
        ?string $descripcion = null,
        ?string $messageId = null,
    ): TicketAttachment {
        $extension = strtolower($file->getClientOriginalExtension());
        $safeName = (string) Str::uuid().($extension ? ".{$extension}" : '');
        $path = "tickets/{$ticket->id}/attachments/{$safeName}";

        Storage::disk('public')->putFileAs(
            "tickets/{$ticket->id}/attachments",
            $file,
            $safeName,
        );

        return TicketAttachment::query()->create([
            'ticket_id' => $ticket->id,
            'message_id' => $messageId,
            'usuario_id' => $usuarioId,
            'nombre_original' => $file->getClientOriginalName(),
            'ruta' => $path,
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'disk' => 'public',
            'descripcion' => $descripcion,
        ]);
    }

    public function delete(TicketAttachment $attachment): void
    {
        Storage::disk($attachment->disk)->delete($attachment->ruta);
        $attachment->delete();
    }
}
