<?php

namespace App\Http\Controllers\ProjectPlanning;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectPlanning\UpdateProjectPlanningRequest;
use App\Models\Proyecto;
use App\Services\ProjectPlanning\ProjectPlanningService;
use Illuminate\Http\RedirectResponse;

class ProjectPlanningController extends Controller
{
    public function show(Proyecto $proyecto): RedirectResponse
    {
        return redirect()->route('proyectos.show', $proyecto);
    }

    public function update(UpdateProjectPlanningRequest $request, Proyecto $proyecto, ProjectPlanningService $service): RedirectResponse
    {
        $service->update($proyecto, $request->validated());

        return back()->with('success', 'Planeacion del proyecto actualizada correctamente.');
    }
}
