<?php

namespace App\Services\Quotes;

use App\Models\CatTicketEstado;
use App\Models\CatTicketPrioridad;
use App\Models\CatTicketTipo;
use App\Models\Cotizacion;
use App\Models\CotizacionItem;
use App\Models\Ticket;
use App\Services\Tickets\TicketHistoryService;
use App\Services\Tickets\TicketLifecycleService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class QuoteConversionService
{
    public function __construct(
        private readonly TicketLifecycleService $tickets,
        private readonly QuoteService $quotes,
        private readonly TicketHistoryService $history,
    ) {}

    public function convert(Cotizacion $cotizacion, array $data, int $userId): array
    {
        if ($cotizacion->estado !== 'aprobada_cliente') {
            throw ValidationException::withMessages(['estado' => 'Solo una cotizacion aprobada por cliente puede convertirse.']);
        }

        return DB::transaction(function () use ($cotizacion, $data, $userId): array {
            $created = [];
            $estadoId = CatTicketEstado::query()->whereIn('nombre', ['Nuevo', 'Priorizado'])->orderBy('orden')->value('id');
            $tipoId = $data['tipo_id'] ?? CatTicketTipo::query()->where('nombre', 'Nuevo desarrollo')->value('id') ?? CatTicketTipo::query()->value('id');
            $prioridadId = $data['prioridad_id'] ?? CatTicketPrioridad::query()->where('nombre', 'P2 - Media')->value('id') ?? CatTicketPrioridad::query()->value('id');

            if ($data['create_single_ticket'] ?? true) {
                $created[] = $this->createDerivedTicket($cotizacion, [
                    'titulo' => "Ejecucion {$cotizacion->folio} - {$cotizacion->titulo}",
                    'descripcion' => $cotizacion->alcance ?: $cotizacion->descripcion ?: 'Ejecucion de cotizacion aprobada.',
                    'tipo_id' => $tipoId,
                    'prioridad_id' => $prioridadId,
                    'estado_id' => $estadoId,
                ], $userId);
            } else {
                $items = $cotizacion->items()->where('es_opcional', false)->get();
                foreach ($items as $item) {
                    $created[] = $this->createDerivedTicket($cotizacion, [
                        'titulo' => $item->titulo,
                        'descripcion' => $item->descripcion ?: "Ejecucion de partida {$item->titulo} de {$cotizacion->folio}.",
                        'tipo_id' => $tipoId,
                        'prioridad_id' => $prioridadId,
                        'estado_id' => $estadoId,
                        'tiempo_estimado_min' => $this->minutesFromItem($item),
                    ], $userId);
                }
            }

            $cotizacion->update([
                'estado' => 'convertida',
                'convertida_at' => now(),
            ]);

            foreach ($cotizacion->tickets as $ticket) {
                $ticket->update(['quote_status' => 'convertido', 'quote_id' => $cotizacion->id]);
                $this->history->log($ticket, 'quote_converted_to_tickets', $userId, descripcion: "Cotizacion {$cotizacion->folio} convertida en tickets.", metadata: [
                    'cotizacion_id' => $cotizacion->id,
                    'folio' => $cotizacion->folio,
                    'created_ticket_ids' => collect($created)->pluck('id')->all(),
                ]);
            }

            return $created;
        });
    }

    private function createDerivedTicket(Cotizacion $cotizacion, array $data, int $userId): Ticket
    {
        $ticket = $this->tickets->create([
            'cliente_id' => $cotizacion->cliente_id,
            'proyecto_id' => $cotizacion->proyecto_id,
            'contacto_id' => $cotizacion->contacto_id,
            'titulo' => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'tipo_id' => $data['tipo_id'],
            'prioridad_id' => $data['prioridad_id'],
            'estado_id' => $data['estado_id'],
            'tiempo_estimado_min' => $data['tiempo_estimado_min'] ?? null,
            'requires_quote' => false,
            'quote_status' => 'aprobado',
            'quote_id' => $cotizacion->id,
        ], $userId);

        $this->quotes->linkTicket($cotizacion, $ticket, 'derivado', $userId);
        $this->history->log($ticket, 'derived_ticket_created_from_quote', $userId, descripcion: "Ticket creado desde cotizacion {$cotizacion->folio}.", metadata: [
            'cotizacion_id' => $cotizacion->id,
            'folio' => $cotizacion->folio,
        ]);

        return $ticket;
    }

    private function minutesFromItem(CotizacionItem $item): ?int
    {
        return $item->horas_estimadas ? $item->horas_estimadas * 60 : null;
    }
}
