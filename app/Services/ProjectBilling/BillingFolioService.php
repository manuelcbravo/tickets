<?php

namespace App\Services\ProjectBilling;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BillingFolioService
{
    /**
     * @param  class-string<Model>  $modelClass
     */
    public function next(string $modelClass, string $prefix, string $table): string
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("LOCK TABLE {$table} IN EXCLUSIVE MODE");
        }

        $lastFolio = $modelClass::query()
            ->where('folio', 'like', "{$prefix}-%")
            ->orderByDesc('folio')
            ->value('folio');

        $nextNumber = $lastFolio
            ? ((int) str_replace("{$prefix}-", '', $lastFolio)) + 1
            : 1;

        return $prefix.'-'.str_pad((string) $nextNumber, 6, '0', STR_PAD_LEFT);
    }
}
