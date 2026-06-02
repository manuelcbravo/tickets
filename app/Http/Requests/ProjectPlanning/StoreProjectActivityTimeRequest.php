<?php

namespace App\Http\Requests\ProjectPlanning;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectActivityTimeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'descripcion' => ['required', 'string', 'min:3'],
            'minutos' => ['nullable', 'integer', 'min:1'],
            'fecha' => ['required', 'date'],
            'iniciado_at' => ['nullable', 'date'],
            'terminado_at' => ['nullable', 'date', 'after:iniciado_at'],
        ];
    }
}
