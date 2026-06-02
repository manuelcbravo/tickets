<?php

namespace App\Http\Requests\QA;

use App\Models\TicketValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTicketValidationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipo' => ['required', 'string', Rule::in(TicketValidation::TIPOS)],
            'status' => ['required', 'string', Rule::in(TicketValidation::STATUSES)],
            'comentario' => ['nullable', 'required_if:status,rechazado', 'string'],
        ];
    }
}
