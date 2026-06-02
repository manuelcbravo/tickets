<?php

namespace App\Services\QA;

use App\Models\Ticket;
use App\Models\TicketValidation;
use App\Services\Tickets\TicketHistoryService;
use Illuminate\Validation\ValidationException;

class TicketValidationService
{
    public function __construct(private readonly TicketHistoryService $history)
    {
    }

    public function create(Ticket $ticket, array $data, ?int $userId = null): TicketValidation
    {
        if (($data['status'] ?? 'pendiente') === 'rechazado' && blank($data['comentario'] ?? null)) {
            throw ValidationException::withMessages(['comentario' => 'Una validacion rechazada requiere comentario.']);
        }

        if (($data['status'] ?? 'pendiente') === 'aprobado') {
            $data['validated_at'] = $data['validated_at'] ?? now();
            $data['validated_by_id'] = $data['validated_by_id'] ?? $userId;
        }

        $validation = TicketValidation::query()->create([
            ...$data,
            'ticket_id' => $ticket->id,
        ]);

        $this->history->log($ticket, 'ticket_validation_created', $userId, descripcion: "Validacion {$validation->tipo} creada.", metadata: ['validation_id' => $validation->id, 'status' => $validation->status]);
        $this->syncTicketValidation($ticket->refresh(), $validation, $userId);

        return $validation;
    }

    public function approve(Ticket $ticket, TicketValidation $validation, ?int $userId = null): TicketValidation
    {
        abort_unless($validation->ticket_id === $ticket->id, 404);

        $validation->update([
            'status' => 'aprobado',
            'validated_by_id' => $userId,
            'validated_at' => now(),
        ]);

        $this->history->log($ticket, 'ticket_validation_approved', $userId, descripcion: "Validacion {$validation->tipo} aprobada.", metadata: ['validation_id' => $validation->id]);
        $this->syncTicketValidation($ticket->refresh(), $validation, $userId);

        return $validation;
    }

    public function reject(Ticket $ticket, TicketValidation $validation, string $comment, ?int $userId = null): TicketValidation
    {
        abort_unless($validation->ticket_id === $ticket->id, 404);

        $validation->update([
            'status' => 'rechazado',
            'validated_by_id' => $userId,
            'validated_at' => null,
            'comentario' => $comment,
        ]);

        $old = $ticket->qa_status;
        $ticket->forceFill(['qa_status' => 'rechazado'])->save();
        $this->history->log($ticket, 'ticket_validation_rejected', $userId, descripcion: "Validacion {$validation->tipo} rechazada.", metadata: ['validation_id' => $validation->id]);
        $this->history->log($ticket, 'ticket_qa_status_changed', $userId, 'qa_status', $old, 'rechazado', 'QA rechazado por validacion.');

        return $validation;
    }

    private function syncTicketValidation(Ticket $ticket, TicketValidation $validation, ?int $userId): void
    {
        if ($validation->status !== 'aprobado') {
            return;
        }

        $ticket->forceFill([
            'validated_at' => $validation->validated_at,
            'validated_by_id' => $validation->validated_by_id,
            'qa_status' => $ticket->qa_status ?: 'aprobado',
        ])->save();

        if ($validation->tipo === 'qa') {
            $ticket->forceFill([
                'qa_status' => 'aprobado',
                'qa_approved_at' => $validation->validated_at,
                'qa_approved_by_id' => $validation->validated_by_id,
            ])->save();
            $this->history->log($ticket, 'ticket_qa_approved', $userId, descripcion: 'QA aprobado por validacion.');
        }
    }
}
