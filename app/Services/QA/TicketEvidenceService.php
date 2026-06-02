<?php

namespace App\Services\QA;

use App\Models\Ticket;
use App\Models\TicketTestEvidence;
use App\Services\Tickets\TicketHistoryService;
use Illuminate\Validation\ValidationException;

class TicketEvidenceService
{
    public function __construct(private readonly TicketHistoryService $history)
    {
    }

    public function create(Ticket $ticket, array $data, ?int $userId = null): TicketTestEvidence
    {
        if (blank($data['adjunto_id'] ?? null) && blank($data['url'] ?? null) && blank($data['descripcion'] ?? null)) {
            throw ValidationException::withMessages(['descripcion' => 'Agrega un adjunto, enlace o descripcion de evidencia.']);
        }

        $evidence = TicketTestEvidence::query()->create([
            ...$data,
            'ticket_id' => $ticket->id,
            'uploaded_by_id' => $userId,
        ]);

        $this->history->log($ticket, 'test_evidence_added', $userId, descripcion: 'Evidencia QA agregada.', metadata: ['evidence_id' => $evidence->id, 'test_result_id' => $evidence->test_result_id]);

        return $evidence;
    }

    public function delete(Ticket $ticket, TicketTestEvidence $evidence, ?int $userId = null): void
    {
        abort_unless($evidence->ticket_id === $ticket->id, 404);

        $evidence->delete();
        $this->history->log($ticket, 'test_evidence_added', $userId, descripcion: 'Evidencia QA eliminada.', metadata: ['evidence_id' => $evidence->id]);
    }
}
