<?php

namespace App\Http\Controllers\Integrations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Integrations\StoreIntegrationRequest;
use App\Http\Requests\Integrations\UpdateIntegrationRequest;
use App\Models\Integracion;
use App\Services\Integrations\IntegrationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class IntegrationController extends Controller
{
    public function index(Request $request, IntegrationService $service): Response
    {
        $integrations = Integracion::query()
            ->with(['createdBy:id,name', 'updatedBy:id,name'])
            ->when($request->string('search')->toString(), fn ($query, string $search) => $query->where(function ($nested) use ($search): void {
                $nested->where('nombre', 'ilike', "%{$search}%")
                    ->orWhere('tipo', 'ilike', "%{$search}%")
                    ->orWhere('proveedor', 'ilike', "%{$search}%");
            }))
            ->when($request->input('tipo'), fn ($query, $value) => $query->where('tipo', $value))
            ->when($request->input('activo') !== null, fn ($query) => $query->where('activo', request()->boolean('activo')))
            ->latest()
            ->paginate(15)
            ->through(fn (Integracion $integration) => [
                ...$integration->toArray(),
                'config' => $service->safeConfig($integration->config),
            ])
            ->withQueryString();

        return Inertia::render('integrations/index', [
            'integrations' => $integrations,
            'filters' => $request->only(['search', 'tipo', 'activo']),
            'types' => Integracion::TIPOS,
            'providers' => Integracion::PROVEEDORES,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('integrations/form', $this->options());
    }

    public function store(StoreIntegrationRequest $request, IntegrationService $service): RedirectResponse
    {
        $integration = $service->create($request->validated(), $request->user()->id);

        return redirect()->route('integrations.show', $integration)->with('success', 'Integracion creada correctamente.');
    }

    public function show(Integracion $integration, IntegrationService $service): Response
    {
        $integration->load(['createdBy:id,name', 'updatedBy:id,name']);

        return Inertia::render('integrations/show', [
            'integration' => [
                ...$integration->toArray(),
                'config' => $service->safeConfig($integration->config),
            ],
            'webhookEvents' => $integration->webhookEvents()->latest()->limit(10)->get(),
            'notificationLogs' => $integration->notificationLogs()->latest()->limit(10)->get(),
            'externalMessages' => $integration->externalMessages()->latest()->limit(10)->get(),
        ]);
    }

    public function edit(Integracion $integration, IntegrationService $service): Response
    {
        return Inertia::render('integrations/form', [
            ...$this->options(),
            'integration' => [
                ...$integration->toArray(),
                'config' => $service->safeConfig($integration->config),
            ],
        ]);
    }

    public function update(UpdateIntegrationRequest $request, Integracion $integration, IntegrationService $service): RedirectResponse
    {
        $service->update($integration, $request->validated(), $request->user()->id);

        return redirect()->route('integrations.show', $integration)->with('success', 'Integracion actualizada correctamente.');
    }

    public function destroy(Integracion $integration): RedirectResponse
    {
        $integration->delete();

        return redirect()->route('integrations.index')->with('success', 'Integracion eliminada.');
    }

    public function activate(Integracion $integration, IntegrationService $service): RedirectResponse
    {
        $service->activate($integration, auth()->id());

        return back()->with('success', 'Integracion activada.');
    }

    public function deactivate(Integracion $integration, IntegrationService $service): RedirectResponse
    {
        $service->deactivate($integration, auth()->id());

        return back()->with('success', 'Integracion desactivada.');
    }

    private function options(): array
    {
        return [
            'types' => Integracion::TIPOS,
            'providers' => Integracion::PROVEEDORES,
        ];
    }
}
