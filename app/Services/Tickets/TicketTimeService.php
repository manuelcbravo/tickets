<?php

namespace App\Services\Tickets;

use App\Models\Ticket;
use App\Models\TicketTiempo;
use Illuminate\Support\Facades\DB;

class TicketTimeService
{
    public function store(Ticket $ticket, array $data, int $usuarioId): TicketTiempo
    {
        return DB::transaction(function () use ($ticket, $data, $usuarioId): TicketTiempo {
            $tiempo = $ticket->tiempos()->create([
                ...$data,
                'usuario_id' => $usuarioId,
                'origen' => $data['origen'] ?? 'manual',
            ]);

            app(TicketHistoryService::class)->log(
                $ticket,
                'time_logged',
                $usuarioId,
                descripcion: 'Tiempo registrado.',
                metadata: ['tiempo_id' => $tiempo->id, 'minutos' => $tiempo->minutos],
            );

            $this->recalculate($ticket, $usuarioId);

            return $tiempo->refresh();
        });
    }

    public function update(TicketTiempo $tiempo, array $data, int $usuarioId): TicketTiempo
    {
        return DB::transaction(function () use ($tiempo, $data, $usuarioId): TicketTiempo {
            $oldMinutes = $tiempo->minutos;
            $tiempo->update($data);

            app(TicketHistoryService::class)->log(
                $tiempo->ticket,
                'time_updated',
                $usuarioId,
                'minutos',
                $oldMinutes,
                $tiempo->minutos,
                'Tiempo actualizado.',
                ['tiempo_id' => $tiempo->id],
            );

            $this->recalculate($tiempo->ticket, $usuarioId);

            return $tiempo->refresh();
        });
    }

    public function delete(TicketTiempo $tiempo, int $usuarioId): void
    {
        DB::transaction(function () use ($tiempo, $usuarioId): void {
            $ticket = $tiempo->ticket;
            $minutes = $tiempo->minutos;

            $tiempo->delete();

            app(TicketHistoryService::class)->log(
                $ticket,
                'time_deleted',
                $usuarioId,
                'minutos',
                $minutes,
                null,
                'Tiempo eliminado.',
                ['tiempo_id' => $tiempo->id],
            );

            $this->recalculate($ticket, $usuarioId);
        });
    }

    public function recalculate(Ticket $ticket, ?int $usuarioId = null): void
    {
        $total = (int) $ticket->tiempos()->sum('minutos');
        $old = (int) ($ticket->tiempo_real_min ?? 0);

        $ticket->update(['tiempo_real_min' => $total]);

        app(TicketHistoryService::class)->log(
            $ticket,
            'ticket_time_recalculated',
            $usuarioId,
            'tiempo_real_min',
            $old,
            $total,
            'Tiempo real recalculado.',
        );
    }
}
