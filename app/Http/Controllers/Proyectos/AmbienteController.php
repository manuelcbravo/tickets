<?php

namespace App\Http\Controllers\Proyectos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Proyectos\StoreAmbienteRequest;
use App\Http\Requests\Proyectos\UpdateAmbienteRequest;
use App\Models\Ambiente;
use App\Models\Proyecto;
use Illuminate\Http\RedirectResponse;

class AmbienteController extends Controller
{
    public function store(StoreAmbienteRequest $request, Proyecto $proyecto): RedirectResponse
    {
        $proyecto->ambientes()->create($request->validated());

        return back()->with('success', 'Ambiente creado correctamente.');
    }

    public function update(
        UpdateAmbienteRequest $request,
        Proyecto $proyecto,
        Ambiente $ambiente,
    ): RedirectResponse {
        abort_unless($ambiente->project_id === $proyecto->id, 404);

        $ambiente->update($request->validated());

        return back()->with('success', 'Ambiente actualizado correctamente.');
    }

    public function destroy(Proyecto $proyecto, Ambiente $ambiente): RedirectResponse
    {
        abort_unless($ambiente->project_id === $proyecto->id, 404);

        $ambiente->delete();

        return back()->with('success', 'Ambiente eliminado correctamente.');
    }
}
