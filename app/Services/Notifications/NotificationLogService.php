<?php

namespace App\Services\Notifications;

use App\Models\NotificationLog;
use App\Models\Ticket;
use App\Services\Tickets\TicketHistoryService;

class NotificationLogService
{
    public function __construct(private readonly TicketHistoryService $history) {}

    public function create(array $data): NotificationLog
    {
        $log = NotificationLog::query()->create($data);

        if ($log->ticket) {
            $this->history->log($log->ticket, 'notification_created', $log->user_id, descripcion: 'Notificacion registrada.', metadata: [
                'notification_log_id' => $log->id,
                'channel' => $log->channel,
                'recipient' => $log->recipient,
            ]);
        }

        return $log;
    }

    public function markSent(NotificationLog $log): NotificationLog
    {
        $log->update([
            'status' => 'sent',
            'sent_at' => now(),
            'failed_at' => null,
            'error_message' => null,
        ]);

        $this->logTicket($log, 'notification_sent', 'Notificacion enviada.');

        return $log->refresh();
    }

    public function markFailed(NotificationLog $log, string $message): NotificationLog
    {
        $log->update([
            'status' => 'failed',
            'failed_at' => now(),
            'error_message' => $message,
        ]);

        $this->logTicket($log, 'notification_failed', 'Notificacion fallida.');

        return $log->refresh();
    }

    public function received(Ticket $ticket, array $data): NotificationLog
    {
        return $this->create([
            ...$data,
            'ticket_id' => $ticket->id,
            'cliente_id' => $ticket->cliente_id,
            'channel' => $data['channel'] ?? 'system',
            'direction' => 'inbound',
            'status' => 'received',
        ]);
    }

    private function logTicket(NotificationLog $log, string $action, string $description): void
    {
        if (! $log->ticket) {
            return;
        }

        $this->history->log($log->ticket, $action, $log->user_id, descripcion: $description, metadata: [
            'notification_log_id' => $log->id,
            'channel' => $log->channel,
            'recipient' => $log->recipient,
            'status' => $log->status,
        ]);
    }
}
