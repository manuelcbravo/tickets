<?php

namespace App\Http\Requests\Notifications;

use Illuminate\Foundation\Http\FormRequest;

class SendTicketEmailNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contacto_id' => ['nullable', 'exists:client_contacts,id'],
            'recipient' => ['nullable', 'email'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:3'],
            'save_as_public_comment' => ['boolean'],
        ];
    }
}
