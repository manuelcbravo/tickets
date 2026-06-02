<?php

namespace App\Http\Requests\ProjectBilling;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectPaymentAllocationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'cargo_id' => ['required', 'exists:proyecto_cargos,id'],
            'monto_aplicado' => ['required', 'numeric', 'min:0.01'],
        ];
    }
}
