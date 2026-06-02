<?php

namespace App\Http\Requests\Tickets;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompleteTicketTriageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipo_id' => ['required', 'integer', 'exists:cat_ticket_tipos,id'],
            'impacto_id' => ['required', 'integer', 'exists:cat_ticket_impactos,id'],
            'urgencia_id' => ['required', 'integer', 'exists:cat_ticket_urgencias,id'],
            'riesgo_id' => ['required', 'integer', 'exists:cat_ticket_riesgos,id'],
            'dificultad' => ['nullable', 'string', 'max:80'],
            'prioridad_id' => ['required', 'integer', 'exists:cat_ticket_prioridades,id'],
            'responsable_id' => ['nullable', 'integer', 'exists:users,id'],
            'triage_notes' => ['nullable', 'string'],
            'requires_code_change' => ['sometimes', 'boolean'],
            'requires_quote' => ['sometimes', 'boolean'],
            'missing_information' => ['nullable', 'array'],
            'missing_information.*.key' => ['required_with:missing_information', 'string', 'max:80'],
            'missing_information.*.label' => ['required_with:missing_information', 'string', 'max:160'],
            'missing_information.*.required' => ['sometimes', 'boolean'],
            'missing_information.*.completed' => ['sometimes', 'boolean'],
            'next_status' => ['required', Rule::in(['falta_informacion', 'priorizado', 'en_analisis', 'en_desarrollo'])],
        ];
    }
}
