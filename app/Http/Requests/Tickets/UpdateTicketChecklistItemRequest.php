<?php

namespace App\Http\Requests\Tickets;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketChecklistItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['sometimes', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'tipo' => ['nullable', 'string', 'max:80'],
            'requerido' => ['sometimes', 'boolean'],
            'completado' => ['sometimes', 'boolean'],
            'orden' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
