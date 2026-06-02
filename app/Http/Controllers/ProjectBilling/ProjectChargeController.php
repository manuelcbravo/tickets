<?php

namespace App\Http\Controllers\ProjectBilling;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectBilling\CancelProjectChargeRequest;
use App\Http\Requests\ProjectBilling\ForgiveProjectChargeRequest;
use App\Http\Requests\ProjectBilling\StoreProjectChargeRequest;
use App\Http\Requests\ProjectBilling\UpdateProjectChargeRequest;
use App\Models\Client;
use App\Models\Proyecto;
use App\Models\ProyectoCargo;
use App\Services\ProjectBilling\ProjectChargeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectChargeController extends Controller
{
    public function index(Request $request): Response
    {
        $filters = $request->only(['cliente_id', 'proyecto_id', 'estado', 'vencidos', 'por_vencer']);

        return Inertia::render('project-billing/charges/index', [
            'charges' => ProyectoCargo::query()
                ->with(['cliente:id,nombre,razon_social', 'proyecto:id,nombre'])
                ->when($filters['cliente_id'] ?? null, fn ($query, $value) => $query->where('cliente_id', $value))
                ->when($filters['proyecto_id'] ?? null, fn ($query, $value) => $query->where('proyecto_id', $value))
                ->when($filters['estado'] ?? null, fn ($query, $value) => $query->where('estado', $value))
                ->when($request->boolean('vencidos'), fn ($query) => $query->where('estado', 'vencido'))
                ->when($request->boolean('por_vencer'), fn ($query) => $query->whereBetween('fecha_vencimiento', [now()->toDateString(), now()->addDays(7)->toDateString()]))
                ->orderByDesc('fecha_vencimiento')
                ->paginate(15)
                ->withQueryString(),
            'filters' => $filters,
            'clientes' => Client::query()->orderBy('nombre')->get(['id', 'nombre', 'razon_social']),
            'proyectos' => Proyecto::query()->orderBy('nombre')->get(['id', 'nombre', 'client_id']),
            'estados' => ProyectoCargo::ESTADOS,
        ]);
    }

    public function store(StoreProjectChargeRequest $request, Proyecto $proyecto, ProjectChargeService $service): RedirectResponse
    {
        $service->create([
            ...$request->validated(),
            'cliente_id' => $request->input('cliente_id') ?: $proyecto->client_id,
            'proyecto_id' => $proyecto->id,
        ], $request->user()->id);

        return back()->with('success', 'Cargo creado correctamente.');
    }

    public function update(UpdateProjectChargeRequest $request, Proyecto $proyecto, ProyectoCargo $charge, ProjectChargeService $service): RedirectResponse
    {
        abort_unless($charge->proyecto_id === $proyecto->id, 404);
        $service->update($charge, [
            ...$request->validated(),
            'cliente_id' => $request->input('cliente_id') ?: $proyecto->client_id,
            'proyecto_id' => $proyecto->id,
        ], $request->user()->id);

        return back()->with('success', 'Cargo actualizado correctamente.');
    }

    public function cancel(CancelProjectChargeRequest $request, Proyecto $proyecto, ProyectoCargo $charge, ProjectChargeService $service): RedirectResponse
    {
        abort_unless($charge->proyecto_id === $proyecto->id, 404);
        $service->cancel($charge, $request->string('cancellation_reason')->toString(), $request->user()->id);

        return back()->with('success', 'Cargo cancelado.');
    }

    public function forgive(ForgiveProjectChargeRequest $request, Proyecto $proyecto, ProyectoCargo $charge, ProjectChargeService $service): RedirectResponse
    {
        abort_unless($charge->proyecto_id === $proyecto->id, 404);
        $service->cancel($charge, $request->string('cancellation_reason')->toString(), $request->user()->id, 'condonado');

        return back()->with('success', 'Cargo condonado.');
    }
}
