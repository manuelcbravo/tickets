<?php

namespace App\Http\Requests\Quotes;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuoteFromTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['nullable', 'string', 'max:255'],
            'alcance' => ['nullable', 'string'],
            'incluir_descripcion_ticket' => ['sometimes', 'boolean'],
            'incluir_comentarios' => ['sometimes', 'boolean'],
            'incluir_tiempos' => ['sometimes', 'boolean'],
        ];
    }
}
