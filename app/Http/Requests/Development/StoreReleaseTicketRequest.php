<?php

namespace App\Http\Requests\Development;

use Illuminate\Foundation\Http\FormRequest;

class StoreReleaseTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ticket_id' => ['required', 'uuid', 'exists:tickets,id'],
            'development_task_id' => ['nullable', 'uuid', 'exists:ticket_development_tasks,id'],
            'notas' => ['nullable', 'string'],
        ];
    }
}
