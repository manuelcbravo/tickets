<?php

namespace App\Http\Requests\Proyectos;

use App\Models\Ambiente;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAmbienteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:80', Rule::in(Ambiente::NOMBRES)],
            'url' => ['nullable', 'url', 'max:255'],
            'servidor' => ['nullable', 'string', 'max:255'],
            'rama' => ['nullable', 'string', 'max:255'],
            'notas' => ['nullable', 'string'],
            'activo' => ['required', 'boolean'],
        ];
    }
}
