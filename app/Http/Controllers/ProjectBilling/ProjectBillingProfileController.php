<?php

namespace App\Http\Controllers\ProjectBilling;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectBilling\StoreProjectBillingProfileRequest;
use App\Http\Requests\ProjectBilling\UpdateProjectBillingProfileRequest;
use App\Models\Client;
use App\Models\Proyecto;
use App\Models\ProyectoPlanCobro;
use App\Services\ProjectBilling\ProjectBillingProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class ProjectBillingProfileController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('project-billing/profiles/form', [
            ...$this->formProps(),
            'profile' => null,
        ]);
    }

    public function storeGlobal(StoreProjectBillingProfileRequest $request, ProjectBillingProfileService $service): RedirectResponse
    {
        $data = $request->validated();
        $proyecto = Proyecto::query()->findOrFail($data['proyecto_id']);

        try {
            $plan = $service->create($proyecto, $data, $request->user()->id);
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable) {
            return back()->with('error', $this->failureMessage($data['tipo_cobro'] ?? null))->withInput();
        }

        return redirect()
            ->route('proyectos.show', $proyecto)
            ->with('success', $this->successMessage($plan));
    }

    public function edit(ProyectoPlanCobro $profile): Response
    {
        $profile->load(['proyecto:id,nombre,client_id', 'cliente:id,nombre,razon_social']);

        return Inertia::render('project-billing/profiles/form', [
            ...$this->formProps(),
            'profile' => $profile,
        ]);
    }

    public function updateGlobal(UpdateProjectBillingProfileRequest $request, ProyectoPlanCobro $profile, ProjectBillingProfileService $service): RedirectResponse
    {
        $service->update($profile, $request->validated(), $request->user()->id);

        return redirect()
            ->route('proyectos.show', $profile->proyecto)
            ->with('success', 'Plan de cobro actualizado correctamente.');
    }

    public function store(StoreProjectBillingProfileRequest $request, Proyecto $proyecto, ProjectBillingProfileService $service): RedirectResponse
    {
        $data = $request->validated();

        try {
            $plan = $service->create($proyecto, $data, $request->user()->id);
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable) {
            return back()->with('error', $this->failureMessage($data['tipo_cobro'] ?? null))->withInput();
        }

        return back()->with('success', $this->successMessage($plan));
    }

    public function update(UpdateProjectBillingProfileRequest $request, Proyecto $proyecto, ProyectoPlanCobro $profile, ProjectBillingProfileService $service): RedirectResponse
    {
        abort_unless($profile->proyecto_id === $proyecto->id, 404);
        $service->update($profile, $request->validated(), $request->user()->id);

        return back()->with('success', 'Plan de cobro actualizado correctamente.');
    }

    public function activate(Proyecto $proyecto, ProyectoPlanCobro $profile, ProjectBillingProfileService $service): RedirectResponse
    {
        abort_unless($profile->proyecto_id === $proyecto->id, 404);
        $service->changeState($profile, 'activo', request()->user()?->id);

        return back()->with('success', 'Plan de cobro activado.');
    }

    public function pause(Proyecto $proyecto, ProyectoPlanCobro $profile, ProjectBillingProfileService $service): RedirectResponse
    {
        abort_unless($profile->proyecto_id === $proyecto->id, 404);
        $service->changeState($profile, 'pausado', request()->user()?->id);

        return back()->with('success', 'Plan de cobro pausado.');
    }

    public function cancel(Proyecto $proyecto, ProyectoPlanCobro $profile, ProjectBillingProfileService $service): RedirectResponse
    {
        abort_unless($profile->proyecto_id === $proyecto->id, 404);
        $service->changeState($profile, 'cancelado', request()->user()?->id);

        return back()->with('success', 'Plan de cobro cancelado.');
    }

    private function formProps(): array
    {
        return [
            'clientes' => Client::query()
                ->orderBy('nombre')
                ->get(['id', 'nombre', 'razon_social', 'estatus']),
            'proyectos' => Proyecto::query()
                ->with('planCobro:id,proyecto_id,tipo_cobro,estado,activo')
                ->orderBy('nombre')
                ->get(['id', 'client_id', 'nombre']),
            'tipoCobroOptions' => ProyectoPlanCobro::TIPOS,
        ];
    }

    private function successMessage(ProyectoPlanCobro $plan): string
    {
        return match ($plan->tipo_cobro) {
            'unico' => 'Plan de cobro configurado y cargo generado correctamente.',
            'mensual' => ((int) $plan->getAttribute('generated_charges_count')) > 0
                ? 'Plan mensual configurado y cargos generados correctamente.'
                : 'El plan ya tiene cargos generados para ese periodo.',
            'parcialidades' => 'Plan de cobro configurado. Genera las parcialidades para crear cargos.',
            default => 'Plan de cobro configurado correctamente.',
        };
    }

    private function failureMessage(?string $type): string
    {
        return match ($type) {
            'unico' => 'No se pudo generar el cargo inicial.',
            'mensual' => 'No se pudo generar la cobranza mensual.',
            default => 'No se pudo configurar el plan de cobro.',
        };
    }
}
