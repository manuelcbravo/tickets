<?php

namespace App\Http\Requests\Development;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewTicketDevelopmentTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estado' => ['required', 'string', Rule::in(['aprobado', 'rechazado'])],
            'reviewed_by_id' => ['nullable', 'integer', 'exists:users,id'],
            'reviewed_at' => ['nullable', 'date'],
        ];
    }
}
