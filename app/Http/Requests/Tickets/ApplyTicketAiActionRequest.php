<?php

namespace App\Http\Requests\Tickets;

use Illuminate\Foundation\Http\FormRequest;

class ApplyTicketAiActionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return ($this->user()?->can('tickets.ai.apply') || $this->user()?->can('tickets.ai')) ?? false;
    }

    public function rules(): array
    {
        return [];
    }
}
