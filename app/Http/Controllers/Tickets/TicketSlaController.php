<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\RecalculateTicketSlaRequest;
use App\Http\Requests\Tickets\UpdateSlaPolicyRequest;
use App\Models\CatTicketPrioridad;
use App\Models\Client;
use App\Models\SlaPolitica;
use App\Models\Ticket;
use App\Models\TicketSla;
use App\Models\User;
use App\Services\Tickets\TicketSlaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class TicketSlaController extends Controller
{
    public function index(Request $request): Response
    {
        $slas = TicketSla::query()
            ->with([
                'ticket:id,folio,titulo,cliente_id,proyecto_id,responsable_id,estado_id,prioridad_id',
                'ticket.cliente:id,nombre',
                'ticket.proyecto:id,nombre',
                'ticket.responsable:id,name',
                'ticket.estado:id,nombre',
                'prioridad:id,nombre',
            ])
            ->when($request->input('estado_sla'), fn ($query, $value) => $query->where('estado_sla', $value))
            ->when($request->input('prioridad_id'), fn ($query, $value) => $query->where('prioridad_id', $value))
            ->when($request->input('responsable_id'), fn ($query, $value) => $query->whereHas('ticket', fn ($ticket) => $ticket->where('responsable_id', $value)))
            ->when($request->input('cliente_id'), fn ($query, $value) => $query->whereHas('ticket', fn ($ticket) => $ticket->where('cliente_id', $value)))
            ->when($request->boolean('vencidos'), fn ($query) => $query->where('estado_sla', 'vencido'))
            ->when($request->boolean('en_riesgo'), fn ($query) => $query->where('estado_sla', 'en_riesgo'))
            ->orderByRaw("CASE estado_sla WHEN 'vencido' THEN 0 WHEN 'en_riesgo' THEN 1 ELSE 2 END")
            ->orderBy('vence_resolucion_at')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('tickets/sla/index', [
            'slas' => $slas,
            'filters' => $request->only(['estado_sla', 'prioridad_id', 'responsable_id', 'cliente_id', 'vencidos', 'en_riesgo']),
            'prioridades' => CatTicketPrioridad::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
            'clientes' => Client::query()->orderBy('nombre')->get(['id', 'nombre']),
            'users' => User::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function settings(): Response
    {
        $policy = SlaPolitica::query()
            ->with('prioridades.prioridad:id,nombre')
            ->where('es_default', true)
            ->first()
            ?? SlaPolitica::query()->with('prioridades.prioridad:id,nombre')->first();

        return Inertia::render('tickets/sla/settings', [
            'policy' => $policy,
            'prioridades' => CatTicketPrioridad::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
        ]);
    }

    public function updatePolicy(UpdateSlaPolicyRequest $request, SlaPolitica $politica): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($politica, $data): void {
            if ($data['es_default'] ?? false) {
                SlaPolitica::query()
                    ->whereKeyNot($politica->id)
                    ->update(['es_default' => false]);
            }

            $politica->update([
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion'] ?? null,
                'activo' => (bool) ($data['activo'] ?? false),
                'es_default' => (bool) ($data['es_default'] ?? false),
            ]);

            foreach ($data['prioridades'] as $priority) {
                $politica->prioridades()->updateOrCreate(
                    ['prioridad_id' => $priority['prioridad_id']],
                    [
                        'tiempo_primera_respuesta_min' => $priority['tiempo_primera_respuesta_min'],
                        'tiempo_resolucion_min' => $priority['tiempo_resolucion_min'],
                        'tiempo_alerta_min' => $priority['tiempo_alerta_min'] ?? null,
                    ],
                );
            }
        });

        return back()->with('success', 'Politica SLA actualizada correctamente.');
    }

    public function recalculate(RecalculateTicketSlaRequest $request, Ticket $ticket, TicketSlaService $service): RedirectResponse
    {
        $service->recalculate($ticket, $request->user()->id);

        return back()->with('success', 'SLA recalculado correctamente.');
    }
}
