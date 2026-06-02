<?php

namespace App\Services\Tickets;

use App\Models\SlaPolitica;
use App\Models\SlaPoliticaPrioridad;
use App\Models\Ticket;
use App\Models\TicketSla;
use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;

class TicketSlaService
{
    public function defaultPolicy(): ?SlaPolitica
    {
        return SlaPolitica::query()
            ->where('activo', true)
            ->where('es_default', true)
            ->with('prioridades')
            ->first();
    }

    public function createForTicket(Ticket $ticket, ?int $usuarioId = null): ?TicketSla
    {
        $sla = $this->recalculate($ticket, $usuarioId, created: true);

        if ($sla) {
            app(TicketHistoryService::class)->log(
                $ticket,
                'sla_created',
                $usuarioId,
                descripcion: 'SLA creado para el ticket.',
                metadata: ['ticket_sla_id' => $sla->id, 'estado_sla' => $sla->estado_sla],
            );
        }

        return $sla;
    }

    public function recalculate(Ticket $ticket, ?int $usuarioId = null, bool $created = false): ?TicketSla
    {
        $policy = $this->defaultPolicy();

        if (! $policy || ! $ticket->prioridad_id) {
            return null;
        }

        $priorityRule = SlaPoliticaPrioridad::query()
            ->where('sla_politica_id', $policy->id)
            ->where('prioridad_id', $ticket->prioridad_id)
            ->first();

        if (! $priorityRule) {
            return null;
        }

        $ticket->loadMissing('sla');
        $current = $ticket->sla;
        $oldStatus = $current?->estado_sla;
        $base = $ticket->created_at instanceof CarbonInterface ? $ticket->created_at : now();
        $firstResponseAt = $ticket->primera_respuesta_at ?? $current?->primera_respuesta_at;
        $resolvedAt = $ticket->resuelto_at ?? $ticket->closed_at ?? $current?->resuelto_at;

        $data = [
            'sla_politica_id' => $policy->id,
            'prioridad_id' => $ticket->prioridad_id,
            'vence_primera_respuesta_at' => $base->copy()->addMinutes($priorityRule->tiempo_primera_respuesta_min),
            'vence_resolucion_at' => $base->copy()->addMinutes($priorityRule->tiempo_resolucion_min),
            'primera_respuesta_at' => $firstResponseAt,
            'resuelto_at' => $resolvedAt,
        ];

        $data['primera_respuesta_cumplida'] = $firstResponseAt
            ? $firstResponseAt->lte($data['vence_primera_respuesta_at'])
            : null;
        $data['resolucion_cumplida'] = $resolvedAt
            ? $resolvedAt->lte($data['vence_resolucion_at'])
            : null;
        $data['estado_sla'] = $this->determineStatus($ticket, $data);

        $sla = TicketSla::query()->updateOrCreate(
            ['ticket_id' => $ticket->id],
            $data,
        );

        if (! $created) {
            app(TicketHistoryService::class)->log(
                $ticket,
                'sla_recalculated',
                $usuarioId,
                descripcion: 'SLA recalculado.',
                metadata: ['ticket_sla_id' => $sla->id, 'estado_sla' => $sla->estado_sla],
            );
        }

        if ($oldStatus && $oldStatus !== $sla->estado_sla) {
            app(TicketHistoryService::class)->log(
                $ticket,
                'sla_status_changed',
                $usuarioId,
                'estado_sla',
                $oldStatus,
                $sla->estado_sla,
                'Estado SLA actualizado.',
            );
        }

        return $sla->refresh();
    }

    public function recordFirstResponse(Ticket $ticket, int $usuarioId, ?CarbonInterface $at = null): void
    {
        if ($ticket->primera_respuesta_at) {
            return;
        }

        $moment = Carbon::parse($at ?? now());
        $ticket->update(['primera_respuesta_at' => $moment]);
        $sla = $this->recalculate($ticket->refresh(), $usuarioId);

        if (! $sla) {
            return;
        }

        app(TicketHistoryService::class)->log(
            $ticket,
            $sla->primera_respuesta_cumplida ? 'sla_first_response_met' : 'sla_first_response_missed',
            $usuarioId,
            'primera_respuesta_at',
            null,
            $moment->toDateTimeString(),
            $sla->primera_respuesta_cumplida ? 'Primera respuesta dentro del SLA.' : 'Primera respuesta fuera del SLA.',
        );
    }

    public function recordResolution(Ticket $ticket, int $usuarioId, ?CarbonInterface $at = null): void
    {
        $moment = Carbon::parse($at ?? now());
        $ticket->update(['resuelto_at' => $moment]);
        $sla = $this->recalculate($ticket->refresh(), $usuarioId);

        if (! $sla) {
            return;
        }

        app(TicketHistoryService::class)->log(
            $ticket,
            $sla->resolucion_cumplida ? 'sla_resolution_met' : 'sla_resolution_missed',
            $usuarioId,
            'resuelto_at',
            null,
            $moment->toDateTimeString(),
            $sla->resolucion_cumplida ? 'Resolucion dentro del SLA.' : 'Resolucion fuera del SLA.',
        );
    }

    public function determineStatus(Ticket $ticket, array $data): string
    {
        if ($data['resuelto_at'] ?? null) {
            return ($data['resolucion_cumplida'] ?? false) ? 'cumplido' : 'incumplido';
        }

        if ($ticket->closed_at) {
            return ($data['resolucion_cumplida'] ?? false) ? 'cumplido' : 'incumplido';
        }

        $dueAt = $data['vence_resolucion_at'] ?? null;

        if (! $dueAt) {
            return 'pendiente';
        }

        $now = now();

        if ($now->greaterThan($dueAt)) {
            return 'vencido';
        }

        $createdAt = $ticket->created_at instanceof CarbonInterface ? $ticket->created_at : $now;
        $totalSeconds = max(1, $createdAt->diffInSeconds($dueAt));
        $remainingSeconds = $now->diffInSeconds($dueAt, false);

        return ($remainingSeconds / $totalSeconds) <= 0.2 ? 'en_riesgo' : 'en_tiempo';
    }
}
