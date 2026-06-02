<?php

namespace App\Notifications\ProjectPlanning;

use App\Models\ProyectoActividad;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ActivityAssignedNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly ProyectoActividad $activity) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Actividad asignada',
            'message' => "Se te asigno la actividad {$this->activity->titulo}",
            'proyecto_id' => $this->activity->proyecto_id,
            'actividad_id' => $this->activity->id,
            'activity_title' => $this->activity->titulo,
            'action_url' => route('proyectos.activities.show', [$this->activity->proyecto_id, $this->activity->id]),
            'level' => 'info',
            'module' => 'project-planning',
        ];
    }
}
