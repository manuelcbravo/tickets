<?php

namespace App\Http\Requests\Quotes;

use App\Models\Cotizacion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliente_id' => ['required', 'uuid', 'exists:clients,id'],
            'proyecto_id' => ['nullable', 'uuid', 'exists:projects,id'],
            'ticket_origen_id' => ['nullable', 'uuid', 'exists:tickets,id'],
            'contacto_id' => ['nullable', 'uuid', 'exists:client_contacts,id'],
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'alcance' => ['nullable', 'string'],
            'exclusiones' => ['nullable', 'string'],
            'entregables' => ['nullable', 'string'],
            'condiciones' => ['nullable', 'string'],
            'notas_internas' => ['nullable', 'string'],
            'moneda' => ['required', 'string', 'max:3'],
            'descuento' => ['nullable', 'numeric', 'min:0'],
            'impuesto' => ['nullable', 'numeric', 'min:0'],
            'horas_estimadas' => ['nullable', 'integer', 'min:0'],
            'dias_estimados' => ['nullable', 'integer', 'min:0'],
            'fecha_estimada_inicio' => ['nullable', 'date'],
            'fecha_estimada_entrega' => ['nullable', 'date', 'after_or_equal:fecha_estimada_inicio'],
            'estado' => ['nullable', 'string', Rule::in(Cotizacion::ESTADOS)],
        ];
    }
}
