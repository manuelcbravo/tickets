<?php

namespace App\Http\Requests\ProjectPlanning;

use App\Models\ProyectoActividad;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MoveProjectActivityKanbanRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'kanban_column' => ['required', 'string', Rule::in(ProyectoActividad::KANBAN_COLUMNS)],
            'orden' => ['nullable', 'integer'],
        ];
    }
}
