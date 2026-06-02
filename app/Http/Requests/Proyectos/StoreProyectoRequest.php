<?php

namespace App\Http\Requests\Proyectos;

use App\Models\Proyecto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProyectoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'client_id' => ['required', 'uuid', 'exists:clients,id'],
            'nombre' => ['required', 'string', 'max:180'],
            'descripcion' => ['nullable', 'string'],
            'url_produccion' => ['nullable', 'url', 'max:255'],
            'url_staging' => ['nullable', 'url', 'max:255'],
            'repositorio_url' => ['nullable', 'url', 'max:255'],
            'documentacion_url' => ['nullable', 'url', 'max:255'],
            'tecnologia' => ['nullable', 'string', 'max:255'],
            'responsable_tecnico_id' => ['nullable', 'integer', 'exists:users,id'],
            'estado' => ['required', 'string', Rule::in(Proyecto::ESTADOS)],
            'criticidad' => ['required', 'string', Rule::in(Proyecto::CRITICIDADES)],
            'notas_internas' => ['nullable', 'string'],
        ];
    }
}
