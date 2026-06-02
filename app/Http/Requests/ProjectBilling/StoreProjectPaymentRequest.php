<?php

namespace App\Http\Requests\ProjectBilling;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectPaymentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'cliente_id' => ['required', 'exists:clients,id'],
            'proyecto_id' => ['nullable', 'exists:projects,id'],
            'fecha_pago' => ['required', 'date'],
            'moneda' => ['required', 'string', 'size:3'],
            'monto' => ['required', 'numeric', 'min:0.01'],
            'metodo_pago' => ['nullable', 'string', 'max:40'],
            'referencia' => ['nullable', 'string', 'max:255'],
            'banco' => ['nullable', 'string', 'max:255'],
            'cuenta_origen' => ['nullable', 'string', 'max:255'],
            'notas' => ['nullable', 'string'],
        ];
    }
}
