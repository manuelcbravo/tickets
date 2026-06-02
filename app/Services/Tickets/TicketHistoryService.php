<?php

namespace App\Services\Tickets;

use App\Models\Ticket;
use App\Models\TicketActivityLog;

class TicketHistoryService
{
    public function log(
        Ticket $ticket,
        string $accion,
        ?int $usuarioId = null,
        ?string $campo = null,
        mixed $valorAnterior = null,
        mixed $valorNuevo = null,
        ?string $descripcion = null,
        ?array $metadata = null,
    ): TicketActivityLog {
        return TicketActivityLog::query()->create([
            'ticket_id' => $ticket->id,
            'usuario_id' => $usuarioId,
            'accion' => $accion,
            'campo' => $campo,
            'valor_anterior' => $this->stringify($valorAnterior),
            'valor_nuevo' => $this->stringify($valorNuevo),
            'descripcion' => $descripcion,
            'metadata' => $metadata,
            'created_at' => now(),
        ]);
    }

    private function stringify(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_scalar($value)) {
            return (string) $value;
        }

        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
