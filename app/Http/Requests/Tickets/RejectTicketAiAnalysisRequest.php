<?php

namespace App\Http\Requests\Tickets;

use Illuminate\Foundation\Http\FormRequest;

class RejectTicketAiAnalysisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return ($this->user()?->can('tickets.ai.apply') || $this->user()?->can('tickets.ai')) ?? false;
    }

    public function rules(): array
    {
        return [
            'reason' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
