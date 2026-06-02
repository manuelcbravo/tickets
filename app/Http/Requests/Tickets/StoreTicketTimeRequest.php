<?php

namespace App\Http\Requests\Tickets;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketTimeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'descripcion' => ['required', 'string', 'min:3'],
            'minutos' => ['required', 'integer', 'min:1'],
            'fecha' => ['required', 'date'],
            'es_facturable' => ['sometimes', 'boolean'],
            'iniciado_at' => ['nullable', 'date'],
            'terminado_at' => ['nullable', 'date', 'after:iniciado_at'],
        ];
    }
}
