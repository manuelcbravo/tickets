<?php

namespace App\Http\Requests\Quotes;

use Illuminate\Foundation\Http\FormRequest;

class ApproveQuoteClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_aprobador' => ['nullable', 'string', 'max:255'],
            'email_aprobador' => ['nullable', 'email'],
            'comentario' => ['nullable', 'string'],
        ];
    }
}
