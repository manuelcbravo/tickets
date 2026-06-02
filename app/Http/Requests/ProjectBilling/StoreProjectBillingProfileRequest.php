<?php

namespace App\Http\Requests\ProjectBilling;

use App\Models\Proyecto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectBillingProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'cliente_id' => ['nullable', 'exists:clients,id'],
            'proyecto_id' => ['nullable', 'exists:projects,id'],
            'tipo_cobro' => ['required', Rule::in(['unico', 'parcialidades', 'mensual'])],
            'moneda' => ['required', 'string', 'size:3'],
            'monto_total' => ['nullable', 'numeric', 'min:0'],
            'monto_mensual' => ['nullable', 'numeric', 'min:0'],
            'dia_vencimiento' => ['nullable', 'integer', 'min:1', 'max:31'],
            'fecha_inicio' => ['nullable', 'date'],
            'fecha_fin' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'periodicidad' => ['nullable', 'string', 'max:40'],
            'activo' => ['boolean'],
            'notas' => ['nullable', 'string'],
            'generar_cargo_inicial' => ['boolean'],
            'generar_cargo_mes_actual' => ['boolean'],
            'generar_cargos_mensuales' => ['boolean'],
            'fecha_emision' => ['nullable', 'date'],
            'fecha_vencimiento' => ['nullable', 'date', 'after_or_equal:fecha_emision'],
            'concepto_cargo' => ['nullable', 'string', 'max:255'],
            'reemplazar_plan_activo' => ['boolean'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $tipo = $this->input('tipo_cobro');

            if (in_array($tipo, ['unico', 'parcialidades'], true) && ! $this->filled('monto_total')) {
                $validator->errors()->add('monto_total', 'El monto total es obligatorio para este tipo de cobro.');
            }

            if (in_array($tipo, ['unico', 'parcialidades'], true) && $this->filled('monto_total') && (float) $this->input('monto_total') <= 0) {
                $validator->errors()->add('monto_total', 'El monto total debe ser mayor a cero.');
            }

            if ($tipo === 'unico') {
                foreach (['fecha_emision', 'fecha_vencimiento'] as $field) {
                    if (! $this->filled($field)) {
                        $validator->errors()->add($field, 'Este campo es obligatorio para generar el cargo inicial.');
                    }
                }
            }

            if ($tipo === 'mensual') {
                foreach (['monto_mensual', 'dia_vencimiento', 'fecha_inicio', 'fecha_fin'] as $field) {
                    if (! $this->filled($field)) {
                        $validator->errors()->add($field, 'Este campo es obligatorio para mensualidades.');
                    }
                }

                if ($this->filled('monto_mensual') && (float) $this->input('monto_mensual') <= 0) {
                    $validator->errors()->add('monto_mensual', 'El monto mensual debe ser mayor a cero.');
                }
            }

            $proyecto = $this->route('proyecto') instanceof Proyecto
                ? $this->route('proyecto')
                : ($this->filled('proyecto_id') ? Proyecto::query()->find($this->input('proyecto_id')) : null);

            if (! $proyecto) {
                $validator->errors()->add('proyecto_id', 'Selecciona un proyecto valido.');

                return;
            }

            if (! $proyecto->client_id) {
                $validator->errors()->add('proyecto_id', 'El proyecto seleccionado no tiene cliente asignado.');
            }

            if ($this->filled('cliente_id') && $proyecto->client_id !== $this->input('cliente_id')) {
                $validator->errors()->add('proyecto_id', 'El proyecto no pertenece al cliente seleccionado.');
            }

            if ($this->isMethod('post') && $proyecto->planCobro()->exists() && ! $this->boolean('reemplazar_plan_activo')) {
                $validator->errors()->add('reemplazar_plan_activo', 'Este proyecto ya tiene un plan de cobro activo.');
            }
        });
    }
}
