<?php

namespace App\Http\Requests\Tickets;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketPriorityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'prioridad_id' => ['required', 'integer', 'exists:cat_ticket_prioridades,id'],
            'motivo' => ['nullable', 'string'],
        ];
    }
}
