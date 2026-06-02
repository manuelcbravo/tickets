<?php

namespace App\Services\Tickets;

use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class TicketFolioService
{
    public function next(): string
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('LOCK TABLE tickets IN EXCLUSIVE MODE');
        }

        $lastFolio = Ticket::query()
            ->where('folio', 'like', 'TCK-%')
            ->orderByDesc('folio')
            ->value('folio');

        $nextNumber = $lastFolio
            ? ((int) str_replace('TCK-', '', $lastFolio)) + 1
            : 1;

        return 'TCK-'.str_pad((string) $nextNumber, 6, '0', STR_PAD_LEFT);
    }
}
