<?php

namespace App\Http\Requests\Tickets;

use Illuminate\Foundation\Http\FormRequest;

class RejectTicketAiActionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return ($this->user()?->can('tickets.ai.apply') || $this->user()?->can('tickets.ai')) ?? false;
    }

    public function rules(): array
    {
        return [
            'reason' => ['required', 'string', 'min:5', 'max:1000'],
        ];
    }
}
