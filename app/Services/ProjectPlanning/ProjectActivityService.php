<?php

namespace App\Services\ProjectPlanning;

use App\Models\Proyecto;
use App\Models\ProyectoActividad;
use App\Services\Notifications\InternalNotificationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProjectActivityService
{
    public function create(Proyecto $proyecto, array $data, ?int $userId): ProyectoActividad
    {
        return DB::transaction(function () use ($proyecto, $data, $userId): ProyectoActividad {
            $this->guardParent($proyecto, $data['parent_id'] ?? null);

            $activity = ProyectoActividad::query()->create([
                ...$this->syncStateAndColumn($data),
                'proyecto_id' => $proyecto->id,
                'created_by_id' => $userId,
                'updated_by_id' => $userId,
            ]);

            if ($activity->ticket_id) {
                app(ProjectActivityTicketService::class)->link($activity, $activity->ticket_id, 'relacionado', $userId);
            }

            if ($activity->responsable_id) {
                app(InternalNotificationService::class)->notifyActivityAssigned($activity, $activity->responsable_id);
            }

            return $activity;
        });
    }

    public function update(Proyecto $proyecto, ProyectoActividad $activity, array $data, ?int $userId): ProyectoActividad
    {
        $this->assertBelongsToProject($proyecto, $activity);
        $this->guardParent($proyecto, $data['parent_id'] ?? null, $activity);

        return DB::transaction(function () use ($activity, $data, $userId): ProyectoActividad {
            $oldResponsibleId = $activity->responsable_id;

            $activity->update([
                ...$this->syncStateAndColumn($data),
                'updated_by_id' => $userId,
            ]);

            if ($activity->ticket_id) {
                app(ProjectActivityTicketService::class)->link($activity, $activity->ticket_id, 'relacionado', $userId);
            }

            if (
                array_key_exists('responsable_id', $data)
                && $activity->responsable_id
                && (string) ($oldResponsibleId ?? '') !== (string) $activity->responsable_id
            ) {
                app(InternalNotificationService::class)->notifyActivityAssigned($activity, $activity->responsable_id);
            }

            return $activity->refresh();
        });
    }

    public function complete(Proyecto $proyecto, ProyectoActividad $activity, ?int $userId): ProyectoActividad
    {
        $this->assertBelongsToProject($proyecto, $activity);

        $activity->update([
            'estado' => 'terminada',
            'kanban_column' => 'terminado',
            'fecha_finalizacion' => $activity->fecha_finalizacion ?? now(),
            'updated_by_id' => $userId,
        ]);

        return $activity->refresh();
    }

    public function cancel(Proyecto $proyecto, ProyectoActividad $activity, ?int $userId): ProyectoActividad
    {
        $this->assertBelongsToProject($proyecto, $activity);

        $activity->update([
            'estado' => 'cancelada',
            'updated_by_id' => $userId,
        ]);

        return $activity->refresh();
    }

    public function delete(Proyecto $proyecto, ProyectoActividad $activity): void
    {
        $this->assertBelongsToProject($proyecto, $activity);
        $activity->delete();
    }

    public function assertBelongsToProject(Proyecto $proyecto, ProyectoActividad $activity): void
    {
        abort_unless($activity->proyecto_id === $proyecto->id, 404);
    }

    private function guardParent(Proyecto $proyecto, ?string $parentId, ?ProyectoActividad $activity = null): void
    {
        if (! $parentId) {
            return;
        }

        if ($activity && $parentId === $activity->id) {
            throw ValidationException::withMessages(['parent_id' => 'La actividad padre no puede ser la misma actividad.']);
        }

        $parent = ProyectoActividad::query()->findOrFail($parentId);
        abort_unless($parent->proyecto_id === $proyecto->id, 422);
    }

    private function syncStateAndColumn(array $data): array
    {
        $state = $data['estado'] ?? 'pendiente';
        $column = $data['kanban_column'] ?? match ($state) {
            'por_hacer' => 'por_hacer',
            'en_proceso' => 'en_proceso',
            'en_revision' => 'en_revision',
            'terminada' => 'terminado',
            default => 'backlog',
        };

        if ($state === 'terminada') {
            $column = 'terminado';
            $data['fecha_finalizacion'] = $data['fecha_finalizacion'] ?? now();
        }

        if ($column === 'terminado') {
            $state = 'terminada';
            $data['fecha_finalizacion'] = $data['fecha_finalizacion'] ?? now();
        }

        return [
            ...$data,
            'estado' => $state,
            'kanban_column' => $column,
        ];
    }
}
