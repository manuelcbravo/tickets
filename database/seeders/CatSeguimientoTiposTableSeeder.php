<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatSeguimientoTiposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $tipos = [
            ['nombre' => 'Llamada', 'descripcion' => 'Seguimiento por llamada telefonica.'],
            ['nombre' => 'Email', 'descripcion' => 'Seguimiento por correo electronico.'],
            ['nombre' => 'Visita', 'descripcion' => 'Seguimiento presencial.'],
            ['nombre' => 'Nota interna', 'descripcion' => 'Nota de uso interno para el equipo.'],
            ['nombre' => 'Recordatorio', 'descripcion' => 'Recordatorio de accion pendiente.'],
            ['nombre' => 'Seguimiento comercial', 'descripcion' => 'Accion enfocada en ventas/comercial.'],
            ['nombre' => 'Seguimiento clinico', 'descripcion' => 'Accion enfocada en contexto clinico.'],
        ];

        foreach ($tipos as $tipo) {
            DB::table('cat_seguimiento_tipos')->updateOrInsert(
                ['nombre' => $tipo['nombre']],
                [
                    'descripcion' => $tipo['descripcion'],
                    'updated_at' => $now,
                    'created_at' => $now,
                ],
            );
        }
    }
}
