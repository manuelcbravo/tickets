<?php

namespace App\Http\Requests\Tickets;

use App\Http\Requests\Tickets\Concerns\ValidatesTicketRelations;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    use ValidatesTicketRelations;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliente_id' => ['required', 'uuid', 'exists:clients,id'],
            'proyecto_id' => ['nullable', 'uuid', 'exists:projects,id'],
            'proyecto_modulo_id' => ['nullable', 'uuid', 'exists:project_modules,id'],
            'contacto_id' => ['nullable', 'uuid', 'exists:client_contacts,id'],
            'ambiente_id' => ['nullable', 'uuid', 'exists:environments,id'],
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'tipo_id' => ['required', 'integer', 'exists:cat_ticket_tipos,id'],
            'estado_id' => ['nullable', 'integer', 'exists:cat_ticket_estados,id'],
            'prioridad_id' => ['required', 'integer', 'exists:cat_ticket_prioridades,id'],
            'impacto_id' => ['nullable', 'integer', 'exists:cat_ticket_impactos,id'],
            'urgencia_id' => ['nullable', 'integer', 'exists:cat_ticket_urgencias,id'],
            'riesgo_id' => ['nullable', 'integer', 'exists:cat_ticket_riesgos,id'],
            'dificultad' => ['nullable', 'string', 'max:80'],
            'responsable_id' => ['nullable', 'integer', 'exists:users,id'],
            'fecha_objetivo' => ['nullable', 'date'],
            'tiempo_estimado_min' => ['nullable', 'integer', 'min:0'],
            'requires_code_change' => ['sometimes', 'boolean'],
            'requires_quote' => ['sometimes', 'boolean'],
            'is_internal' => ['sometimes', 'boolean'],
        ];
    }
}
