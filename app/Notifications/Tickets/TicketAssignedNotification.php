<?php

namespace App\Notifications\Tickets;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TicketAssignedNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly Ticket $ticket) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Ticket asignado',
            'message' => "Se te asigno el ticket {$this->ticket->folio}: {$this->ticket->titulo}",
            'ticket_id' => $this->ticket->id,
            'ticket_folio' => $this->ticket->folio,
            'ticket_title' => $this->ticket->titulo,
            'action_url' => route('tickets.show', $this->ticket),
            'level' => 'info',
            'module' => 'tickets',
        ];
    }
}
