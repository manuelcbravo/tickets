<?php

namespace App\Http\Controllers\ProjectBilling;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectBilling\CancelProjectPaymentRequest;
use App\Http\Requests\ProjectBilling\ConfirmProjectPaymentRequest;
use App\Http\Requests\ProjectBilling\RejectProjectPaymentRequest;
use App\Http\Requests\ProjectBilling\StoreProjectPaymentRequest;
use App\Http\Requests\ProjectBilling\UpdateProjectPaymentRequest;
use App\Models\Client;
use App\Models\Proyecto;
use App\Models\ProyectoCargo;
use App\Models\ProyectoPago;
use App\Services\ProjectBilling\ProjectPaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectPaymentController extends Controller
{
    public function index(Request $request): Response
    {
        $filters = $request->only(['cliente_id', 'proyecto_id', 'estado', 'metodo_pago']);

        return Inertia::render('project-billing/payments/index', [
            'payments' => ProyectoPago::query()
                ->with(['cliente:id,nombre,razon_social', 'proyecto:id,nombre'])
                ->withCount('documentos')
                ->when($filters['cliente_id'] ?? null, fn ($query, $value) => $query->where('cliente_id', $value))
                ->when($filters['proyecto_id'] ?? null, fn ($query, $value) => $query->where('proyecto_id', $value))
                ->when($filters['estado'] ?? null, fn ($query, $value) => $query->where('estado', $value))
                ->when($filters['metodo_pago'] ?? null, fn ($query, $value) => $query->where('metodo_pago', $value))
                ->latest('fecha_pago')
                ->paginate(15)
                ->withQueryString(),
            'filters' => $filters,
            ...$this->formProps(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('project-billing/payments/form', [
            ...$this->formProps(),
            'payment' => null,
        ]);
    }

    public function store(StoreProjectPaymentRequest $request, ProjectPaymentService $service): RedirectResponse
    {
        $payment = $service->create($request->validated(), $request->user()->id);

        return redirect()->route('project-billing.payments.show', $payment)->with('success', 'Pago registrado correctamente.');
    }

    public function show(ProyectoPago $payment): Response
    {
        $payment->load(['cliente:id,nombre,razon_social', 'proyecto:id,nombre', 'aplicaciones.cargo', 'documentos.uploadedBy:id,name']);

        return Inertia::render('project-billing/payments/show', [
            'payment' => $payment->append(['monto_aplicado', 'saldo_disponible']),
            'pendingCharges' => ProyectoCargo::query()
                ->where('cliente_id', $payment->cliente_id)
                ->when($payment->proyecto_id, fn ($query) => $query->where('proyecto_id', $payment->proyecto_id))
                ->whereNotIn('estado', ['pagado', 'cancelado', 'condonado'])
                ->where('saldo', '>', 0)
                ->orderBy('fecha_vencimiento')
                ->get(),
            'metodos' => ProyectoPago::METODOS,
            'estados' => ProyectoPago::ESTADOS,
        ]);
    }

    public function edit(ProyectoPago $payment): Response
    {
        return Inertia::render('project-billing/payments/form', [
            ...$this->formProps(),
            'payment' => $payment,
        ]);
    }

    public function update(UpdateProjectPaymentRequest $request, ProyectoPago $payment, ProjectPaymentService $service): RedirectResponse
    {
        $service->update($payment, $request->validated());

        return redirect()->route('project-billing.payments.show', $payment)->with('success', 'Pago actualizado correctamente.');
    }

    public function confirm(ConfirmProjectPaymentRequest $request, ProyectoPago $payment, ProjectPaymentService $service): RedirectResponse
    {
        $service->confirm($payment, $request->user()->id);

        return back()->with('success', 'Pago confirmado.');
    }

    public function reject(RejectProjectPaymentRequest $request, ProyectoPago $payment, ProjectPaymentService $service): RedirectResponse
    {
        $service->reject($payment, $request->string('cancellation_reason')->toString(), $request->user()->id);

        return back()->with('success', 'Pago rechazado.');
    }

    public function cancel(CancelProjectPaymentRequest $request, ProyectoPago $payment, ProjectPaymentService $service): RedirectResponse
    {
        $service->cancel($payment, $request->string('cancellation_reason')->toString(), $request->user()->id);

        return back()->with('success', 'Pago cancelado.');
    }

    private function formProps(): array
    {
        return [
            'clientes' => Client::query()->orderBy('nombre')->get(['id', 'nombre', 'razon_social']),
            'proyectos' => Proyecto::query()->orderBy('nombre')->get(['id', 'nombre', 'client_id']),
            'metodos' => ProyectoPago::METODOS,
            'estados' => ProyectoPago::ESTADOS,
        ];
    }
}
