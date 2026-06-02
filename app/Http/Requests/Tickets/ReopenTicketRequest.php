<?php

namespace App\Http\Requests\Tickets;

use Illuminate\Foundation\Http\FormRequest;

class ReopenTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'motivo' => ['nullable', 'string', 'min:10'],
            'reason' => ['required_without:motivo', 'string', 'min:10'],
            'root_cause' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
