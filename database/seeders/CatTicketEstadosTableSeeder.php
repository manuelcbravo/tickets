<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatTicketEstadosTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $estados = [
            'Nuevo',
            'En triage',
            'Falta informacion',
            'Priorizado',
            'En analisis',
            'En desarrollo',
            'En revision',
            'En pruebas',
            'Esperando aprobacion',
            'Listo para deploy',
            'Cerrado',
            'Reabierto',
            'Cancelado',
        ];

        foreach ($estados as $index => $estado) {
            DB::table('cat_ticket_estados')->updateOrInsert(
                ['nombre' => $estado],
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
