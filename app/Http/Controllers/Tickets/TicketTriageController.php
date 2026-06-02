<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tickets\CompleteTicketTriageRequest;
use App\Http\Requests\Tickets\StartTicketTriageRequest;
use App\Models\CatTicketEstado;
use App\Models\CatTicketImpacto;
use App\Models\CatTicketPrioridad;
use App\Models\CatTicketRiesgo;
use App\Models\CatTicketTipo;
use App\Models\CatTicketUrgencia;
use App\Models\Client;
use App\Models\Proyecto;
use App\Models\Ticket;
use App\Models\User;
use App\Services\Tickets\TicketPriorityService;
use App\Services\Tickets\TicketTriageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TicketTriageController extends Controller
{
    public function index(Request $request): Response
    {
        $triageStates = ['Nuevo', 'En triage', 'Falta informacion', 'Reabierto'];

        $tickets = Ticket::query()
            ->with(['cliente:id,nombre,razon_social', 'proyecto:id,nombre', 'responsable:id,name', 'estado:id,nombre', 'prioridad:id,nombre', 'tipo:id,nombre'])
            ->whereHas('estado', fn ($query) => $query->whereIn('nombre', $triageStates))
            ->when($request->string('search')->toString(), function ($query, string $search): void {
                $query->where(function ($nested) use ($search): void {
                    $nested->where('folio', 'ilike', "%{$search}%")
                        ->orWhere('titulo', 'ilike', "%{$search}%");
                });
            })
            ->when($request->input('cliente_id'), fn ($query, $value) => $query->where('cliente_id', $value))
            ->when($request->input('proyecto_id'), fn ($query, $value) => $query->where('proyecto_id', $value))
            ->when($request->input('estado_id'), fn ($query, $value) => $query->where('estado_id', $value))
            ->when($request->input('tipo_id'), fn ($query, $value) => $query->where('tipo_id', $value))
            ->when($request->input('prioridad_id'), fn ($query, $value) => $query->where('prioridad_id', $value))
            ->when($request->input('responsable_id'), fn ($query, $value) => $query->where('responsable_id', $value))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('tickets/triage/index', [
            'tickets' => $tickets,
            'filters' => $request->only(['search', 'cliente_id', 'proyecto_id', 'estado_id', 'tipo_id', 'prioridad_id', 'responsable_id']),
            ...$this->options(),
        ]);
    }

    public function show(Ticket $ticket, TicketPriorityService $priorityService): Response
    {
        $ticket->load([
            'cliente:id,nombre,razon_social',
            'proyecto:id,nombre',
            'contacto:id,nombre,email',
            'responsable:id,name',
            'tipo:id,nombre',
            'estado:id,nombre',
            'prioridad:id,nombre',
            'impacto:id,nombre',
            'urgencia:id,nombre',
            'riesgo:id,nombre',
            'mensajes.usuario:id,name',
            'adjuntos.usuario:id,name',
            'checklistItems.completadoPor:id,name',
            'relacionesOrigen.relatedTicket:id,folio,titulo',
        ]);

        return Inertia::render('tickets/triage/show', [
            'ticket' => $ticket,
            'suggestion' => $priorityService->suggest($ticket->tipo_id, $ticket->impacto_id, $ticket->urgencia_id, $ticket->riesgo_id, $ticket->dificultad),
            'missingInformationOptions' => $this->missingInformationOptions(),
            'relationTypes' => $this->relationTypes(),
            'relatedTicketOptions' => Ticket::query()
                ->whereKeyNot($ticket->id)
                ->latest()
                ->limit(50)
                ->get(['id', 'folio', 'titulo']),
            ...$this->options(),
        ]);
    }

    public function start(StartTicketTriageRequest $request, Ticket $ticket, TicketTriageService $service): RedirectResponse
    {
        $service->start($ticket, $request->user()->id);

        return redirect()->route('tickets.triage.show', $ticket)->with('success', 'Triage iniciado.');
    }

    public function complete(CompleteTicketTriageRequest $request, Ticket $ticket, TicketTriageService $service): RedirectResponse
    {
        $service->complete($ticket, $request->validated(), $request->user());

        return redirect()->route('tickets.show', $ticket)->with('success', 'Triage guardado correctamente.');
    }

    private function options(): array
    {
        return [
            'clientes' => Client::query()->orderBy('nombre')->get(['id', 'nombre', 'razon_social', 'estatus']),
            'proyectos' => Proyecto::query()->orderBy('nombre')->get(['id', 'client_id', 'nombre']),
            'users' => User::query()->orderBy('name')->get(['id', 'name']),
            'tipos' => CatTicketTipo::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
            'estados' => CatTicketEstado::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
            'prioridades' => CatTicketPrioridad::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
            'impactos' => CatTicketImpacto::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
            'urgencias' => CatTicketUrgencia::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
            'riesgos' => CatTicketRiesgo::query()->where('activo', true)->orderBy('orden')->get(['id', 'nombre']),
        ];
    }

    private function missingInformationOptions(): array
    {
        return [
            ['key' => 'pasos_reproducir', 'label' => 'Pasos para reproducir'],
            ['key' => 'captura_video', 'label' => 'Captura o video'],
            ['key' => 'usuario_afectado', 'label' => 'Usuario afectado'],
            ['key' => 'url_pantalla', 'label' => 'URL o pantalla'],
            ['key' => 'ambiente', 'label' => 'Ambiente'],
            ['key' => 'resultado_esperado', 'label' => 'Resultado esperado'],
            ['key' => 'resultado_obtenido', 'label' => 'Resultado obtenido'],
            ['key' => 'autorizacion_cliente', 'label' => 'Autorizacion del cliente'],
            ['key' => 'confirmacion_alcance', 'label' => 'Confirmacion de alcance'],
            ['key' => 'datos_acceso', 'label' => 'Datos de acceso o permisos'],
            ['key' => 'archivo_ejemplo', 'label' => 'Archivo de ejemplo'],
        ];
    }

    private function relationTypes(): array
    {
        return [
            ['value' => 'duplicado_de', 'label' => 'Duplicado de'],
            ['value' => 'relacionado_con', 'label' => 'Relacionado con'],
            ['value' => 'bloqueado_por', 'label' => 'Bloqueado por'],
            ['value' => 'bloquea_a', 'label' => 'Bloquea a'],
            ['value' => 'causa_raiz', 'label' => 'Causa raiz'],
            ['value' => 'seguimiento_de', 'label' => 'Seguimiento de'],
        ];
    }
}
