<?php

namespace App\Http\Requests\Knowledge;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LinkTicketKnowledgeArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'knowledge_article_id' => ['required', 'uuid', 'exists:knowledge_articles,id'],
            'tipo_relacion' => ['required', 'string', Rule::in(['solucion', 'relacionado', 'referencia', 'creado_desde_ticket', 'respuesta_sugerida'])],
            'notas' => ['nullable', 'string'],
        ];
    }
}
