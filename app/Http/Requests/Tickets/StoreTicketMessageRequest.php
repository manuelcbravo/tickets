<?php

namespace App\Http\Requests\Tickets;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mensaje' => ['required', 'string'],
            'es_interno' => ['required', 'boolean'],
            'es_respuesta_cliente' => ['required', 'boolean'],
        ];
    }
}
