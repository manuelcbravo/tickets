<?php

namespace App\Http\Requests\Tickets;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RunTicketAiAnalysisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return ($this->user()?->can('tickets.ai.analyze') || $this->user()?->can('tickets.ai')) ?? false;
    }

    public function rules(): array
    {
        return [
            'analysis_type' => ['nullable', 'string', Rule::in(['full', 'summary', 'classification', 'missing_information', 'reply', 'checklist', 'knowledge_lookup'])],
            'include_knowledge' => ['nullable', 'boolean'],
            'include_comments' => ['nullable', 'boolean'],
        ];
    }
}
