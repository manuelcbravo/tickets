<?php

namespace App\Services\QA;

use App\Models\Ticket;
use App\Models\TicketTestResult;
use App\Services\Tickets\TicketHistoryService;
use Illuminate\Validation\ValidationException;

class TicketTestResultService
{
    public function __construct(private readonly TicketHistoryService $history)
    {
    }

    public function create(Ticket $ticket, array $data, ?int $userId = null): TicketTestResult
    {
        $data = $this->prepareExecution($data, $userId);
        $this->validateStatusRules($data);

        $result = TicketTestResult::query()->create([
            ...$data,
            'ticket_id' => $ticket->id,
        ]);

        $this->history->log($ticket, 'test_result_created', $userId, descripcion: "Resultado QA creado: {$result->titulo}", metadata: ['test_result_id' => $result->id, 'status' => $result->status]);
        $this->syncQaStatus($ticket->refresh(), $userId);

        return $result;
    }

    public function update(Ticket $ticket, TicketTestResult $result, array $data, ?int $userId = null): TicketTestResult
    {
        abort_unless($result->ticket_id === $ticket->id, 404);

        $data = $this->prepareExecution($data, $userId);
        $this->validateStatusRules($data);
        $oldStatus = $result->status;
        $result->update($data);

        $action = match ($result->status) {
            'aprobado' => 'test_result_approved',
            'fallido' => 'test_result_failed',
            'bloqueado' => 'test_result_blocked',
            default => 'test_result_updated',
        };

        $this->history->log($ticket, $action, $userId, 'status', $oldStatus, $result->status, "Resultado QA actualizado a {$result->status}.", ['test_result_id' => $result->id]);
        $this->syncQaStatus($ticket->refresh(), $userId);

        return $result;
    }

    public function delete(Ticket $ticket, TicketTestResult $result, ?int $userId = null): void
    {
        abort_unless($result->ticket_id === $ticket->id, 404);
        $result->delete();
        $this->history->log($ticket, 'test_result_updated', $userId, descripcion: 'Resultado QA eliminado.', metadata: ['test_result_id' => $result->id]);
        $this->syncQaStatus($ticket->refresh(), $userId);
    }

    public function syncQaStatus(Ticket $ticket, ?int $userId = null): void
    {
        $old = $ticket->qa_status;
        $status = 'pendiente';

        if ($ticket->testResults()->where('status', 'fallido')->exists()) {
            $status = 'rechazado';
        } elseif ($ticket->testResults()->where('status', 'bloqueado')->exists()) {
            $status = 'bloqueado';
        } elseif ($ticket->testResults()->where('status', 'aprobado')->exists()) {
            $status = 'aprobado';
        } elseif ($ticket->testResults()->exists()) {
            $status = 'en_pruebas';
        }

        if ($old === $status) {
            return;
        }

        $updates = ['qa_status' => $status];

        if ($status === 'aprobado') {
            $updates['qa_approved_at'] = now();
            $updates['qa_approved_by_id'] = $userId;
        } elseif ($old === 'aprobado') {
            $updates['qa_approved_at'] = null;
            $updates['qa_approved_by_id'] = null;
        }

        $ticket->forceFill($updates)->save();
        $this->history->log($ticket, 'ticket_qa_status_changed', $userId, 'qa_status', $old, $status, "Estado QA cambiado a {$status}.");

        if ($status === 'aprobado') {
            $this->history->log($ticket, 'ticket_qa_approved', $userId, descripcion: 'QA aprobado por prueba aprobada.');
        } elseif (in_array($status, ['rechazado', 'bloqueado'], true)) {
            $this->history->log($ticket, 'ticket_qa_rejected', $userId, descripcion: "QA marcado como {$status}.");
        }
    }

    private function prepareExecution(array $data, ?int $userId): array
    {
        if (($data['status'] ?? 'pendiente') !== 'pendiente') {
            $data['executed_at'] = $data['executed_at'] ?? now();
            $data['executed_by_id'] = $data['executed_by_id'] ?? $userId;
        }

        return $data;
    }

    private function validateStatusRules(array $data): void
    {
        $status = $data['status'] ?? 'pendiente';

        if ($status === 'aprobado' && blank($data['resultado_obtenido'] ?? null) && blank($data['notas'] ?? null)) {
            throw ValidationException::withMessages(['resultado_obtenido' => 'Una prueba aprobada requiere resultado obtenido o notas.']);
        }

        if ($status === 'fallido' && blank($data['resultado_obtenido'] ?? null)) {
            throw ValidationException::withMessages(['resultado_obtenido' => 'Una prueba fallida debe explicar el fallo.']);
        }

        if ($status === 'bloqueado' && blank($data['notas'] ?? null)) {
            throw ValidationException::withMessages(['notas' => 'Una prueba bloqueada debe explicar el bloqueo.']);
        }
    }
}
