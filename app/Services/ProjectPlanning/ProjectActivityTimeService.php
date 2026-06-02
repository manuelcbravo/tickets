<?php

namespace App\Services\ProjectPlanning;

use App\Models\ProyectoActividad;
use App\Models\ProyectoActividadTiempo;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProjectActivityTimeService
{
    public function store(ProyectoActividad $activity, array $data, int $userId): ProyectoActividadTiempo
    {
        return DB::transaction(function () use ($activity, $data, $userId): ProyectoActividadTiempo {
            $time = $activity->tiempos()->create([
                ...$this->normalizeMinutes($data),
                'usuario_id' => $userId,
            ]);

            $this->recalculate($activity);

            return $time;
        });
    }

    public function update(ProyectoActividadTiempo $time, array $data): ProyectoActividadTiempo
    {
        return DB::transaction(function () use ($time, $data): ProyectoActividadTiempo {
            $time->update($this->normalizeMinutes($data));
            $this->recalculate($time->actividad);

            return $time->refresh();
        });
    }

    public function delete(ProyectoActividadTiempo $time): void
    {
        DB::transaction(function () use ($time): void {
            $activity = $time->actividad;
            $time->delete();
            $this->recalculate($activity);
        });
    }

    public function recalculate(ProyectoActividad $activity): void
    {
        $activity->update([
            'minutos_reales' => (int) $activity->tiempos()->sum('minutos'),
        ]);
    }

    private function normalizeMinutes(array $data): array
    {
        if (! empty($data['minutos'])) {
            return $data;
        }

        if (! empty($data['iniciado_at']) && ! empty($data['terminado_at'])) {
            $start = \Carbon\Carbon::parse($data['iniciado_at']);
            $end = \Carbon\Carbon::parse($data['terminado_at']);
            $minutes = $start->diffInMinutes($end, false);

            if ($minutes > 0) {
                return [...$data, 'minutos' => $minutes];
            }
        }

        throw ValidationException::withMessages(['minutos' => 'Captura minutos o un rango de inicio y fin valido.']);
    }
}
