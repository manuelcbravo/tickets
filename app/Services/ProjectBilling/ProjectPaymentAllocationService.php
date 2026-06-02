<?php

namespace App\Services\ProjectBilling;

use App\Models\ProyectoCargo;
use App\Models\ProyectoPago;
use App\Models\ProyectoPagoAplicacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProjectPaymentAllocationService
{
    public function __construct(
        private readonly ProjectChargeService $charges,
        private readonly ProjectBillingStatusService $status,
    ) {}

    public function apply(ProyectoPago $pago, ProyectoCargo $cargo, float $amount, ?int $userId = null): ProyectoPagoAplicacion
    {
        return DB::transaction(function () use ($pago, $cargo, $amount, $userId) {
            if (in_array($pago->estado, ['cancelado', 'rechazado'], true)) {
                throw ValidationException::withMessages(['pago_id' => 'No se puede aplicar un pago cancelado o rechazado.']);
            }
            if (in_array($cargo->estado, ['cancelado', 'condonado'], true)) {
                throw ValidationException::withMessages(['cargo_id' => 'No se puede aplicar pago a un cargo cancelado o condonado.']);
            }
            if ($amount <= 0 || $amount > (float) $cargo->saldo) {
                throw ValidationException::withMessages(['monto_aplicado' => 'El monto excede el saldo del cargo.']);
            }
            if ($amount > $pago->saldo_disponible) {
                throw ValidationException::withMessages(['monto_aplicado' => 'El monto excede el saldo disponible del pago.']);
            }

            $application = ProyectoPagoAplicacion::query()->create([
                'pago_id' => $pago->id,
                'cargo_id' => $cargo->id,
                'monto_aplicado' => $amount,
                'created_by_id' => $userId,
            ]);

            $this->charges->recalculate($cargo);
            $this->status->refresh($cargo->proyecto);

            return $application;
        });
    }

    public function destroy(ProyectoPagoAplicacion $application): void
    {
        DB::transaction(function () use ($application) {
            $cargo = $application->cargo;
            $application->delete();
            $this->charges->recalculate($cargo);
            $this->status->refresh($cargo->proyecto);
        });
    }
}
