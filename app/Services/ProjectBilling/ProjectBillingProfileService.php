<?php

namespace App\Services\ProjectBilling;

use App\Models\Proyecto;
use App\Models\ProyectoPlanCobro;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProjectBillingProfileService
{
    public function __construct(
        private readonly ProjectChargeService $charges,
        private readonly ProjectBillingStatusService $status,
        private readonly ProjectMonthlyChargeGeneratorService $monthlyCharges,
    ) {}

    public function create(Proyecto $proyecto, array $data, ?int $userId = null): ProyectoPlanCobro
    {
        return DB::transaction(function () use ($proyecto, $data, $userId) {
            $activePlan = ProyectoPlanCobro::query()
                ->where('proyecto_id', $proyecto->id)
                ->where('activo', true)
                ->where('estado', 'activo')
                ->first();

            if ($activePlan && ! ($data['reemplazar_plan_activo'] ?? false)) {
                throw ValidationException::withMessages([
                    'reemplazar_plan_activo' => 'Este proyecto ya tiene un plan de cobro activo.',
                ]);
            }

            if ($activePlan) {
                $activePlan->forceFill([
                    'activo' => false,
                    'estado' => 'terminado',
                    'updated_by_id' => $userId,
                ])->save();
            }

            $plan = ProyectoPlanCobro::query()->create([
                ...$this->planData($data),
                'proyecto_id' => $proyecto->id,
                'cliente_id' => $proyecto->client_id,
                'periodicidad' => $data['tipo_cobro'] === 'mensual' ? 'mensual' : ($data['periodicidad'] ?? null),
                'created_by_id' => $userId,
                'updated_by_id' => $userId,
            ]);

            if ($plan->tipo_cobro === 'unico') {
                $this->createInitialCharge($proyecto, $plan, $data, $userId);
            }

            if ($plan->tipo_cobro === 'mensual') {
                $summary = $this->monthlyCharges->generateContractCharges($plan->loadMissing('proyecto'), userId: $userId);
                $plan->setAttribute('generated_charges_count', $summary['generated']);
                $plan->setAttribute('skipped_charges_count', $summary['skipped']);
            }

            $this->status->refresh($proyecto);

            return $plan;
        });
    }

    public function update(ProyectoPlanCobro $plan, array $data, ?int $userId = null): ProyectoPlanCobro
    {
        DB::transaction(function () use ($plan, $data, $userId): void {
            $plan->fill($this->planData($data));
            $plan->updated_by_id = $userId;
            $plan->save();

            if ($plan->tipo_cobro === 'unico' && ($data['generar_cargo_inicial'] ?? false) && ! $plan->cargos()->exists()) {
                $this->createInitialCharge($plan->proyecto, $plan, $data, $userId);
            }

            if ($plan->tipo_cobro === 'mensual' && ($data['generar_cargos_mensuales'] ?? false)) {
                $this->monthlyCharges->generateContractCharges($plan->loadMissing('proyecto'), userId: $userId);
            }

            $this->status->refresh($plan->proyecto);
        });

        return $plan->refresh();
    }

    public function changeState(ProyectoPlanCobro $plan, string $estado, ?int $userId = null): ProyectoPlanCobro
    {
        $plan->forceFill([
            'estado' => $estado,
            'activo' => $estado === 'activo',
            'updated_by_id' => $userId,
        ])->save();

        $this->status->refresh($plan->proyecto);

        return $plan;
    }

    private function planData(array $data): array
    {
        return collect($data)
            ->only([
                'tipo_cobro',
                'moneda',
                'monto_total',
                'monto_mensual',
                'dia_vencimiento',
                'fecha_inicio',
                'fecha_fin',
                'periodicidad',
                'activo',
                'estado',
                'notas',
            ])
            ->all();
    }

    private function createInitialCharge(Proyecto $proyecto, ProyectoPlanCobro $plan, array $data, ?int $userId): void
    {
        if (! ($data['fecha_emision'] ?? null) || ! ($data['fecha_vencimiento'] ?? null) || ! $plan->monto_total) {
            throw ValidationException::withMessages([
                'fecha_vencimiento' => 'Para generar el cargo inicial se requiere monto, fecha de emision y fecha de vencimiento.',
            ]);
        }

        if ($plan->cargos()->exists()) {
            return;
        }

        $this->charges->create([
            'cliente_id' => $plan->cliente_id,
            'proyecto_id' => $plan->proyecto_id,
            'plan_cobro_id' => $plan->id,
            'concepto' => ($data['concepto_cargo'] ?? null) ?: 'Pago unico del proyecto '.$proyecto->nombre,
            'fecha_emision' => $data['fecha_emision'],
            'fecha_vencimiento' => $data['fecha_vencimiento'],
            'moneda' => $plan->moneda,
            'monto' => $plan->monto_total,
        ], $userId);
    }
}
