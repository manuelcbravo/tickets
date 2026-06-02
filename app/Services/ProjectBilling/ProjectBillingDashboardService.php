<?php

namespace App\Services\ProjectBilling;

use App\Models\Proyecto;
use App\Models\ProyectoCargo;
use App\Models\ProyectoPago;

class ProjectBillingDashboardService
{
    public function data(): array
    {
        app(ProjectBillingStatusService::class)->refreshOverdueCharges();

        return [
            'metrics' => [
                'totalPending' => (float) ProyectoCargo::query()->whereNotIn('estado', ['pagado', 'cancelado', 'condonado'])->sum('saldo'),
                'totalOverdue' => (float) ProyectoCargo::query()->where('estado', 'vencido')->sum('saldo'),
                'paymentsThisMonth' => (float) ProyectoPago::query()->whereMonth('fecha_pago', now()->month)->whereYear('fecha_pago', now()->year)->whereNotIn('estado', ['cancelado', 'rechazado'])->sum('monto'),
                'paymentsPendingConfirmation' => ProyectoPago::query()->where('estado', 'registrado')->count(),
                'projectsWithDebt' => Proyecto::query()->where('saldo_pendiente', '>', 0)->count(),
                'projectsWithoutPlan' => Proyecto::query()->whereDoesntHave('planCobro')->count(),
                'projectsCurrent' => Proyecto::query()->where('billing_status', 'al_corriente')->count(),
                'overdueCharges' => ProyectoCargo::query()->where('estado', 'vencido')->count(),
                'upcomingCharges' => ProyectoCargo::query()->whereNotIn('estado', ['pagado', 'cancelado', 'condonado'])->whereBetween('fecha_vencimiento', [now()->toDateString(), now()->addDays(7)->toDateString()])->count(),
            ],
            'overdueCharges' => ProyectoCargo::query()->with(['cliente:id,nombre,razon_social', 'proyecto:id,nombre'])->where('estado', 'vencido')->orderBy('fecha_vencimiento')->limit(10)->get(),
            'recentPayments' => ProyectoPago::query()->with(['cliente:id,nombre,razon_social', 'proyecto:id,nombre'])->latest('fecha_pago')->limit(10)->get(),
            'debtProjects' => Proyecto::query()->with('cliente:id,nombre,razon_social')->where('saldo_pendiente', '>', 0)->orderByDesc('saldo_pendiente')->limit(10)->get(['id', 'client_id', 'nombre', 'saldo_pendiente', 'saldo_vencido', 'proximo_vencimiento_at', 'billing_status']),
            'projectsWithoutPlan' => Proyecto::query()->with('cliente:id,nombre,razon_social')->whereDoesntHave('planCobro')->latest()->limit(10)->get(['id', 'client_id', 'nombre', 'estado', 'criticidad']),
        ];
    }
}
