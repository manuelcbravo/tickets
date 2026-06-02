<?php

namespace App\Http\Requests\Tickets;

use Illuminate\Foundation\Http\FormRequest;

class ApplyTicketAiAnalysisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return ($this->user()?->can('tickets.ai.apply') || $this->user()?->can('tickets.ai')) ?? false;
    }

    public function rules(): array
    {
        return [
            'apply_type' => ['nullable', 'boolean'],
            'apply_priority' => ['nullable', 'boolean'],
            'apply_impact' => ['nullable', 'boolean'],
            'apply_urgency' => ['nullable', 'boolean'],
            'apply_risk' => ['nullable', 'boolean'],
            'apply_difficulty' => ['nullable', 'boolean'],
            'apply_flags' => ['nullable', 'boolean'],
            'create_checklist' => ['nullable', 'boolean'],
            'create_internal_comment' => ['nullable', 'boolean'],
            'create_customer_reply_draft' => ['nullable', 'boolean'],
        ];
    }
}
