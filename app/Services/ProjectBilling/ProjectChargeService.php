<?php

namespace App\Services\ProjectBilling;

use App\Models\Proyecto;
use App\Models\ProyectoCargo;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProjectChargeService
{
    public function __construct(
        private readonly BillingFolioService $folios,
        private readonly ProjectBillingStatusService $status,
    ) {}

    public function create(array $data, ?int $userId = null): ProyectoCargo
    {
        return DB::transaction(function () use ($data, $userId) {
            $proyecto = Proyecto::query()->findOrFail($data['proyecto_id']);
            $monto = (float) $data['monto'];

            if ($monto <= 0) {
                throw ValidationException::withMessages(['monto' => 'El monto debe ser mayor a cero.']);
            }

            $cargo = ProyectoCargo::query()->create([
                ...$data,
                'folio' => $this->folios->next(ProyectoCargo::class, 'CARGO', 'proyecto_cargos'),
                'cliente_id' => $data['cliente_id'] ?? $proyecto->client_id,
                'monto_pagado' => 0,
                'saldo' => $monto,
                'estado' => $this->statusFor($monto, 0, $data['fecha_vencimiento']),
                'created_by_id' => $userId,
                'updated_by_id' => $userId,
            ]);

            $this->status->refresh($proyecto);

            return $cargo;
        });
    }

    public function update(ProyectoCargo $cargo, array $data, ?int $userId = null): ProyectoCargo
    {
        if (in_array($cargo->estado, ['cancelado', 'condonado'], true)) {
            throw ValidationException::withMessages(['cargo' => 'No se puede editar un cargo cancelado o condonado.']);
        }

        return DB::transaction(function () use ($cargo, $data, $userId) {
            $cargo->fill($data);
            $cargo->updated_by_id = $userId;
            $cargo->save();
            $this->recalculate($cargo);
            $this->status->refresh($cargo->proyecto);

            return $cargo->refresh();
        });
    }

    public function cancel(ProyectoCargo $cargo, string $reason, ?int $userId = null, string $estado = 'cancelado'): ProyectoCargo
    {
        return DB::transaction(function () use ($cargo, $reason, $userId, $estado) {
            if ($cargo->aplicaciones()->exists()) {
                throw ValidationException::withMessages(['cargo' => 'No se puede cancelar un cargo con pagos aplicados.']);
            }

            $cargo->forceFill([
                'estado' => $estado,
                'cancelled_by_id' => $userId,
                'cancelled_at' => now(),
                'cancellation_reason' => $reason,
            ])->save();

            $this->status->refresh($cargo->proyecto);

            return $cargo;
        });
    }

    public function recalculate(ProyectoCargo $cargo): ProyectoCargo
    {
        $paid = (float) $cargo->aplicaciones()->sum('monto_aplicado');
        $saldo = max(0, (float) $cargo->monto - $paid);

        $cargo->forceFill([
            'monto_pagado' => $paid,
            'saldo' => $saldo,
            'estado' => in_array($cargo->estado, ['cancelado', 'condonado'], true)
                ? $cargo->estado
                : $this->statusFor((float) $cargo->monto, $paid, $cargo->fecha_vencimiento?->toDateString() ?? now()->toDateString()),
        ])->save();

        return $cargo;
    }

    private function statusFor(float $monto, float $paid, string $dueDate): string
    {
        $saldo = max(0, $monto - $paid);

        if ($saldo <= 0) {
            return 'pagado';
        }

        if ($paid > 0) {
            return 'pagado_parcial';
        }

        return $dueDate < now()->toDateString() ? 'vencido' : 'pendiente';
    }
}
