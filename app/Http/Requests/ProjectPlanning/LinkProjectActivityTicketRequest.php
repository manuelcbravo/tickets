<?php

namespace App\Http\Requests\ProjectPlanning;

use App\Models\ProyectoActividadTicket;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LinkProjectActivityTicketRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ticket_id' => ['required', 'uuid', 'exists:tickets,id'],
            'tipo_relacion' => ['required', 'string', Rule::in(ProyectoActividadTicket::TIPOS)],
        ];
    }
}
