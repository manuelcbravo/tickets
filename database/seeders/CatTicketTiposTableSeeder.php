<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatTicketTiposTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $tipos = [
            ['nombre' => 'Soporte', 'descripcion' => 'Solicitud de soporte operativo o funcional.'],
            ['nombre' => 'Bug', 'descripcion' => 'Error reproducible en una funcionalidad existente.'],
            ['nombre' => 'Mantenimiento menor', 'descripcion' => 'Ajuste acotado sobre una funcionalidad existente.'],
            ['nombre' => 'Mejora funcional', 'descripcion' => 'Mejora sobre comportamiento ya implementado.'],
            ['nombre' => 'Nuevo desarrollo', 'descripcion' => 'Solicitud de nueva funcionalidad.'],
            ['nombre' => 'Incidente critico', 'descripcion' => 'Incidente con afectacion critica al servicio.'],
            ['nombre' => 'Solicitud comercial', 'descripcion' => 'Solicitud relacionada con seguimiento comercial.'],
        ];

        foreach ($tipos as $index => $tipo) {
            DB::table('cat_ticket_tipos')->updateOrInsert(
                ['nombre' => $tipo['nombre']],
                [
                    'descripcion' => $tipo['descripcion'],
                    'orden' => $index + 1,
                    'activo' => true,
                    'updated_at' => $now,
                    'created_at' => $now,
                ],
            );
        }
    }
}
