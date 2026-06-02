<?php

namespace App\Http\Requests\ProjectPlanning;

use App\Models\Proyecto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectPlanningRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'objetivo' => ['nullable', 'string'],
            'alcance' => ['nullable', 'string'],
            'descripcion_funcional' => ['nullable', 'string'],
            'descripcion_tecnica' => ['nullable', 'string'],
            'restricciones' => ['nullable', 'string'],
            'notas_planeacion' => ['nullable', 'string'],
            'fecha_inicio' => ['nullable', 'date'],
            'fecha_objetivo' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'estado_planeacion' => ['nullable', 'string', Rule::in(Proyecto::ESTADOS_PLANEACION)],
            'responsable_planeacion_id' => ['nullable', 'integer', 'exists:users,id'],
            'prioridad_planeacion' => ['nullable', 'string', Rule::in(Proyecto::PRIORIDADES_PLANEACION)],
            'avance_porcentaje' => ['nullable', 'integer', 'min:0', 'max:100'],
        ];
    }
}
