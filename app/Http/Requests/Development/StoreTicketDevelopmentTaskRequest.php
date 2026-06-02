<?php

namespace App\Http\Requests\Development;

use App\Models\TicketDevelopmentTask;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTicketDevelopmentTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'proyecto_id' => ['nullable', 'uuid', 'exists:projects,id'],
            'repositorio_id' => ['nullable', 'uuid', 'exists:repositorios,id'],
            'asignado_a_id' => ['nullable', 'integer', 'exists:users,id'],
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'tipo' => ['required', 'string', Rule::in(TicketDevelopmentTask::TIPOS)],
            'estado' => ['nullable', 'string', Rule::in(TicketDevelopmentTask::ESTADOS)],
            'prioridad' => ['nullable', 'string', 'max:255'],
            'branch_name' => ['nullable', 'string', 'max:255'],
            'pull_request_url' => ['nullable', 'url', 'max:255'],
            'commit_hash' => ['nullable', 'string', 'max:255'],
            'estimacion_min' => ['nullable', 'integer', 'min:0'],
            'tiempo_real_min' => ['nullable', 'integer', 'min:0'],
            'reviewed_by_id' => ['nullable', 'integer', 'exists:users,id'],
            'reviewed_at' => ['nullable', 'date'],
        ];
    }
}
