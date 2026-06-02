<?php

namespace App\Http\Requests\Proyectos;

use Illuminate\Foundation\Http\FormRequest;

class StoreProyectoModuloRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:180'],
            'descripcion' => ['nullable', 'string'],
            'orden' => ['required', 'integer', 'min:0'],
            'activo' => ['required', 'boolean'],
        ];
    }
}
