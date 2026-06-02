<?php

namespace App\Services\ProjectBilling;

use App\Models\ProyectoPlanCobro;
use App\Models\ProyectoCargo;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Throwable;

class ProjectMonthlyChargeGeneratorService
{
    public function __construct(private readonly ProjectChargeService $charges) {}

    public function generate(?string $month = null, ?int $userId = null): array
    {
        $period = $month
            ? CarbonImmutable::createFromFormat('Y-m', $month)->startOfMonth()
            : CarbonImmutable::now()->startOfMonth();
        $periodEnd = $period->endOfMonth();

        $summary = ['generated' => 0, 'skipped' => 0, 'errors' => []];

        ProyectoPlanCobro::query()
            ->with('proyecto')
            ->where('tipo_cobro', 'mensual')
            ->where('activo', true)
            ->where('estado', 'activo')
            ->chunkById(100, function (Collection $plans) use (&$summary, $period, $periodEnd, $userId) {
                foreach ($plans as $plan) {
                    try {
                        $cargo = $this->generateForPlan($plan, $period->format('Y-m'), $userId);

                        if (! $cargo) {
                            $summary['skipped']++;
                            continue;
                        }

                        $summary['generated']++;
                    } catch (Throwable $exception) {
                        $summary['errors'][] = $exception->getMessage();
                    }
                }
            });

        return $summary;
    }

    public function generateForPlan(ProyectoPlanCobro $plan, ?string $month = null, ?int $userId = null): ?ProyectoCargo
    {
        $period = $month
            ? CarbonImmutable::createFromFormat('Y-m', $month)->startOfMonth()
            : CarbonImmutable::now()->startOfMonth();

        if (! $this->shouldGenerate($plan, $period)) {
            return null;
        }

        return $this->createMonthlyCharge($plan, $period, $period->endOfMonth(), $period, $userId);
    }

    public function generateContractCharges(ProyectoPlanCobro $plan, ?int $userId = null): array
    {
        $plan->loadMissing('proyecto');

        if ($plan->tipo_cobro !== 'mensual') {
            return ['generated' => 0, 'skipped' => 0];
        }

        if (! $plan->monto_mensual || ! $plan->dia_vencimiento || ! $plan->fecha_inicio || ! $plan->fecha_fin) {
            throw ValidationException::withMessages([
                'fecha_fin' => 'Para generar cobranza mensual se requiere monto mensual, dia de vencimiento, fecha de inicio y fecha fin.',
            ]);
        }

        $start = CarbonImmutable::parse($plan->fecha_inicio);
        $end = CarbonImmutable::parse($plan->fecha_fin);

        if ($end->lt($start)) {
            throw ValidationException::withMessages([
                'fecha_fin' => 'La fecha fin debe ser posterior o igual a la fecha de inicio.',
            ]);
        }

        $summary = ['generated' => 0, 'skipped' => 0];
        $cursor = $start->startOfMonth();

        while ($cursor->lte($end->startOfMonth())) {
            if ($this->shouldGenerate($plan, $cursor)) {
                $periodStart = $cursor->isSameMonth($start) ? $start : $cursor->startOfMonth();
                $periodEnd = $cursor->isSameMonth($end) ? $end : $cursor->endOfMonth();

                $charge = $this->createMonthlyCharge($plan, $periodStart, $periodEnd, $cursor, $userId);

                if ($charge) {
                    $summary['generated']++;
                } else {
                    $summary['skipped']++;
                }
            } else {
                $summary['skipped']++;
            }

            $cursor = $cursor->addMonthNoOverflow()->startOfMonth();
        }

        return $summary;
    }

    private function createMonthlyCharge(ProyectoPlanCobro $plan, CarbonImmutable $periodStart, CarbonImmutable $periodEnd, CarbonImmutable $dueMonth, ?int $userId): ?ProyectoCargo
    {
        $exists = $plan->cargos()
            ->whereDate('periodo_inicio', $periodStart->toDateString())
            ->whereDate('periodo_fin', $periodEnd->toDateString())
            ->exists();

        if ($exists) {
            return null;
        }

        $dueMonthEnd = $dueMonth->endOfMonth();
        $dueDay = min((int) $plan->dia_vencimiento, $dueMonthEnd->day);
        $projectName = $plan->proyecto?->nombre ?? 'proyecto';

        return $this->charges->create([
            'cliente_id' => $plan->cliente_id,
            'proyecto_id' => $plan->proyecto_id,
            'plan_cobro_id' => $plan->id,
            'concepto' => 'Mensualidad '.$this->monthLabel($dueMonth).' - '.$projectName,
            'periodo_inicio' => $periodStart->toDateString(),
            'periodo_fin' => $periodEnd->toDateString(),
            'fecha_emision' => $periodStart->toDateString(),
            'fecha_vencimiento' => $dueMonth->day($dueDay)->toDateString(),
            'moneda' => $plan->moneda,
            'monto' => $plan->monto_mensual,
        ], $userId);
    }

    private function shouldGenerate(ProyectoPlanCobro $plan, CarbonImmutable $period): bool
    {
        if (! $plan->fecha_inicio || $period->endOfMonth()->lt($plan->fecha_inicio)) {
            return false;
        }

        if ($plan->fecha_fin && $period->startOfMonth()->gt($plan->fecha_fin)) {
            return false;
        }

        return ! in_array($plan->proyecto?->estado, ['cerrado', 'cancelado', 'sin_soporte'], true);
    }

    private function monthLabel(CarbonImmutable $period): string
    {
        $months = [
            1 => 'enero',
            2 => 'febrero',
            3 => 'marzo',
            4 => 'abril',
            5 => 'mayo',
            6 => 'junio',
            7 => 'julio',
            8 => 'agosto',
            9 => 'septiembre',
            10 => 'octubre',
            11 => 'noviembre',
            12 => 'diciembre',
        ];

        return $months[$period->month].' '.$period->year;
    }
}
