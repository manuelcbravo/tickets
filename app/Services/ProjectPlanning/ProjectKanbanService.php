<?php

namespace App\Services\ProjectPlanning;

use App\Models\Proyecto;
use App\Models\ProyectoActividad;

class ProjectKanbanService
{
    public function grouped(Proyecto $proyecto): array
    {
        $activities = $proyecto->actividades()
            ->with(['responsable:id,name', 'ticket:id,folio,titulo'])
            ->get()
            ->groupBy('kanban_column');

        return collect(ProyectoActividad::KANBAN_COLUMNS)
            ->mapWithKeys(fn (string $column) => [$column => $activities->get($column, collect())->values()])
            ->all();
    }

    public function move(Proyecto $proyecto, ProyectoActividad $activity, string $column, ?int $order, ?int $userId): ProyectoActividad
    {
        abort_unless($activity->proyecto_id === $proyecto->id, 404);

        $activity->update([
            'kanban_column' => $column,
            'estado' => $column === 'terminado' ? 'terminada' : $this->stateForColumn($column),
            'fecha_finalizacion' => $column === 'terminado' ? ($activity->fecha_finalizacion ?? now()) : null,
            'orden' => $order ?? $activity->orden,
            'updated_by_id' => $userId,
        ]);

        return $activity->refresh();
    }

    private function stateForColumn(string $column): string
    {
        return match ($column) {
            'por_hacer' => 'por_hacer',
            'en_proceso' => 'en_proceso',
            'en_revision' => 'en_revision',
            default => 'pendiente',
        };
    }
}
