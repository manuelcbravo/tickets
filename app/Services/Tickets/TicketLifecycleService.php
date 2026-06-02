<?php

namespace App\Services\Tickets;

use App\Models\CatTicketEstado;
use App\Models\Ticket;
use App\Services\Notifications\InternalNotificationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TicketLifecycleService
{
    public function create(array $data, int $usuarioId): Ticket
    {
        return DB::transaction(function () use ($data, $usuarioId): Ticket {
            $estadoId = $data['estado_id']
                ?? CatTicketEstado::query()->where('nombre', 'Nuevo')->value('id');

            $ticket = Ticket::query()->create([
                ...$data,
                'folio' => app(TicketFolioService::class)->next(),
                'estado_id' => $estadoId,
                'creado_por_id' => $usuarioId,
            ]);

            if ($ticket->responsable_id) {
                $this->syncResponsibleAssignment($ticket, $ticket->responsable_id, $usuarioId);
                $this->notifyResponsible($ticket, $ticket->responsable_id, $usuarioId);
            }

            app(TicketHistoryService::class)->log(
                $ticket,
                'ticket_created',
                $usuarioId,
                descripcion: 'Ticket creado.',
            );

            app(TicketSlaService::class)->createForTicket($ticket, $usuarioId);

            return $ticket;
        });
    }

    public function update(Ticket $ticket, array $data, int $usuarioId): Ticket
    {
        if ($ticket->closed_at) {
            throw ValidationException::withMessages([
                'ticket' => 'No se puede modificar directamente un ticket cerrado. Reabre el ticket antes de editarlo.',
            ]);
        }

        return DB::transaction(function () use ($ticket, $data, $usuarioId): Ticket {
            $original = $ticket->only(['estado_id', 'prioridad_id', 'responsable_id']);

            $ticket->update($data);

            if (
                array_key_exists('responsable_id', $data)
                && $ticket->responsable_id
                && (string) ($original['responsable_id'] ?? '') !== (string) $ticket->responsable_id
            ) {
                $this->syncResponsibleAssignment($ticket, $ticket->responsable_id, $usuarioId);
                $this->notifyResponsible($ticket, $ticket->responsable_id, $usuarioId);
            }

            app(TicketHistoryService::class)->log($ticket, 'ticket_updated', $usuarioId, descripcion: 'Ticket actualizado.');
            $this->logIfChanged($ticket, $usuarioId, $original, 'estado_id', 'status_changed');
            $this->logIfChanged($ticket, $usuarioId, $original, 'prioridad_id', 'priority_changed');
            $this->logIfChanged($ticket, $usuarioId, $original, 'responsable_id', 'responsible_changed');

            if ((string) ($original['prioridad_id'] ?? '') !== (string) ($ticket->prioridad_id ?? '')) {
                app(TicketSlaService::class)->recalculate($ticket, $usuarioId);
            }

            return $ticket->refresh();
        });
    }

    public function assign(Ticket $ticket, int $responsableId, int $usuarioId): Ticket
    {
        return DB::transaction(function () use ($ticket, $responsableId, $usuarioId): Ticket {
            $old = $ticket->responsable_id;
            $ticket->update(['responsable_id' => $responsableId]);
            if ((string) ($old ?? '') !== (string) $responsableId) {
                $this->syncResponsibleAssignment($ticket, $responsableId, $usuarioId);
                $this->notifyResponsible($ticket, $responsableId, $usuarioId);
            }

            app(TicketHistoryService::class)->log(
                $ticket,
                'responsible_changed',
                $usuarioId,
                'responsable_id',
                $old,
                $responsableId,
                'Responsable asignado.',
            );

            return $ticket->refresh();
        });
    }

    private function syncResponsibleAssignment(Ticket $ticket, int $responsableId, int $usuarioId): void
    {
        $ticket->asignaciones()->where('rol_en_ticket', 'responsable')->update(['activo' => false]);
        $ticket->asignaciones()->create([
            'usuario_id' => $responsableId,
            'asignado_por_id' => $usuarioId,
            'rol_en_ticket' => 'responsable',
            'activo' => true,
        ]);
    }

    private function notifyResponsible(Ticket $ticket, int $responsableId, int $usuarioId): void
    {
        $sent = app(InternalNotificationService::class)->notifyTicketAssigned($ticket, $responsableId);

        if (! $sent) {
            return;
        }

        app(TicketHistoryService::class)->log(
            $ticket,
            'notification_ticket_assigned_sent',
            $usuarioId,
            descripcion: 'Se notifico al responsable del ticket.',
            metadata: ['responsable_id' => $responsableId],
        );
    }

    private function logIfChanged(Ticket $ticket, int $usuarioId, array $original, string $field, string $action): void
    {
        if ((string) ($original[$field] ?? '') === (string) ($ticket->{$field} ?? '')) {
            return;
        }

        app(TicketHistoryService::class)->log(
            $ticket,
            $action,
            $usuarioId,
            $field,
            $original[$field] ?? null,
            $ticket->{$field},
        );
    }
}
