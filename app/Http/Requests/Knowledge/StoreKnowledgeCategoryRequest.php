<?php

namespace App\Http\Requests\Knowledge;

use Illuminate\Foundation\Http\FormRequest;

class StoreKnowledgeCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'parent_id' => in_array($this->input('parent_id'), ['', 'none', 'todos'], true) ? null : $this->input('parent_id'),
            'proyecto_id' => in_array($this->input('proyecto_id'), ['', 'none', 'todos'], true) ? null : $this->input('proyecto_id'),
        ]);
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'uuid', 'exists:knowledge_categories,id'],
            'proyecto_id' => ['nullable', 'uuid', 'exists:projects,id'],
            'orden' => ['nullable', 'integer', 'min:0'],
            'activo' => ['sometimes', 'boolean'],
        ];
    }
}
