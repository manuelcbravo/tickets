<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Clientes\StoreClienteRequest;
use App\Http\Requests\Clientes\UpdateClienteRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ClienteController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('clientes/index', [
            'clientes' => Client::query()
                ->withCount(['contactos', 'proyectos'])
                ->latest()
                ->get(),
            'estatusOptions' => Client::ESTATUS,
            'clasificacionOptions' => Client::CLASIFICACIONES,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('clientes/create', [
            'estatusOptions' => Client::ESTATUS,
            'clasificacionOptions' => Client::CLASIFICACIONES,
        ]);
    }

    public function store(StoreClienteRequest $request): RedirectResponse
    {
        $client = Client::query()->create($this->clientPayload($request->validated()));

        return redirect()
            ->route('clientes.show', $client)
            ->with('success', 'Cliente creado correctamente.');
    }

    public function show(Client $client): Response
    {
        $client->load([
            'contactos' => fn ($query) => $query->latest('es_principal')->latest(),
            'proyectos.cliente',
            'proyectos.responsableTecnico:id,name',
        ]);

        return Inertia::render('clientes/show', [
            'cliente' => $client,
            'contactos' => $client->contactos,
            'proyectos' => $client->proyectos,
            'contactoTipoOptions' => \App\Models\ClienteContacto::TIPOS,
            'clientesSelect' => $this->clientesSelect(),
            'users' => User::query()->orderBy('name')->get(['id', 'name']),
            'proyectoEstadoOptions' => \App\Models\Proyecto::ESTADOS,
            'proyectoCriticidadOptions' => \App\Models\Proyecto::CRITICIDADES,
        ]);
    }

    public function edit(Client $client): Response
    {
        return Inertia::render('clientes/edit', [
            'cliente' => $client,
            'estatusOptions' => Client::ESTATUS,
            'clasificacionOptions' => Client::CLASIFICACIONES,
        ]);
    }

    public function update(UpdateClienteRequest $request, Client $client): RedirectResponse
    {
        $client->update($this->clientPayload($request->validated()));

        return redirect()
            ->route('clientes.show', $client)
            ->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }

    public function proyectos(Client $client): JsonResponse
    {
        return response()->json([
            'data' => $client->proyectos()
                ->orderBy('nombre')
                ->get(['id', 'nombre', 'estado', 'criticidad']),
        ]);
    }

    private function clientPayload(array $data): array
    {
        return [
            'nombre' => $data['nombre'],
            'razon_social' => $data['razon_social'] ?? null,
            'first_name' => $data['nombre'],
            'last_name' => $data['razon_social'] ?? '-',
            'rfc' => $data['rfc'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['telefono'] ?? null,
            'sitio_web' => $data['sitio_web'] ?? null,
            'estatus' => $data['estatus'],
            'clasificacion' => $data['clasificacion'] ?? null,
            'notas_internas' => $data['notas_internas'] ?? null,
            'is_active' => $data['estatus'] !== 'inactivo',
            'is_blacklisted' => in_array($data['estatus'], ['suspendido', 'moroso'], true),
        ];
    }

    private function clientesSelect()
    {
        return Client::query()
            ->orderByRaw("case when estatus in ('suspendido', 'moroso') then 1 else 0 end")
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'razon_social', 'estatus']);
    }
}
