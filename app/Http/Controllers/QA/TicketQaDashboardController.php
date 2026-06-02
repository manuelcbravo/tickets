<?php

namespace App\Http\Controllers\QA;

use App\Http\Controllers\Controller;
use App\Models\CatTicketPrioridad;
use App\Models\CatTicketTipo;
use App\Models\Client;
use App\Models\Proyecto;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TicketQaDashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $tickets = Ticket::query()
            ->with(['cliente:id,nombre,razon_social', 'proyecto:id,nombre', 'estado:id,nombre', 'prioridad:id,nombre', 'tipo:id,nombre', 'responsable:id,name'])
            ->withCount([
                'testResults as approved_tests_count' => fn ($query) => $query->where('status', 'aprobado'),
                'testResults as failed_tests_count' => fn ($query) => $query->where('status', 'fallido'),
                'testEvidences as evidences_count',
            ])
            ->when($request->input('qa_status'), fn ($query, $value) => $query->where('qa_status', $value))
            ->when($request->input('cliente_id'), fn ($query, $value) => $query->where('cliente_id', $value))
            ->when($request->input('proyecto_id'), fn ($query, $value) => $query->where('proyecto_id', $value))
            ->when($request->input('responsable_id'), fn ($query, $value) => $query->where('responsable_id', $value))
            ->when($request->input('prioridad_id'), fn ($query, $value) => $query->where('prioridad_id', $value))
            ->when($request->input('tipo_id'), fn ($query, $value) => $query->where('tipo_id', $value))
            ->when($request->boolean('with_code'), fn ($query) => $query->where(function ($nested) {
                $nested->where('has_code_changes', true)->orWhere('requires_code_change', true);
            }))
            ->when($request->boolean('reopened'), fn ($query) => $query->where('reopen_count', '>', 0))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('tickets/qa/index', [
            'tickets' => $tickets,
            'filters' => $request->only(['qa_status', 'cliente_id', 'proyecto_id', 'responsable_id', 'prioridad_id', 'tipo_id', 'with_code', 'reopened']),
            'clientes' => Client::query()->orderBy('nombre')->get(['id', 'nombre', 'razon_social', 'estatus']),
            'proyectos' => Proyecto::query()->orderBy('nombre')->get(['id', 'client_id', 'nombre']),
            'prioridades' => CatTicketPrioridad::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
            'tipos' => CatTicketTipo::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
            'users' => User::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }
}
