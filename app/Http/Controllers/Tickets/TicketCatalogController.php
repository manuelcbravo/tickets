<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use App\Models\CatTicketEstado;
use App\Models\CatTicketImpacto;
use App\Models\CatTicketPrioridad;
use App\Models\CatTicketRiesgo;
use App\Models\CatTicketTipo;
use App\Models\CatTicketUrgencia;
use Inertia\Inertia;
use Inertia\Response;

class TicketCatalogController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('tickets/catalogs', [
            'catalogs' => [
                'Tipos' => CatTicketTipo::query()->orderBy('orden')->get(['id', 'nombre', 'descripcion', 'activo']),
                'Estados' => CatTicketEstado::query()->orderBy('orden')->get(['id', 'nombre', 'descripcion', 'activo']),
                'Prioridades' => CatTicketPrioridad::query()->orderBy('orden')->get(['id', 'nombre', 'descripcion', 'activo']),
                'Impactos' => CatTicketImpacto::query()->orderBy('orden')->get(['id', 'nombre', 'descripcion', 'activo']),
                'Urgencias' => CatTicketUrgencia::query()->orderBy('orden')->get(['id', 'nombre', 'descripcion', 'activo']),
                'Riesgos' => CatTicketRiesgo::query()->orderBy('orden')->get(['id', 'nombre', 'descripcion', 'activo']),
            ],
        ]);
    }
}
