<?php

namespace App\Http\Requests\Development;

use App\Models\TicketDevelopmentTask;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeTicketDevelopmentTaskStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estado' => ['required', 'string', Rule::in(TicketDevelopmentTask::ESTADOS)],
            'pull_request_url' => ['nullable', 'url', 'max:255'],
            'commit_hash' => ['nullable', 'string', 'max:255'],
        ];
    }
}
