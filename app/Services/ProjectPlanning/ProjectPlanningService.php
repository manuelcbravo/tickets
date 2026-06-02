<?php

namespace App\Services\ProjectPlanning;

use App\Models\Proyecto;

class ProjectPlanningService
{
    public function update(Proyecto $proyecto, array $data): Proyecto
    {
        $proyecto->update($data);

        return $proyecto->refresh();
    }

    public function calculatedProgress(Proyecto $proyecto): int
    {
        $total = $proyecto->actividades()->count();

        if ($total === 0) {
            return 0;
        }

        $finished = $proyecto->actividades()->where('estado', 'terminada')->count();

        return (int) round(($finished / $total) * 100);
    }

    public function metrics(Proyecto $proyecto): array
    {
        $activities = $proyecto->actividades();

        return [
            'actividades_totales' => (clone $activities)->count(),
            'actividades_pendientes' => (clone $activities)->whereIn('estado', ['pendiente', 'por_hacer'])->count(),
            'actividades_en_proceso' => (clone $activities)->whereIn('estado', ['en_proceso', 'en_revision', 'bloqueada'])->count(),
            'actividades_terminadas' => (clone $activities)->where('estado', 'terminada')->count(),
            'actividades_vencidas' => (clone $activities)
                ->whereNotIn('estado', ['terminada', 'cancelada'])
                ->whereDate('fecha_limite', '<', now()->toDateString())
                ->count(),
            'tiempo_estimado' => (int) (clone $activities)->sum('minutos_estimados'),
            'tiempo_real' => (int) (clone $activities)->sum('minutos_reales'),
            'documentos' => $proyecto->files()->count(),
            'tickets_relacionados' => \App\Models\ProyectoActividadTicket::query()
                ->whereHas('actividad', fn ($query) => $query->where('proyecto_id', $proyecto->id))
                ->distinct('ticket_id')
                ->count('ticket_id'),
            'avance_calculado' => $this->calculatedProgress($proyecto),
        ];
    }
}
