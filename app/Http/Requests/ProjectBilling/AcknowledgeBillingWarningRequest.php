<?php

namespace App\Http\Requests\ProjectBilling;

use Illuminate\Foundation\Http\FormRequest;

class AcknowledgeBillingWarningRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
