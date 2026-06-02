<?php

namespace App\Services\Integrations;

use App\Models\ExternalMessage;
use App\Models\Ticket;
use App\Services\Tickets\TicketHistoryService;

class ExternalMessageService
{
    public function __construct(private readonly TicketHistoryService $history) {}

    public function register(array $data): ExternalMessage
    {
        $message = ExternalMessage::query()->create($data);

        if ($message->ticket) {
            $this->logLinked($message, $message->ticket, 'external_message_received');
        }

        return $message;
    }

    public function linkToTicket(ExternalMessage $message, Ticket $ticket, ?int $userId = null): ExternalMessage
    {
        $message->update([
            'ticket_id' => $ticket->id,
            'cliente_id' => $ticket->cliente_id,
            'contacto_id' => $ticket->contacto_id,
        ]);

        $this->logLinked($message, $ticket, 'external_message_linked', $userId);

        return $message->refresh();
    }

    public function convertToComment(ExternalMessage $message, bool $internal, ?string $overrideMessage, int $userId): ExternalMessage
    {
        $ticket = $message->ticket;
        if (! $ticket) {
            throw new \InvalidArgumentException('El mensaje externo debe estar vinculado a un ticket.');
        }

        $ticket->mensajes()->create([
            'usuario_id' => $userId,
            'mensaje' => $overrideMessage ?: (string) $message->message,
            'es_interno' => $internal,
            'es_respuesta_cliente' => $message->direction === 'inbound',
        ]);

        $this->history->log($ticket, 'external_message_converted_to_comment', $userId, descripcion: 'Mensaje externo convertido en comentario.', metadata: [
            'external_message_id' => $message->id,
            'channel' => $message->channel,
        ]);

        return $message->refresh();
    }

    private function logLinked(ExternalMessage $message, Ticket $ticket, string $action, ?int $userId = null): void
    {
        $this->history->log($ticket, $action, $userId, descripcion: 'Mensaje externo vinculado al ticket.', metadata: [
            'external_message_id' => $message->id,
            'channel' => $message->channel,
            'external_id' => $message->external_id,
            'direction' => $message->direction,
        ]);
    }
}
