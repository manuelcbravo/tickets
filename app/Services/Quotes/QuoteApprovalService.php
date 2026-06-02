<?php

namespace App\Services\Quotes;

use App\Models\Cotizacion;
use App\Services\Tickets\TicketHistoryService;
use Illuminate\Validation\ValidationException;

class QuoteApprovalService
{
    public function __construct(private readonly TicketHistoryService $history) {}

    public function approveInternal(Cotizacion $cotizacion, int $userId, ?string $comment = null): Cotizacion
    {
        if ($cotizacion->items()->count() === 0) {
            throw ValidationException::withMessages(['items' => 'No se puede aprobar una cotizacion sin partidas.']);
        }

        $cotizacion->aprobaciones()->create([
            'usuario_id' => $userId,
            'tipo' => 'interna',
            'estado' => 'aprobada',
            'comentario' => $comment,
            'approved_at' => now(),
        ]);

        $cotizacion->update([
            'estado' => 'aprobada_internamente',
            'aprobada_internamente_at' => now(),
            'aprobado_internamente_por_id' => $userId,
        ]);

        $this->logTickets($cotizacion, 'quote_approved_internal', $userId, 'Cotizacion aprobada internamente.');

        return $cotizacion->refresh();
    }

    public function approveClient(Cotizacion $cotizacion, array $data, int $userId): Cotizacion
    {
        if ($cotizacion->items()->count() === 0) {
            throw ValidationException::withMessages(['items' => 'No se puede aprobar una cotizacion sin partidas.']);
        }

        $cotizacion->aprobaciones()->create([
            'usuario_id' => $userId,
            'tipo' => 'cliente',
            'estado' => 'aprobada',
            'comentario' => $data['comentario'] ?? null,
            'nombre_aprobador' => $data['nombre_aprobador'] ?? null,
            'email_aprobador' => $data['email_aprobador'] ?? null,
            'approved_at' => now(),
        ]);

        $cotizacion->update([
            'estado' => 'aprobada_cliente',
            'aprobada_cliente_at' => now(),
            'aprobado_cliente_por_id' => $userId,
        ]);

        foreach ($cotizacion->tickets as $ticket) {
            $ticket->update([
                'quote_status' => 'aprobado',
                'quote_id' => $cotizacion->id,
            ]);
        }

        $this->logTickets($cotizacion, 'quote_approved_client', $userId, 'Cotizacion aprobada por cliente.');

        return $cotizacion->refresh();
    }

    public function rejectClient(Cotizacion $cotizacion, string $comment, int $userId): Cotizacion
    {
        $cotizacion->aprobaciones()->create([
            'usuario_id' => $userId,
            'tipo' => 'cliente',
            'estado' => 'rechazada',
            'comentario' => $comment,
            'rejected_at' => now(),
        ]);

        $cotizacion->update([
            'estado' => 'rechazada_cliente',
            'rechazada_at' => now(),
        ]);

        foreach ($cotizacion->tickets as $ticket) {
            $ticket->update(['quote_status' => 'rechazado']);
        }
        $this->logTickets($cotizacion, 'quote_rejected_client', $userId, 'Cotizacion rechazada por cliente.');

        return $cotizacion->refresh();
    }

    private function logTickets(Cotizacion $cotizacion, string $action, int $userId, string $description): void
    {
        foreach ($cotizacion->tickets as $ticket) {
            $this->history->log($ticket, $action, $userId, descripcion: $description, metadata: [
                'cotizacion_id' => $cotizacion->id,
                'folio' => $cotizacion->folio,
                'total' => $cotizacion->total,
                'estado' => $cotizacion->estado,
            ]);
        }
    }
}
