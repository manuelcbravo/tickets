<?php

namespace App\Http\Controllers\Proyectos;

use App\Http\Controllers\Controller;
use App\Models\Ambiente;
use App\Models\Client;
use App\Models\Proyecto;
use App\Models\ProyectoActividad;
use App\Models\ProyectoCargo;
use App\Models\ProyectoPago;
use App\Models\ProyectoPlanCobro;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProyectoSectionController extends Controller
{
    public function documents(Proyecto $proyecto): Response
    {
        $proyecto->load(['cliente:id,nombre,razon_social', 'files']);

        return Inertia::render('proyectos/documents/index', [
            'proyecto' => $proyecto,
            'documents' => $proyecto->files,
        ]);
    }

    public function activities(Request $request, Proyecto $proyecto): Response
    {
        return $this->activityModule($request, $proyecto, 'list');
    }

    public function activityShow(Proyecto $proyecto, ProyectoActividad $activity): Response
    {
        abort_unless($activity->proyecto_id === $proyecto->id, 404);

        $activity->load([
            'proyecto:id,nombre,client_id',
            'proyecto.cliente:id,nombre,razon_social',
            'responsable:id,name',
            'reportadoPor:id,name',
            'createdBy:id,name',
            'updatedBy:id,name',
            'ticket:id,folio,titulo',
            'parent:id,titulo,estado',
            'children:id,parent_id,titulo,estado,prioridad,kanban_column',
            'tiempos.usuario:id,name',
            'ticketLinks.ticket:id,folio,titulo',
            'files',
        ]);

        return Inertia::render('activities/show', [
            'activity' => $activity,
            'estadoOptions' => ProyectoActividad::ESTADOS,
        ]);
    }

    public function billing(Proyecto $proyecto): Response
    {
        $proyecto->load([
            'cliente:id,nombre,razon_social',
            'planCobro',
            'cargos' => fn ($query) => $query->with('planCobro:id,tipo_cobro')->limit(25),
            'pagos.documentos',
        ]);

        return Inertia::render('proyectos/billing/index', [
            'proyecto' => $proyecto,
            'billing' => $this->billingPayload($proyecto),
            'billingOptions' => [
                'tipoCobro' => ProyectoPlanCobro::TIPOS,
                'planEstados' => ProyectoPlanCobro::ESTADOS,
                'cargoEstados' => ProyectoCargo::ESTADOS,
                'pagoMetodos' => ProyectoPago::METODOS,
            ],
        ]);
    }

    public function charges(Request $request, Proyecto $proyecto): Response
    {
        $filters = $request->only(['estado']);

        return Inertia::render('project-billing/charges/index', [
            'charges' => $proyecto->cargos()
                ->with(['cliente:id,nombre,razon_social', 'proyecto:id,nombre'])
                ->when($filters['estado'] ?? null, fn ($query, $value) => $query->where('estado', $value))
                ->orderByDesc('fecha_vencimiento')
                ->paginate(15)
                ->withQueryString(),
            'filters' => [
                ...$filters,
                'proyecto_id' => $proyecto->id,
                'cliente_id' => $proyecto->client_id,
            ],
            'clientes' => Client::query()->whereKey($proyecto->client_id)->get(['id', 'nombre', 'razon_social']),
            'proyectos' => Proyecto::query()->whereKey($proyecto->id)->get(['id', 'nombre', 'client_id']),
            'estados' => ProyectoCargo::ESTADOS,
        ]);
    }

    public function payments(Request $request, Proyecto $proyecto): Response
    {
        $filters = $request->only(['estado', 'metodo_pago']);

        return Inertia::render('project-billing/payments/index', [
            'payments' => $proyecto->pagos()
                ->with(['cliente:id,nombre,razon_social', 'proyecto:id,nombre'])
                ->withCount('documentos')
                ->when($filters['estado'] ?? null, fn ($query, $value) => $query->where('estado', $value))
                ->when($filters['metodo_pago'] ?? null, fn ($query, $value) => $query->where('metodo_pago', $value))
                ->latest('fecha_pago')
                ->paginate(15)
                ->withQueryString(),
            'filters' => [
                ...$filters,
                'proyecto_id' => $proyecto->id,
                'cliente_id' => $proyecto->client_id,
            ],
            'clientes' => Client::query()->whereKey($proyecto->client_id)->get(['id', 'nombre', 'razon_social']),
            'proyectos' => Proyecto::query()->whereKey($proyecto->id)->get(['id', 'nombre', 'client_id']),
            'metodos' => ProyectoPago::METODOS,
            'estados' => ProyectoPago::ESTADOS,
        ]);
    }

    public function tickets(Proyecto $proyecto): Response
    {
        $proyecto->load('cliente:id,nombre,razon_social');

        return Inertia::render('proyectos/tickets/index', [
            'proyecto' => $proyecto,
            'tickets' => Ticket::query()
                ->with(['cliente:id,nombre,razon_social', 'estado:id,nombre', 'prioridad:id,nombre', 'responsable:id,name'])
                ->where('proyecto_id', $proyecto->id)
                ->latest()
                ->get(),
        ]);
    }

    public function ambientes(Proyecto $proyecto): Response
    {
        $proyecto->load(['cliente:id,nombre,razon_social', 'ambientes']);

        return Inertia::render('proyectos/ambientes/index', [
            'proyecto' => $proyecto,
            'ambientes' => $proyecto->ambientes,
            'ambienteNombreOptions' => Ambiente::NOMBRES,
        ]);
    }

    public function modulos(Proyecto $proyecto): Response
    {
        $proyecto->load(['cliente:id,nombre,razon_social', 'modulos']);

        return Inertia::render('proyectos/modulos/index', [
            'proyecto' => $proyecto,
            'modulos' => $proyecto->modulos,
        ]);
    }

    private function activityModule(Request $request, Proyecto $proyecto, string $initialView): Response
    {
        $initialView = $this->requestedActivityView($request, $initialView);

        $activities = ProyectoActividad::query()
            ->with([
                'proyecto:id,nombre,client_id',
                'proyecto.cliente:id,nombre,razon_social',
                'responsable:id,name',
                'reportadoPor:id,name',
                'createdBy:id,name',
                'updatedBy:id,name',
                'ticket:id,folio,titulo',
                'parent:id,titulo,estado,prioridad,kanban_column',
                'children:id,parent_id,titulo,estado,prioridad,kanban_column',
                'tiempos.usuario:id,name',
                'ticketLinks.ticket:id,folio,titulo',
                'files',
            ])
            ->where('proyecto_id', $proyecto->id)
            ->orderByRaw('fecha_limite is null')
            ->orderBy('fecha_limite')
            ->latest()
            ->get();

        $userId = $request->user()->id;

        return Inertia::render('activities/index', [
            'activities' => $activities,
            'currentProject' => $proyecto->only(['id', 'nombre']),
            'projects' => Proyecto::query()
                ->with('cliente:id,nombre,razon_social')
                ->whereKey($proyecto->id)
                ->get(['id', 'nombre', 'client_id']),
            'users' => User::query()->orderBy('name')->get(['id', 'name']),
            'estadoOptions' => ProyectoActividad::ESTADOS,
            'prioridadOptions' => ProyectoActividad::PRIORIDADES,
            'tipoOptions' => ProyectoActividad::TIPOS,
            'kanbanColumns' => array_values(array_filter(
                ProyectoActividad::KANBAN_COLUMNS,
                fn (string $column) => $column !== 'terminado',
            )),
            'initialView' => $initialView,
            'metrics' => [
                'total' => $activities->count(),
                'mine' => $activities->where('responsable_id', $userId)->count(),
                'completed' => $activities->where('estado', 'terminada')->count(),
                'in_progress' => $activities->whereIn('estado', ['en_proceso', 'en_revision'])->count(),
                'overdue' => $activities
                    ->filter(fn (ProyectoActividad $activity) => $activity->fecha_limite && $activity->fecha_limite->isPast() && ! in_array($activity->estado, ['terminada', 'cancelada'], true))
                    ->count(),
                'estimated_minutes' => $activities->sum('minutos_estimados'),
                'real_minutes' => $activities->sum('minutos_reales'),
            ],
        ]);
    }

    private function requestedActivityView(Request $request, string $fallback): string
    {
        $view = $request->query('view');

        return in_array($view, ['list', 'kanban', 'schedule'], true)
            ? $view
            : $fallback;
    }

    private function billingPayload(Proyecto $proyecto): array
    {
        return [
            'plan' => $proyecto->planCobro,
            'cargos' => $proyecto->cargos,
            'pagos' => $proyecto->pagos->take(25)->values(),
            'summary' => [
                'total_cargado' => (float) $proyecto->cargos()->whereNotIn('estado', ['cancelado', 'condonado'])->sum('monto'),
                'total_pagado' => (float) $proyecto->cargos()->whereNotIn('estado', ['cancelado', 'condonado'])->sum('monto_pagado'),
                'saldo_pendiente' => (float) $proyecto->saldo_pendiente,
                'saldo_vencido' => (float) $proyecto->saldo_vencido,
                'ultimo_pago_at' => $proyecto->ultimo_pago_at,
                'proximo_vencimiento_at' => $proyecto->proximo_vencimiento_at,
                'billing_status' => $proyecto->billing_status,
            ],
        ];
    }
}
