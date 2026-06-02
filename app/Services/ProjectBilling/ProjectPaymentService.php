<?php

namespace App\Services\ProjectBilling;

use App\Models\ProyectoPago;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProjectPaymentService
{
    public function __construct(
        private readonly BillingFolioService $folios,
        private readonly ProjectPaymentAllocationService $allocations,
        private readonly ProjectBillingStatusService $status,
    ) {}

    public function create(array $data, ?int $userId = null): ProyectoPago
    {
        return DB::transaction(function () use ($data, $userId) {
            $payment = ProyectoPago::query()->create([
                ...$data,
                'folio' => $this->folios->next(ProyectoPago::class, 'PAGO', 'proyecto_pagos'),
                'estado' => $data['estado'] ?? 'registrado',
                'registrado_por_id' => $userId,
            ]);

            $this->status->refresh($payment->proyecto_id);

            return $payment;
        });
    }

    public function update(ProyectoPago $payment, array $data): ProyectoPago
    {
        if (in_array($payment->estado, ['cancelado', 'rechazado'], true)) {
            throw ValidationException::withMessages(['pago' => 'No se puede editar un pago cancelado o rechazado.']);
        }

        $payment->update($data);
        $this->status->refresh($payment->proyecto_id);

        return $payment;
    }

    public function confirm(ProyectoPago $payment, ?int $userId = null): ProyectoPago
    {
        $payment->forceFill([
            'estado' => 'confirmado',
            'confirmado_por_id' => $userId,
            'confirmado_at' => now(),
        ])->save();

        $this->status->refresh($payment->proyecto_id);

        return $payment;
    }

    public function reject(ProyectoPago $payment, string $reason, ?int $userId = null): ProyectoPago
    {
        return $this->cancelLike($payment, 'rechazado', $reason, $userId);
    }

    public function cancel(ProyectoPago $payment, string $reason, ?int $userId = null): ProyectoPago
    {
        return $this->cancelLike($payment, 'cancelado', $reason, $userId);
    }

    private function cancelLike(ProyectoPago $payment, string $status, string $reason, ?int $userId): ProyectoPago
    {
        return DB::transaction(function () use ($payment, $status, $reason, $userId) {
            $applications = $payment->aplicaciones()->with('cargo')->get();
            foreach ($applications as $application) {
                $this->allocations->destroy($application);
            }

            $payment->forceFill([
                'estado' => $status,
                'cancelado_por_id' => $userId,
                'cancelado_at' => now(),
                'cancellation_reason' => $reason,
            ])->save();

            $this->status->refresh($payment->proyecto_id);

            return $payment;
        });
    }
}
