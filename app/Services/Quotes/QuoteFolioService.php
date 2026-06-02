<?php

namespace App\Services\Quotes;

use App\Models\Cotizacion;
use Illuminate\Support\Facades\DB;

class QuoteFolioService
{
    public function next(): string
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('LOCK TABLE cotizaciones IN EXCLUSIVE MODE');
        }

        $lastFolio = Cotizacion::query()
            ->where('folio', 'like', 'COT-%')
            ->orderByDesc('folio')
            ->value('folio');

        $nextNumber = $lastFolio
            ? ((int) str_replace('COT-', '', $lastFolio)) + 1
            : 1;

        return 'COT-'.str_pad((string) $nextNumber, 6, '0', STR_PAD_LEFT);
    }
}
