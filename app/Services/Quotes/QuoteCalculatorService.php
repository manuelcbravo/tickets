<?php

namespace App\Services\Quotes;

use App\Models\Cotizacion;
use App\Models\CotizacionItem;

class QuoteCalculatorService
{
    public function itemSubtotal(array $data): float
    {
        return round((float) ($data['cantidad'] ?? 0) * (float) ($data['precio_unitario'] ?? 0), 2);
    }

    public function recalculate(Cotizacion $cotizacion): Cotizacion
    {
        $items = $cotizacion->items()->get();
        $subtotal = (float) $items->sum(fn (CotizacionItem $item) => (float) $item->subtotal);
        $horas = (int) $items->sum(fn (CotizacionItem $item) => (int) ($item->horas_estimadas ?? 0));
        $descuento = (float) $cotizacion->descuento;
        $impuesto = (float) $cotizacion->impuesto;

        $cotizacion->update([
            'subtotal' => max(0, round($subtotal, 2)),
            'horas_estimadas' => $horas > 0 ? $horas : $cotizacion->horas_estimadas,
            'total' => max(0, round($subtotal - $descuento + $impuesto, 2)),
        ]);

        return $cotizacion->refresh();
    }
}
