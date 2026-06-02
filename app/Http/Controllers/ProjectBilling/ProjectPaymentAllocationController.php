<?php

namespace App\Http\Controllers\ProjectBilling;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectBilling\StoreProjectPaymentAllocationRequest;
use App\Models\ProyectoCargo;
use App\Models\ProyectoPago;
use App\Models\ProyectoPagoAplicacion;
use App\Services\ProjectBilling\ProjectPaymentAllocationService;
use Illuminate\Http\RedirectResponse;

class ProjectPaymentAllocationController extends Controller
{
    public function store(StoreProjectPaymentAllocationRequest $request, ProyectoPago $payment, ProjectPaymentAllocationService $service): RedirectResponse
    {
        $cargo = ProyectoCargo::query()->findOrFail($request->input('cargo_id'));
        $service->apply($payment, $cargo, (float) $request->input('monto_aplicado'), $request->user()->id);

        return back()->with('success', 'Pago aplicado al cargo.');
    }

    public function destroy(ProyectoPago $payment, ProyectoPagoAplicacion $allocation, ProjectPaymentAllocationService $service): RedirectResponse
    {
        abort_unless($allocation->pago_id === $payment->id, 404);
        $service->destroy($allocation);

        return back()->with('success', 'Aplicacion eliminada.');
    }
}
