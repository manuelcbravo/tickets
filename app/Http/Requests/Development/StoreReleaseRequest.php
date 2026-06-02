<?php

namespace App\Http\Requests\Development;

use App\Models\Release;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReleaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'proyecto_id' => ['required', 'uuid', 'exists:projects,id'],
            'ambiente_id' => ['nullable', 'uuid', 'exists:environments,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'version' => ['nullable', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'estado' => ['nullable', 'string', Rule::in(Release::ESTADOS)],
            'release_notes' => ['nullable', 'string'],
            'scheduled_at' => ['nullable', 'date'],
        ];
    }
}
