<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatTicketUrgenciasTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        foreach (['Baja', 'Media', 'Alta', 'Inmediata'] as $index => $urgencia) {
            DB::table('cat_ticket_urgencias')->updateOrInsert(
                ['nombre' => $urgencia],
                [
                    'descripcion' => null,
                    'orden' => $index + 1,
                    'activo' => true,
                    'updated_at' => $now,
                    'created_at' => $now,
                ],
            );
        }
    }
}
