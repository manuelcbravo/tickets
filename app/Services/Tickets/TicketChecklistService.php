<?php

namespace App\Services\Tickets;

use App\Models\Ticket;
use App\Models\TicketChecklistItem;
use Illuminate\Support\Str;

class TicketChecklistService
{
    public function ensureSuggestedForTicket(Ticket $ticket, ?int $usuarioId = null): void
    {
        if ($ticket->checklistItems()->exists()) {
            return;
        }

        foreach ($this->suggestedItems($ticket->tipo?->nombre) as $index => $item) {
            $ticket->checklistItems()->create([
                ...$item,
                'orden' => $index + 1,
            ]);
        }

        if ($ticket->checklistItems()->exists()) {
            app(TicketHistoryService::class)->log(
                $ticket,
                'checklist_item_created',
                $usuarioId,
                descripcion: 'Checklist sugerido generado.',
            );
        }
    }

    public function create(Ticket $ticket, array $data, ?int $usuarioId): TicketChecklistItem
    {
        $item = $ticket->checklistItems()->create($data);

        app(TicketHistoryService::class)->log(
            $ticket,
            'checklist_item_created',
            $usuarioId,
            descripcion: 'Item de checklist creado.',
            metadata: ['item_id' => $item->id],
        );

        return $item;
    }

    public function update(TicketChecklistItem $item, array $data, ?int $usuarioId): TicketChecklistItem
    {
        $wasCompleted = $item->completado;

        if (array_key_exists('completado', $data)) {
            $data['completado_at'] = $data['completado'] ? now() : null;
            $data['completado_por_id'] = $data['completado'] ? $usuarioId : null;
        }

        $item->update($data);

        app(TicketHistoryService::class)->log(
            $item->ticket,
            $item->completado && ! $wasCompleted ? 'checklist_item_completed' : 'checklist_item_updated',
            $usuarioId,
            descripcion: $item->completado && ! $wasCompleted ? 'Item de checklist completado.' : 'Item de checklist actualizado.',
            metadata: ['item_id' => $item->id],
        );

        return $item->refresh();
    }

    public function delete(TicketChecklistItem $item, ?int $usuarioId): void
    {
        $ticket = $item->ticket;
        $itemId = $item->id;
        $item->delete();

        app(TicketHistoryService::class)->log(
            $ticket,
            'checklist_item_deleted',
            $usuarioId,
            descripcion: 'Item de checklist eliminado.',
            metadata: ['item_id' => $itemId],
        );
    }

    public function requiredPending(Ticket $ticket): bool
    {
        return $ticket->checklistItems()
            ->where('requerido', true)
            ->where('completado', false)
            ->exists();
    }

    private function suggestedItems(?string $type): array
    {
        return match (Str::of($type ?? '')->ascii()->lower()->trim()->toString()) {
            'bug' => $this->items([
                'Confirmar pasos para reproducir.',
                'Confirmar ambiente afectado.',
                'Revisar captura/video.',
                'Identificar resultado esperado.',
                'Identificar resultado obtenido.',
                'Validar si afecta a uno o varios usuarios.',
            ]),
            'soporte' => $this->items([
                'Entender duda del usuario.',
                'Verificar si existe guia o procedimiento.',
                'Preparar respuesta clara.',
                'Confirmar si requiere cambio de codigo.',
            ]),
            'mantenimiento menor' => $this->items([
                'Confirmar alcance exacto.',
                'Validar si requiere codigo.',
                'Confirmar impacto visual o funcional.',
                'Definir evidencia de cierre.',
            ]),
            'mejora funcional' => $this->items([
                'Definir alcance.',
                'Definir exclusiones.',
                'Validar si requiere cotizacion.',
                'Validar prioridad con direccion.',
            ]),
            'nuevo desarrollo' => $this->items([
                'Definir objetivo.',
                'Definir modulos afectados.',
                'Definir alcance y entregables.',
                'Marcar como posible cotizacion.',
                'No enviar directo a desarrollo sin aprobacion.',
            ]),
            'incidente critico' => $this->items([
                'Confirmar operacion afectada.',
                'Confirmar usuarios afectados.',
                'Confirmar impacto en dinero, datos, seguridad o disponibilidad.',
                'Escalar a responsable tecnico.',
                'Registrar evidencia y acciones tomadas.',
            ]),
            'solicitud comercial' => $this->items([
                'Identificar cambio solicitado.',
                'Determinar si esta dentro o fuera de soporte.',
                'Marcar como posible cotizacion.',
                'Escalar a direccion.',
            ]),
            default => $this->items([
                'Confirmar alcance.',
                'Confirmar evidencia disponible.',
                'Definir siguiente paso.',
            ]),
        };
    }

    private function items(array $titles): array
    {
        return array_map(fn (string $title): array => [
            'titulo' => $title,
            'tipo' => 'informacion',
            'requerido' => true,
            'completado' => false,
        ], $titles);
    }
}
