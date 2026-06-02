<?php

namespace App\Services\Notifications;

use App\Models\ClienteContacto;
use App\Models\NotificationLog;
use App\Models\Ticket;
use App\Services\Tickets\TicketHistoryService;
use Illuminate\Validation\ValidationException;

class TicketNotificationService
{
    public function __construct(
        private readonly NotificationLogService $logs,
        private readonly EmailNotificationService $email,
        private readonly TicketHistoryService $history,
    ) {}

    public function sendEmail(Ticket $ticket, array $data, int $userId): NotificationLog
    {
        $recipient = $data['recipient'] ?? null;
        $contactoId = $data['contacto_id'] ?? null;

        if ($contactoId) {
            $contacto = ClienteContacto::query()
                ->where('id', $contactoId)
                ->where('client_id', $ticket->cliente_id)
                ->firstOrFail();
            $recipient = $contacto->email;
        }

        if (! $recipient) {
            throw ValidationException::withMessages(['recipient' => 'Debes indicar un destinatario de correo.']);
        }

        if ($this->looksInternal($data['message'])) {
            throw ValidationException::withMessages(['message' => 'El mensaje parece contener una nota interna. Revisa el contenido antes de enviarlo.']);
        }

        $log = $this->logs->create([
            'ticket_id' => $ticket->id,
            'user_id' => $userId,
            'cliente_id' => $ticket->cliente_id,
            'contacto_id' => $contactoId,
            'channel' => 'email',
            'direction' => 'outbound',
            'recipient' => $recipient,
            'subject' => $data['subject'],
            'message' => $data['message'],
            'payload' => ['save_as_public_comment' => (bool) ($data['save_as_public_comment'] ?? false)],
            'status' => 'pending',
        ]);

        $sentLog = $this->email->send($log);

        if (($data['save_as_public_comment'] ?? false) && $sentLog->status === 'sent') {
            $ticket->mensajes()->create([
                'usuario_id' => $userId,
                'mensaje' => $data['message'],
                'es_interno' => false,
                'es_respuesta_cliente' => false,
            ]);

            $this->history->log($ticket, 'comment_added', $userId, descripcion: 'Correo guardado como comentario publico.', metadata: [
                'notification_log_id' => $sentLog->id,
            ]);
        }

        return $sentLog;
    }

    private function looksInternal(string $message): bool
    {
        $text = strtolower($message);

        return str_contains($text, '[interno]') || str_contains($text, 'nota interna');
    }
}
