<?php

namespace App\Http\Requests\ProjectBilling;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmProjectPaymentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'notes' => ['nullable', 'string'],
        ];
    }
}
