<?php

namespace App\Http\Requests\QA;

use Illuminate\Foundation\Http\FormRequest;

class RejectTicketValidationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'comentario' => ['required', 'string', 'min:5'],
        ];
    }
}
