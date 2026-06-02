<?php

namespace App\Http\Requests\ProjectPlanning;

use App\Models\ProyectoActividad;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectActivityRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'tipo' => ['required', 'string', Rule::in(ProyectoActividad::TIPOS)],
            'estado' => ['nullable', 'string', Rule::in(ProyectoActividad::ESTADOS)],
            'prioridad' => ['nullable', 'string', Rule::in(ProyectoActividad::PRIORIDADES)],
            'responsable_id' => ['nullable', 'integer', 'exists:users,id'],
            'reportado_por_id' => ['nullable', 'integer', 'exists:users,id'],
            'ticket_id' => ['nullable', 'uuid', 'exists:tickets,id'],
            'parent_id' => ['nullable', 'uuid', 'exists:proyecto_actividades,id'],
            'fecha_inicio' => ['nullable', 'date'],
            'fecha_limite' => ['nullable', 'date'],
            'minutos_estimados' => ['nullable', 'integer', 'min:0'],
            'tags' => ['nullable', 'array'],
        ];
    }
}
