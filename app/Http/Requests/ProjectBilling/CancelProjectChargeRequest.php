<?php

namespace App\Http\Requests\ProjectBilling;

use Illuminate\Foundation\Http\FormRequest;

class CancelProjectChargeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'cancellation_reason' => ['required', 'string', 'min:5'],
        ];
    }
}
