<?php

namespace App\Services\QA;

use App\Models\CatTicketEstado;
use App\Models\Ticket;
use App\Models\TicketReopenLog;
use App\Services\Tickets\TicketHistoryService;
use Illuminate\Support\Facades\DB;

class TicketReopenService
{
    public function __construct(private readonly TicketHistoryService $history)
    {
    }

    public function reopen(Ticket $ticket, array $data, int $userId): TicketReopenLog
    {
        return DB::transaction(function () use ($ticket, $data, $userId): TicketReopenLog {
            $previousClosedAt = $ticket->closed_at;
            $oldStatus = $ticket->estado_id;
            $reopenedStatus = CatTicketEstado::query()->where('nombre', 'Reabierto')->first()
                ?? CatTicketEstado::query()->where('nombre', 'En triage')->first();

            $log = TicketReopenLog::query()->create([
                'ticket_id' => $ticket->id,
                'reopened_by_id' => $userId,
                'previous_closed_at' => $previousClosedAt,
                'reason' => $data['reason'],
                'root_cause' => $data['root_cause'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);

            $ticket->forceFill([
                'estado_id' => $reopenedStatus?->id ?? $ticket->estado_id,
                'closed_at' => null,
                'closed_by_id' => null,
                'reopened_at' => now(),
                'reopened_by_id' => $userId,
                'reopen_count' => ((int) $ticket->reopen_count) + 1,
                'qa_status' => ($ticket->has_code_changes || $ticket->requires_code_change) ? 'pendiente' : $ticket->qa_status,
            ])->save();

            $this->history->log($ticket, 'ticket_reopened', $userId, 'estado_id', $oldStatus, $ticket->estado_id, 'Ticket reabierto: '.$data['reason'], ['reopen_log_id' => $log->id, 'root_cause' => $log->root_cause]);

            if ($log->root_cause) {
                $this->history->log($ticket, 'ticket_reopen_root_cause_set', $userId, 'root_cause', null, $log->root_cause, 'Causa raiz de reapertura registrada.', ['reopen_log_id' => $log->id]);
            }

            return $log;
        });
    }
}
