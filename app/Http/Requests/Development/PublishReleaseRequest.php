<?php

namespace App\Http\Requests\Development;

use Illuminate\Foundation\Http\FormRequest;

class PublishReleaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'descripcion' => ['nullable', 'string'],
        ];
    }
}
