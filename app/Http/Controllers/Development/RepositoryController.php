<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Http\Requests\Development\StoreRepositoryRequest;
use App\Http\Requests\Development\UpdateRepositoryRequest;
use App\Models\Proyecto;
use App\Models\Repositorio;
use App\Services\Development\RepositoryService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class RepositoryController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('development/repositories/index', [
            'repositories' => Repositorio::query()
                ->with(['proyecto:id,nombre'])
                ->latest()
                ->get(),
            'projects' => Proyecto::query()->orderBy('nombre')->get(['id', 'nombre']),
            'providerOptions' => Repositorio::PROVEEDORES,
        ]);
    }

    public function store(StoreRepositoryRequest $request, RepositoryService $service): RedirectResponse
    {
        $service->create($request->validated(), $request->user()->id);

        return back()->with('success', 'Repositorio registrado correctamente.');
    }

    public function update(UpdateRepositoryRequest $request, Repositorio $repository, RepositoryService $service): RedirectResponse
    {
        $service->update($repository, $request->validated(), $request->user()->id);

        return back()->with('success', 'Repositorio actualizado correctamente.');
    }

    public function destroy(Repositorio $repository, RepositoryService $service): RedirectResponse
    {
        $service->delete($repository);

        return back()->with('success', 'Repositorio eliminado correctamente.');
    }
}
