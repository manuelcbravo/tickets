<?php

namespace App\Http\Requests\Integrations;

use App\Models\Integracion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreIntegrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'tipo' => ['required', 'string', Rule::in(Integracion::TIPOS)],
            'proveedor' => ['nullable', 'string', Rule::in(Integracion::PROVEEDORES)],
            'descripcion' => ['nullable', 'string'],
            'config' => ['nullable', 'array'],
            'activo' => ['boolean'],
        ];
    }
}
