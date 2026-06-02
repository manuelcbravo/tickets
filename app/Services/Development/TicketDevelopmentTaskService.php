<?php

namespace App\Services\Development;

use App\Models\Repositorio;
use App\Models\Ticket;
use App\Models\TicketDevelopmentTask;
use App\Services\Tickets\TicketHistoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TicketDevelopmentTaskService
{
    public function __construct(private readonly TicketHistoryService $history)
    {
    }

    public function create(Ticket $ticket, array $data, ?int $userId = null): TicketDevelopmentTask
    {
        return DB::transaction(function () use ($ticket, $data, $userId): TicketDevelopmentTask {
            $data = $this->normalizeProject($ticket, $data);
            $data = $this->normalizeReview($data, $userId);
            $this->validateRepositoryProject($data);
            $this->validateStateRules($data);

            $task = TicketDevelopmentTask::query()->create([
                ...$data,
                'ticket_id' => $ticket->id,
                'estado' => $data['estado'] ?? 'pendiente',
                'creado_por_id' => $userId,
            ]);

            $this->history->log($ticket, 'development_task_created', $userId, descripcion: "Tarea tecnica creada: {$task->titulo}", metadata: ['task_id' => $task->id]);
            $this->syncTicketDevelopmentState($ticket->refresh(), $task->estado, $userId);
            $this->logTechnicalReferences($ticket, $task, $userId);

            return $task;
        });
    }

    public function update(Ticket $ticket, TicketDevelopmentTask $task, array $data, ?int $userId = null): TicketDevelopmentTask
    {
        $this->assertTaskBelongsToTicket($ticket, $task);

        return DB::transaction(function () use ($ticket, $task, $data, $userId): TicketDevelopmentTask {
            $data = $this->normalizeProject($ticket, $data, $task);
            $data = $this->normalizeReview($data, $userId);
            $this->validateRepositoryProject($data);
            $this->validateStateRules($data);

            $oldStatus = $task->estado;
            $task->update($data);

            $this->history->log($ticket, 'development_task_updated', $userId, descripcion: "Tarea tecnica actualizada: {$task->titulo}", metadata: ['task_id' => $task->id]);

            if ($oldStatus !== $task->estado) {
                $this->history->log($ticket, 'development_task_status_changed', $userId, 'estado', $oldStatus, $task->estado, "Estado tecnico cambiado a {$task->estado}.", ['task_id' => $task->id]);
            }

            $this->syncTicketDevelopmentState($ticket->refresh(), $task->estado, $userId);
            $this->logTechnicalReferences($ticket, $task, $userId);

            return $task;
        });
    }

    public function delete(Ticket $ticket, TicketDevelopmentTask $task, ?int $userId = null): void
    {
        $this->assertTaskBelongsToTicket($ticket, $task);
        $task->delete();
        $this->history->log($ticket, 'development_task_updated', $userId, descripcion: "Tarea tecnica eliminada: {$task->titulo}", metadata: ['task_id' => $task->id]);
    }

    public function review(Ticket $ticket, TicketDevelopmentTask $task, array $data, int $userId): TicketDevelopmentTask
    {
        $this->assertTaskBelongsToTicket($ticket, $task);

        $task->update([
            'estado' => $data['estado'] ?? 'aprobado',
            'reviewed_by_id' => $data['reviewed_by_id'] ?? $userId,
            'reviewed_at' => $data['reviewed_at'] ?? now(),
        ]);

        $this->history->log($ticket, 'development_task_reviewed', $userId, descripcion: "Revision tecnica registrada para {$task->titulo}.", metadata: ['task_id' => $task->id, 'estado' => $task->estado]);
        $this->syncTicketDevelopmentState($ticket->refresh(), $task->estado, $userId);

        return $task;
    }

    private function normalizeProject(Ticket $ticket, array $data, ?TicketDevelopmentTask $task = null): array
    {
        $data['proyecto_id'] = $data['proyecto_id'] ?? $task?->proyecto_id ?? $ticket->proyecto_id;

        return $data;
    }

    private function normalizeReview(array $data, ?int $userId): array
    {
        if (($data['estado'] ?? null) === 'aprobado') {
            $data['reviewed_by_id'] = $data['reviewed_by_id'] ?? $userId;
            $data['reviewed_at'] = $data['reviewed_at'] ?? now();
        }

        return $data;
    }

    private function validateRepositoryProject(array $data): void
    {
        if (empty($data['repositorio_id'])) {
            return;
        }

        $repository = Repositorio::query()->find($data['repositorio_id']);

        if (! $repository || (! empty($data['proyecto_id']) && $repository->proyecto_id !== $data['proyecto_id'])) {
            throw ValidationException::withMessages([
                'repositorio_id' => 'El repositorio debe pertenecer al proyecto seleccionado.',
            ]);
        }
    }

    private function validateStateRules(array $data): void
    {
        $estado = $data['estado'] ?? 'pendiente';

        if ($estado === 'pr_abierto' && empty($data['pull_request_url'])) {
            throw ValidationException::withMessages(['pull_request_url' => 'El PR es obligatorio cuando la tarea esta en pr_abierto.']);
        }

        if ($estado === 'mergeado' && empty($data['commit_hash']) && empty($data['pull_request_url'])) {
            throw ValidationException::withMessages(['commit_hash' => 'Commit o PR es obligatorio cuando la tarea esta mergeada.']);
        }

        if ($estado === 'aprobado' && (empty($data['reviewed_by_id']) || empty($data['reviewed_at']))) {
            throw ValidationException::withMessages(['reviewed_at' => 'La revision requiere responsable y fecha.']);
        }
    }

    private function syncTicketDevelopmentState(Ticket $ticket, string $taskStatus, ?int $userId): void
    {
        $map = [
            'en_desarrollo' => 'en_desarrollo',
            'pr_abierto' => 'en_revision',
            'en_revision' => 'en_revision',
            'aprobado' => 'en_revision',
            'mergeado' => 'listo_para_release',
            'listo_para_release' => 'listo_para_release',
            'deployado' => 'liberado',
        ];

        $newStatus = $map[$taskStatus] ?? ($ticket->development_status ?: 'pendiente');
        $oldStatus = $ticket->development_status;
        $hasCodeChanges = $ticket->has_code_changes || in_array($taskStatus, ['en_desarrollo', 'pr_abierto', 'en_revision', 'aprobado', 'mergeado', 'listo_para_release', 'deployado'], true);

        $ticket->forceFill([
            'development_status' => $newStatus,
            'has_code_changes' => $hasCodeChanges,
        ])->save();

        if ($oldStatus !== $newStatus) {
            $this->history->log($ticket, 'ticket_development_status_changed', $userId, 'development_status', $oldStatus, $newStatus, "Estado tecnico del ticket cambiado a {$newStatus}.");
        }
    }

    private function logTechnicalReferences(Ticket $ticket, TicketDevelopmentTask $task, ?int $userId): void
    {
        if ($task->branch_name) {
            $this->history->log($ticket, 'development_branch_added', $userId, 'branch_name', null, $task->branch_name, 'Rama tecnica registrada.', ['task_id' => $task->id]);
        }

        if ($task->pull_request_url) {
            $this->history->log($ticket, 'development_pr_added', $userId, 'pull_request_url', null, $task->pull_request_url, 'Pull request registrado.', ['task_id' => $task->id]);
        }

        if ($task->commit_hash) {
            $this->history->log($ticket, 'development_commit_added', $userId, 'commit_hash', null, $task->commit_hash, 'Commit registrado.', ['task_id' => $task->id]);
        }
    }

    private function assertTaskBelongsToTicket(Ticket $ticket, TicketDevelopmentTask $task): void
    {
        abort_unless($task->ticket_id === $ticket->id, 404);
    }
}
