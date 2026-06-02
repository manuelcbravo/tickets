<?php

namespace App\Http\Requests\QA;

use App\Models\TestCase;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTestCaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'proyecto_id' => ['nullable', 'uuid', 'exists:projects,id'],
            'proyecto_modulo_id' => ['nullable', 'uuid', 'exists:project_modules,id'],
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'pasos' => ['nullable', 'string'],
            'resultado_esperado' => ['nullable', 'string'],
            'tipo' => ['required', 'string', Rule::in(TestCase::TIPOS)],
            'prioridad' => ['nullable', 'string', 'max:255'],
            'activo' => ['boolean'],
        ];
    }
}
