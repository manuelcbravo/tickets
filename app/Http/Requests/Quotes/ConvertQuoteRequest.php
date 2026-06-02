<?php

namespace App\Http\Requests\Quotes;

use Illuminate\Foundation\Http\FormRequest;

class ConvertQuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'create_single_ticket' => ['sometimes', 'boolean'],
            'tipo_id' => ['nullable', 'integer', 'exists:cat_ticket_tipos,id'],
            'prioridad_id' => ['nullable', 'integer', 'exists:cat_ticket_prioridades,id'],
        ];
    }
}
