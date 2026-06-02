<?php

namespace App\Http\Requests\Clientes;

use App\Models\ClienteContacto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClienteContactoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:180'],
            'email' => ['nullable', 'email', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'puesto' => ['nullable', 'string', 'max:120'],
            'tipo_contacto' => ['required', 'string', Rule::in(ClienteContacto::TIPOS)],
            'es_principal' => ['required', 'boolean'],
            'recibe_notificaciones' => ['required', 'boolean'],
            'notas' => ['nullable', 'string'],
        ];
    }
}
