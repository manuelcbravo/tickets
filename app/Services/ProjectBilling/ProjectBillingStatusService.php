<?php

namespace App\Services\ProjectBilling;

use App\Models\Proyecto;
use App\Models\ProyectoCargo;

class ProjectBillingStatusService
{
    public function refresh(Proyecto|string|null $proyecto): ?Proyecto
    {
        if (! $proyecto) {
            return null;
        }

        $proyecto = $proyecto instanceof Proyecto ? $proyecto : Proyecto::query()->find($proyecto);

        if (! $proyecto) {
            return null;
        }

        $this->refreshOverdueCharges($proyecto);

        $pending = (float) ProyectoCargo::query()
            ->where('proyecto_id', $proyecto->id)
            ->whereNotIn('estado', ['cancelado', 'condonado', 'pagado'])
            ->sum('saldo');

        $overdue = (float) ProyectoCargo::query()
            ->where('proyecto_id', $proyecto->id)
            ->whereNotIn('estado', ['cancelado', 'condonado', 'pagado'])
            ->where('saldo', '>', 0)
            ->whereDate('fecha_vencimiento', '<', now()->toDateString())
            ->sum('saldo');

        $nextDue = ProyectoCargo::query()
            ->where('proyecto_id', $proyecto->id)
            ->whereNotIn('estado', ['cancelado', 'condonado', 'pagado'])
            ->where('saldo', '>', 0)
            ->orderBy('fecha_vencimiento')
            ->value('fecha_vencimiento');

        $lastPayment = $proyecto->pagos()->whereIn('estado', ['registrado', 'confirmado'])->max('fecha_pago');
        $status = $overdue > 0 ? 'vencido' : ($pending > 0 ? 'pendiente' : ($proyecto->planCobro()->exists() ? 'al_corriente' : 'sin_configurar'));

        $proyecto->forceFill([
            'saldo_pendiente' => $pending,
            'saldo_vencido' => $overdue,
            'ultimo_pago_at' => $lastPayment,
            'proximo_vencimiento_at' => $nextDue,
            'billing_status' => $status,
        ])->save();

        return $proyecto;
    }

    public function refreshOverdueCharges(?Proyecto $proyecto = null): void
    {
        ProyectoCargo::query()
            ->when($proyecto, fn ($query) => $query->where('proyecto_id', $proyecto->id))
            ->where('estado', 'pendiente')
            ->where('saldo', '>', 0)
            ->whereDate('fecha_vencimiento', '<', now()->toDateString())
            ->update(['estado' => 'vencido']);
    }
}
