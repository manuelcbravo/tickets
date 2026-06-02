<?php

namespace App\Http\Requests\Development;

use App\Models\Repositorio;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRepositoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'proyecto_id' => ['required', 'uuid', 'exists:projects,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'proveedor' => ['nullable', 'string', Rule::in(Repositorio::PROVEEDORES)],
            'url' => ['required', 'url', 'max:255'],
            'rama_principal' => ['nullable', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'activo' => ['boolean'],
        ];
    }
}
