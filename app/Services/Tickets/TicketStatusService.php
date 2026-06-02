<?php

namespace App\Services\Tickets;

use App\Models\CatTicketEstado;
use App\Models\Ticket;
use App\Models\User;
use App\Services\QA\TicketCloseGuardService;
use App\Services\QA\TicketReopenService;
use Illuminate\Validation\ValidationException;

class TicketStatusService
{
    public function changeStatus(Ticket $ticket, int $estadoId, ?int $usuarioId): void
    {
        $old = $ticket->estado_id;
        $ticket->update(['estado_id' => $estadoId]);

        app(TicketHistoryService::class)->log(
            $ticket,
            'status_changed',
            $usuarioId,
            'estado_id',
            $old,
            $estadoId,
            'Estado actualizado.',
        );
    }

    public function close(Ticket $ticket, string $resolution, User $user, ?string $forceReason = null): void
    {
        if (! $ticket->responsable_id) {
            throw ValidationException::withMessages([
                'responsable_id' => 'No se puede cerrar un ticket sin responsable.',
            ]);
        }

        $guardResult = app(TicketCloseGuardService::class)->assertCanClose($ticket, $user, $forceReason);
        $closedStatus = CatTicketEstado::query()
            ->where('nombre', 'Cerrado')
            ->first();

        $old = $ticket->estado_id;
        $ticket->update([
            'estado_id' => $closedStatus?->id ?? $ticket->estado_id,
            'resolution' => $resolution,
            'closed_at' => now(),
            'closed_by_id' => $user->id,
        ]);

        app(TicketHistoryService::class)->log(
            $ticket,
            'ticket_closed',
            $user->id,
            'estado_id',
            $old,
            $ticket->estado_id,
            'Ticket cerrado con resolucion.',
            ['forced_close' => $guardResult['forced'], 'qa_blockers' => $guardResult['blockers']],
        );

        app(TicketHistoryService::class)->log(
            $ticket,
            'ticket_closed_with_qa',
            $user->id,
            descripcion: $guardResult['forced'] ? 'Ticket cerrado con cierre forzado QA.' : 'Ticket cerrado con validacion QA.',
            metadata: ['forced_close' => $guardResult['forced']],
        );

        app(TicketSlaService::class)->recordResolution($ticket->refresh(), $user->id, $ticket->closed_at);
    }

    public function reopen(Ticket $ticket, string $motivo, int $usuarioId, ?string $rootCause = null, ?string $notes = null): void
    {
        app(TicketReopenService::class)->reopen($ticket, [
            'reason' => $motivo,
            'root_cause' => $rootCause,
            'notes' => $notes,
        ], $usuarioId);
    }
}
