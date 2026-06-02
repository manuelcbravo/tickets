<?php

namespace App\Services\Notifications;

use App\Models\ProyectoActividad;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\ProjectBilling\ProjectChargesDueSoonNotification;
use App\Notifications\ProjectPlanning\ActivityAssignedNotification;
use App\Notifications\Tickets\TicketAssignedNotification;
use Illuminate\Notifications\DatabaseNotification;

class InternalNotificationService
{
    public function notifyTicketAssigned(Ticket $ticket, int $responsableId): bool
    {
        $user = User::query()->find($responsableId);

        if (! $user || $this->recentDuplicate(TicketAssignedNotification::class, $user, 'ticket_id', $ticket->id)) {
            return false;
        }

        $user->notify(new TicketAssignedNotification($ticket));

        return true;
    }

    public function notifyActivityAssigned(ProyectoActividad $activity, int $responsableId): bool
    {
        $user = User::query()->find($responsableId);

        if (! $user || $this->recentDuplicate(ActivityAssignedNotification::class, $user, 'actividad_id', $activity->id)) {
            return false;
        }

        $user->notify(new ActivityAssignedNotification($activity));

        return true;
    }

    public function notifyProjectChargesDueSoon(User $user, int $count, string $actionUrl, string $reviewDate): bool
    {
        if ($this->recentDuplicate(ProjectChargesDueSoonNotification::class, $user, 'review_date', $reviewDate, dayWindow: true)) {
            return false;
        }

        $user->notify(new ProjectChargesDueSoonNotification($count, $actionUrl, $reviewDate));

        return true;
    }

    private function recentDuplicate(
        string $type,
        User $user,
        string $dataKey,
        string|int $dataValue,
        bool $dayWindow = false,
    ): bool {
        $from = $dayWindow ? now()->startOfDay() : now()->subMinutes(2);

        return DatabaseNotification::query()
            ->where('type', $type)
            ->where('notifiable_type', User::class)
            ->where('notifiable_id', $user->id)
            ->where('created_at', '>=', $from)
            ->get()
            ->contains(fn (DatabaseNotification $notification): bool => (string) data_get($notification->data, $dataKey) === (string) $dataValue);
    }
}
