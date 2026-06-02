<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatTicketImpactosTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        foreach (['Bajo', 'Medio', 'Alto', 'Critico'] as $index => $impacto) {
            DB::table('cat_ticket_impactos')->updateOrInsert(
                ['nombre' => $impacto],
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
