<?php

namespace App\Http\Requests\Clientes;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClienteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:180'],
            'razon_social' => ['nullable', 'string', 'max:180'],
            'rfc' => ['nullable', 'string', 'max:13'],
            'email' => ['nullable', 'email', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'sitio_web' => ['nullable', 'url', 'max:255'],
            'estatus' => ['required', 'string', Rule::in(Client::ESTATUS)],
            'clasificacion' => ['nullable', 'string', Rule::in(Client::CLASIFICACIONES)],
            'notas_internas' => ['nullable', 'string'],
        ];
    }
}
