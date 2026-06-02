<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatTicketPrioridadesTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $prioridades = [
            ['nombre' => 'P0 - Critica', 'descripcion' => 'Sistema caido, riesgo de datos, dinero, seguridad u operacion detenida.'],
            ['nombre' => 'P1 - Alta', 'descripcion' => 'Funcion clave fallando sin alternativa practica.'],
            ['nombre' => 'P2 - Media', 'descripcion' => 'Afecta operacion pero existe alternativa temporal.'],
            ['nombre' => 'P3 - Baja', 'descripcion' => 'Ajuste menor, bug menor o mejora pequena.'],
            ['nombre' => 'P4 - Backlog', 'descripcion' => 'Idea, mejora futura o solicitud sin urgencia.'],
        ];

        foreach ($prioridades as $index => $prioridad) {
            DB::table('cat_ticket_prioridades')->updateOrInsert(
                ['nombre' => $prioridad['nombre']],
                [
                    'descripcion' => $prioridad['descripcion'],
                    'orden' => $index + 1,
                    'activo' => true,
                    'updated_at' => $now,
                    'created_at' => $now,
                ],
            );
        }
    }
}
