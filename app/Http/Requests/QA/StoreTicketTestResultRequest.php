<?php

namespace App\Http\Requests\QA;

use App\Models\TicketTestResult;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTicketTestResultRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'test_case_id' => ['nullable', 'uuid', 'exists:test_cases,id'],
            'development_task_id' => ['nullable', 'uuid', 'exists:ticket_development_tasks,id'],
            'titulo' => ['required', 'string', 'max:255'],
            'pasos' => ['nullable', 'string'],
            'resultado_esperado' => ['nullable', 'string'],
            'resultado_obtenido' => ['nullable', 'string'],
            'status' => ['required', 'string', Rule::in(TicketTestResult::STATUSES)],
            'notas' => ['nullable', 'string'],
        ];
    }
}
