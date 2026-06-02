<?php

namespace App\Notifications\ProjectBilling;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectChargeDueSoonNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly int $count,
        private readonly string $actionUrl,
        private readonly string $reviewDate,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Pagos proximos a vencer',
            'message' => "Hay {$this->count} cargos de proyectos proximos a vencer.",
            'action_url' => $this->actionUrl,
            'level' => 'warning',
            'module' => 'project-billing',
            'review_date' => $this->reviewDate,
            'charges_count' => $this->count,
        ];
    }
}
