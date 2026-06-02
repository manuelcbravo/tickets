<?php

namespace App\Services\Notifications;

use App\Models\NotificationLog;
use Illuminate\Support\Facades\Mail;

class EmailNotificationService
{
    public function __construct(private readonly NotificationLogService $logs) {}

    public function send(NotificationLog $log): NotificationLog
    {
        if (! config('integrations.email.enabled')) {
            return $this->logs->markFailed($log, 'El envio de correo esta desactivado en configuracion.');
        }

        try {
            Mail::raw((string) $log->message, function ($message) use ($log): void {
                $message->to((string) $log->recipient)
                    ->subject((string) $log->subject);
            });
        } catch (\Throwable $exception) {
            return $this->logs->markFailed($log, $exception->getMessage());
        }

        return $this->logs->markSent($log);
    }
}
