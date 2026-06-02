<?php

namespace App\Http\Requests\Tickets;

use Illuminate\Foundation\Http\FormRequest;

class CloseTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'resolution' => ['required', 'string', 'min:10'],
            'force_close' => ['boolean'],
            'force_reason' => ['nullable', 'required_if:force_close,1,true', 'string', 'min:10'],
        ];
    }
}
