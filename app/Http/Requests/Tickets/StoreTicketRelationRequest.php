<?php

namespace App\Http\Requests\Tickets;

use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTicketRelationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var Ticket|null $ticket */
        $ticket = $this->route('ticket');

        return [
            'related_ticket_id' => [
                'required',
                'uuid',
                'exists:tickets,id',
                Rule::notIn([$ticket?->id]),
            ],
            'tipo' => ['required', Rule::in(['duplicado_de', 'relacionado_con', 'bloqueado_por', 'bloquea_a', 'causa_raiz', 'seguimiento_de'])],
            'descripcion' => ['nullable', 'string'],
        ];
    }
}
