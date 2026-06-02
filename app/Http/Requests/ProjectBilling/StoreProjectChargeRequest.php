<?php

namespace App\Http\Requests\ProjectBilling;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectChargeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'cliente_id' => ['nullable', 'exists:clients,id'],
            'plan_cobro_id' => ['nullable', 'exists:proyecto_planes_cobro,id'],
            'cotizacion_id' => ['nullable', 'exists:cotizaciones,id'],
            'concepto' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'periodo_inicio' => ['nullable', 'date'],
            'periodo_fin' => ['nullable', 'date', 'after_or_equal:periodo_inicio'],
            'fecha_emision' => ['required', 'date'],
            'fecha_vencimiento' => ['required', 'date'],
            'moneda' => ['required', 'string', 'size:3'],
            'monto' => ['required', 'numeric', 'min:0.01'],
        ];
    }
}
