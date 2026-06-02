<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatTicketRiesgosTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        foreach (['Bajo', 'Medio', 'Alto'] as $index => $riesgo) {
            DB::table('cat_ticket_riesgos')->updateOrInsert(
                ['nombre' => $riesgo],
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
