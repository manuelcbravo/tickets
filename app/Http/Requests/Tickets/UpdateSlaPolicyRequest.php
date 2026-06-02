<?php

namespace App\Http\Requests\Tickets;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSlaPolicyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'activo' => ['sometimes', 'boolean'],
            'es_default' => ['sometimes', 'boolean'],
            'prioridades' => ['required', 'array'],
            'prioridades.*.prioridad_id' => ['required', 'integer', 'exists:cat_ticket_prioridades,id'],
            'prioridades.*.tiempo_primera_respuesta_min' => ['required', 'integer', 'min:1'],
            'prioridades.*.tiempo_resolucion_min' => ['required', 'integer', 'min:1'],
            'prioridades.*.tiempo_alerta_min' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
