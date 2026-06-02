<?php

namespace App\Services\Tickets;

use App\Models\CatTicketImpacto;
use App\Models\CatTicketPrioridad;
use App\Models\CatTicketRiesgo;
use App\Models\CatTicketTipo;
use App\Models\CatTicketUrgencia;
use App\Models\Ticket;
use Illuminate\Support\Str;

class TicketPriorityService
{
    public function update(Ticket $ticket, int $prioridadId, ?int $usuarioId, ?string $motivo = null): Ticket
    {
        $old = $ticket->prioridad_id;
        $ticket->update([
            'prioridad_id' => $prioridadId,
            'prioritized_at' => now(),
            'prioritized_by_id' => $usuarioId,
        ]);

        app(TicketHistoryService::class)->log(
            $ticket,
            'priority_changed',
            $usuarioId,
            'prioridad_id',
            $old,
            $prioridadId,
            $motivo ? 'Prioridad actualizada: '.$motivo : 'Prioridad actualizada.',
        );

        app(TicketSlaService::class)->recalculate($ticket->refresh(), $usuarioId);

        return $ticket->refresh();
    }

    public function suggest(?int $tipoId, ?int $impactoId, ?int $urgenciaId, ?int $riesgoId, ?string $dificultad = null): array
    {
        $tipo = $tipoId ? CatTicketTipo::query()->find($tipoId) : null;
        $impacto = $impactoId ? CatTicketImpacto::query()->find($impactoId) : null;
        $urgencia = $urgenciaId ? CatTicketUrgencia::query()->find($urgenciaId) : null;
        $riesgo = $riesgoId ? CatTicketRiesgo::query()->find($riesgoId) : null;

        $impactoValue = $this->valueFor($impacto?->nombre, [
            'bajo' => 1,
            'medio' => 2,
            'alto' => 3,
            'critico' => 4,
        ]);
        $urgenciaValue = $this->valueFor($urgencia?->nombre, [
            'baja' => 1,
            'media' => 2,
            'alta' => 3,
            'inmediata' => 4,
        ]);
        $riesgoValue = $this->valueFor($riesgo?->nombre, [
            'bajo' => 1,
            'medio' => 2,
            'alto' => 3,
        ]);

        $score = $impactoValue + $urgenciaValue + $riesgoValue;
        $tipoKey = $this->key($tipo?->nombre);
        $priorityPrefix = match (true) {
            $impactoValue >= 4 || $urgenciaValue >= 4 => 'P0',
            $score >= 9 => 'P0',
            $score >= 7 => 'P1',
            $score >= 5 => 'P2',
            $score >= 3 => 'P3',
            default => 'P4',
        };

        if (in_array($tipoKey, ['solicitud comercial', 'nuevo desarrollo'], true)) {
            $priorityPrefix = in_array($priorityPrefix, ['P0', 'P1'], true) ? $priorityPrefix : 'P4';
        }

        if ($tipoKey === 'incidente critico' && in_array($priorityPrefix, ['P2', 'P3', 'P4'], true)) {
            $priorityPrefix = 'P1';
        }

        $priority = CatTicketPrioridad::query()
            ->where('nombre', 'like', $priorityPrefix.'%')
            ->orderBy('orden')
            ->first();

        $effortWarning = in_array($this->key($dificultad), ['compleja', 'alta'], true)
            ? 'Dificultad alta: revisar esfuerzo antes de comprometer entrega.'
            : null;

        return [
            'priority_score' => $score,
            'prioridad_id' => $priority?->id,
            'prioridad_nombre' => $priority?->nombre,
            'explanation' => "Score {$score}: impacto {$impactoValue}, urgencia {$urgenciaValue}, riesgo {$riesgoValue}.",
            'effort_warning' => $effortWarning,
        ];
    }

    private function valueFor(?string $name, array $values): int
    {
        return $values[$this->key($name)] ?? 0;
    }

    private function key(?string $value): string
    {
        return Str::of($value ?? '')->ascii()->lower()->trim()->toString();
    }
}
