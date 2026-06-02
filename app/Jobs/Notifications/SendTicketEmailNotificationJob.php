<?php

namespace App\Jobs\Notifications;

use App\Models\NotificationLog;
use App\Services\Notifications\EmailNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendTicketEmailNotificationJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public function __construct(public string $notificationLogId) {}

    public function handle(EmailNotificationService $email): void
    {
        $email->send(NotificationLog::query()->findOrFail($this->notificationLogId));
    }
}
