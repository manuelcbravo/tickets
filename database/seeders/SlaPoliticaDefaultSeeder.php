<?php

namespace Database\Seeders;

use App\Models\CatTicketPrioridad;
use App\Models\SlaPolitica;
use Illuminate\Database\Seeder;

class SlaPoliticaDefaultSeeder extends Seeder
{
    public function run(): void
    {
        $policy = SlaPolitica::query()->updateOrCreate(
            ['nombre' => 'SLA estandar'],
            [
                'descripcion' => 'Politica base para primera respuesta y resolucion de tickets.',
                'activo' => true,
                'es_default' => true,
                'dias_laborales' => ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'],
            ],
        );

        SlaPolitica::query()
            ->whereKeyNot($policy->id)
            ->update(['es_default' => false]);

        $minutes = [
            'P0' => ['first' => 15, 'resolution' => 240, 'alert' => 48],
            'P1' => ['first' => 60, 'resolution' => 480, 'alert' => 96],
            'P2' => ['first' => 240, 'resolution' => 1440, 'alert' => 288],
            'P3' => ['first' => 480, 'resolution' => 2400, 'alert' => 480],
            'P4' => ['first' => 960, 'resolution' => 7200, 'alert' => 1440],
        ];

        foreach ($minutes as $prefix => $config) {
            $priority = CatTicketPrioridad::query()
                ->where('nombre', 'like', $prefix.'%')
                ->first();

            if (! $priority) {
                continue;
            }

            $policy->prioridades()->updateOrCreate(
                ['prioridad_id' => $priority->id],
                [
                    'tiempo_primera_respuesta_min' => $config['first'],
                    'tiempo_resolucion_min' => $config['resolution'],
                    'tiempo_alerta_min' => $config['alert'],
                ],
            );
        }
    }
}
