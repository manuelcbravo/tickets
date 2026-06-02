<?php

namespace App\Http\Requests\ProjectPlanning;

use Illuminate\Foundation\Http\FormRequest;

class CreateTicketFromActivityRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tipo_id' => ['required', 'integer', 'exists:cat_ticket_tipos,id'],
            'prioridad_id' => ['required', 'integer', 'exists:cat_ticket_prioridades,id'],
            'crear_como_borrador' => ['sometimes', 'boolean'],
        ];
    }
}
