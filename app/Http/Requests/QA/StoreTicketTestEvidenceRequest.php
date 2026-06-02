<?php

namespace App\Http\Requests\QA;

use App\Models\TicketTestEvidence;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTicketTestEvidenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'test_result_id' => ['nullable', 'uuid', 'exists:ticket_test_results,id'],
            'adjunto_id' => ['nullable', 'uuid', 'exists:ticket_attachments,id'],
            'titulo' => ['nullable', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'tipo' => ['nullable', 'string', Rule::in(TicketTestEvidence::TIPOS)],
            'url' => ['nullable', 'url', 'max:255'],
        ];
    }
}
