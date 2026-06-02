<?php

namespace App\Http\Controllers\ProjectPlanning;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectPlanning\StoreProjectActivityTimeRequest;
use App\Http\Requests\ProjectPlanning\UpdateProjectActivityTimeRequest;
use App\Models\Proyecto;
use App\Models\ProyectoActividad;
use App\Models\ProyectoActividadTiempo;
use App\Services\ProjectPlanning\ProjectActivityService;
use App\Services\ProjectPlanning\ProjectActivityTimeService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProjectActivityTimeController extends Controller
{
    public function create(Proyecto $proyecto, ProyectoActividad $activity, ProjectActivityService $activityService): Response
    {
        $activityService->assertBelongsToProject($proyecto, $activity);

        $activity->load([
            'proyecto:id,nombre,client_id',
            'proyecto.cliente:id,nombre,razon_social',
            'responsable:id,name',
        ]);

        return Inertia::render('activities/times/create', [
            'proyecto' => $proyecto->only(['id', 'nombre']),
            'activity' => $activity,
        ]);
    }

    public function store(StoreProjectActivityTimeRequest $request, Proyecto $proyecto, ProyectoActividad $activity, ProjectActivityService $activityService, ProjectActivityTimeService $service): RedirectResponse
    {
        $activityService->assertBelongsToProject($proyecto, $activity);
        $service->store($activity, $request->validated(), $request->user()->id);

        return back()->with('success', 'Tiempo registrado correctamente.');
    }

    public function update(UpdateProjectActivityTimeRequest $request, Proyecto $proyecto, ProyectoActividad $activity, ProyectoActividadTiempo $time, ProjectActivityService $activityService, ProjectActivityTimeService $service): RedirectResponse
    {
        $activityService->assertBelongsToProject($proyecto, $activity);
        abort_unless($time->actividad_id === $activity->id, 404);
        $service->update($time, $request->validated());

        return back()->with('success', 'Tiempo actualizado correctamente.');
    }

    public function destroy(Proyecto $proyecto, ProyectoActividad $activity, ProyectoActividadTiempo $time, ProjectActivityService $activityService, ProjectActivityTimeService $service): RedirectResponse
    {
        $activityService->assertBelongsToProject($proyecto, $activity);
        abort_unless($time->actividad_id === $activity->id, 404);
        $service->delete($time);

        return back()->with('success', 'Tiempo eliminado correctamente.');
    }
}
