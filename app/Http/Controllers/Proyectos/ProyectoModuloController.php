<?php

namespace App\Http\Controllers\Proyectos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Proyectos\StoreProyectoModuloRequest;
use App\Http\Requests\Proyectos\UpdateProyectoModuloRequest;
use App\Models\Proyecto;
use App\Models\ProyectoModulo;
use Illuminate\Http\RedirectResponse;

class ProyectoModuloController extends Controller
{
    public function store(StoreProyectoModuloRequest $request, Proyecto $proyecto): RedirectResponse
    {
        $proyecto->modulos()->create($request->validated());

        return back()->with('success', 'Modulo creado correctamente.');
    }

    public function update(
        UpdateProyectoModuloRequest $request,
        Proyecto $proyecto,
        ProyectoModulo $modulo,
    ): RedirectResponse {
        abort_unless($modulo->project_id === $proyecto->id, 404);

        $modulo->update($request->validated());

        return back()->with('success', 'Modulo actualizado correctamente.');
    }

    public function destroy(Proyecto $proyecto, ProyectoModulo $modulo): RedirectResponse
    {
        abort_unless($modulo->project_id === $proyecto->id, 404);

        $modulo->delete();

        return back()->with('success', 'Modulo eliminado correctamente.');
    }
}
