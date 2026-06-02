<?php

namespace App\Http\Requests\ProjectBilling;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectPaymentDocumentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'archivo' => ['required', 'file', 'max:10240', 'mimes:jpg,jpeg,png,webp,pdf,doc,docx,xls,xlsx,txt,csv,zip'],
            'descripcion' => ['nullable', 'string'],
        ];
    }
}
