<?php

namespace App\Services\Quotes;

use App\Models\Cotizacion;
use App\Models\CotizacionItem;
use App\Services\Tickets\TicketHistoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class QuoteService
{
    public function __construct(
        private readonly QuoteFolioService $folioService,
        private readonly QuoteCalculatorService $calculator,
        private readonly TicketHistoryService $history,
    ) {}

    public function create(array $data, int $userId): Cotizacion
    {
        return DB::transaction(function () use ($data, $userId): Cotizacion {
            $cotizacion = Cotizacion::query()->create([
                ...$data,
                'folio' => $this->folioService->next(),
                'creado_por_id' => $userId,
                'estado' => $data['estado'] ?? 'borrador',
            ]);

            if ($cotizacion->ticketOrigen) {
                $this->linkTicket($cotizacion, $cotizacion->ticketOrigen, 'origen', $userId);
                $cotizacion->ticketOrigen->update([
                    'requires_quote' => true,
                    'quote_status' => 'cotizado',
                    'quote_id' => $cotizacion->id,
                ]);
                $this->history->log($cotizacion->ticketOrigen, 'quote_created_from_ticket', $userId, descripcion: "Cotizacion {$cotizacion->folio} creada desde ticket.", metadata: [
                    'cotizacion_id' => $cotizacion->id,
                    'folio' => $cotizacion->folio,
                ]);
            }

            return $cotizacion;
        });
    }

    public function update(Cotizacion $cotizacion, array $data): Cotizacion
    {
        if ($cotizacion->estado === 'convertida') {
            $allowed = array_intersect_key($data, array_flip(['notas_internas']));
            if (count($allowed) !== count($data)) {
                throw ValidationException::withMessages(['cotizacion' => 'Una cotizacion convertida solo permite actualizar notas internas.']);
            }
            $data = $allowed;
        }

        $cotizacion->update($data);

        return $this->calculator->recalculate($cotizacion);
    }

    public function cancel(Cotizacion $cotizacion, string $comment, int $userId): Cotizacion
    {
        if ($cotizacion->estado === 'convertida') {
            throw ValidationException::withMessages(['estado' => 'No se puede cancelar una cotizacion convertida.']);
        }

        $cotizacion->update([
            'estado' => 'cancelada',
            'cancelada_at' => now(),
            'notas_internas' => trim(($cotizacion->notas_internas ? $cotizacion->notas_internas."\n\n" : '').'Cancelacion: '.$comment),
        ]);

        foreach ($cotizacion->tickets as $ticket) {
            $this->history->log($ticket, 'quote_cancelled', $userId, descripcion: "Cotizacion {$cotizacion->folio} cancelada.", metadata: [
                'cotizacion_id' => $cotizacion->id,
                'folio' => $cotizacion->folio,
                'comment' => $comment,
            ]);
        }

        return $cotizacion->refresh();
    }

    public function createItem(Cotizacion $cotizacion, array $data): CotizacionItem
    {
        $item = $cotizacion->items()->create([
            ...$data,
            'subtotal' => $this->calculator->itemSubtotal($data),
        ]);

        $this->calculator->recalculate($cotizacion);

        return $item;
    }

    public function updateItem(Cotizacion $cotizacion, CotizacionItem $item, array $data): CotizacionItem
    {
        abort_unless($item->cotizacion_id === $cotizacion->id, 404);

        $item->update([
            ...$data,
            'subtotal' => $this->calculator->itemSubtotal($data),
        ]);

        $this->calculator->recalculate($cotizacion);

        return $item->refresh();
    }

    public function deleteItem(Cotizacion $cotizacion, CotizacionItem $item): void
    {
        abort_unless($item->cotizacion_id === $cotizacion->id, 404);

        $item->delete();
        $this->calculator->recalculate($cotizacion);
    }

    public function linkTicket(Cotizacion $cotizacion, \App\Models\Ticket $ticket, string $type, int $userId): void
    {
        $cotizacion->cotizacionTickets()->firstOrCreate([
            'ticket_id' => $ticket->id,
            'tipo_relacion' => $type,
        ], [
            'created_by_id' => $userId,
        ]);

        $this->history->log($ticket, 'quote_linked_to_ticket', $userId, descripcion: "Ticket relacionado con cotizacion {$cotizacion->folio}.", metadata: [
            'cotizacion_id' => $cotizacion->id,
            'folio' => $cotizacion->folio,
            'tipo_relacion' => $type,
        ]);
    }
}
