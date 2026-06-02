<?php

namespace App\Http\Requests\Integrations;

use Illuminate\Foundation\Http\FormRequest;

class ConvertExternalMessageToCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'es_interno' => ['required', 'boolean'],
            'mensaje' => ['nullable', 'string'],
        ];
    }
}
