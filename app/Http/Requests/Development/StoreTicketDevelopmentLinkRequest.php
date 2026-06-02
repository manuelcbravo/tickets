<?php

namespace App\Http\Requests\Development;

use App\Models\TicketDevelopmentLink;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTicketDevelopmentLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'development_task_id' => ['nullable', 'uuid', 'exists:ticket_development_tasks,id'],
            'tipo' => ['required', 'string', Rule::in(TicketDevelopmentLink::TIPOS)],
            'titulo' => ['nullable', 'string', 'max:255'],
            'url' => ['nullable', 'url', 'max:255'],
            'referencia' => ['nullable', 'string', 'max:255'],
            'metadata' => ['nullable', 'array'],
        ];
    }
}
