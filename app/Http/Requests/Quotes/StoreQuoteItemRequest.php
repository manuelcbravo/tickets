<?php

namespace App\Http\Requests\Quotes;

use App\Models\CotizacionItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuoteItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'tipo' => ['required', 'string', Rule::in(CotizacionItem::TIPOS)],
            'cantidad' => ['required', 'numeric', 'min:0.01'],
            'unidad' => ['required', 'string', 'max:50'],
            'precio_unitario' => ['required', 'numeric', 'min:0'],
            'horas_estimadas' => ['nullable', 'integer', 'min:0'],
            'orden' => ['nullable', 'integer'],
            'es_opcional' => ['sometimes', 'boolean'],
        ];
    }
}
