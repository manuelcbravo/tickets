<?php

namespace App\Services\QA;

use App\Models\Ticket;
use App\Models\User;
use App\Services\Tickets\TicketHistoryService;
use Illuminate\Validation\ValidationException;

class TicketCloseGuardService
{
    public function __construct(private readonly TicketHistoryService $history)
    {
    }

    public function assertCanClose(Ticket $ticket, User $user, ?string $forceReason = null): array
    {
        $ticket->loadMissing(['tipo:id,nombre', 'testResults', 'testEvidences', 'validations', 'developmentTasks']);
        $blockers = $this->blockers($ticket);

        if ($blockers === []) {
            return ['forced' => false, 'blockers' => []];
        }

        if ($forceReason && $user->can('tickets.manage')) {
            $this->history->log($ticket, 'ticket_close_blocked_by_qa', $user->id, descripcion: 'Cierre forzado con pendientes QA.', metadata: ['forced_close' => true, 'force_reason' => $forceReason, 'blockers' => $blockers]);

            return ['forced' => true, 'blockers' => $blockers];
        }

        $this->history->log($ticket, 'ticket_close_blocked_by_qa', $user->id, descripcion: 'Cierre bloqueado por QA.', metadata: ['forced_close' => false, 'blockers' => $blockers]);

        throw ValidationException::withMessages([
            'qa' => 'No se puede cerrar: '.implode(' ', $blockers),
            'force_reason' => 'Puedes forzar el cierre con justificacion si tienes permiso tickets.manage.',
        ]);
    }

    public function requiresQa(Ticket $ticket): bool
    {
        $ticket->loadMissing(['tipo:id,nombre', 'developmentTasks']);
        $type = mb_strtolower($ticket->tipo?->nombre ?? '');

        return str_contains($type, 'bug')
            || str_contains($type, 'incidente')
            || (bool) $ticket->requires_code_change
            || (bool) $ticket->has_code_changes
            || $ticket->developmentTasks->isNotEmpty();
    }

    public function blockers(Ticket $ticket): array
    {
        if (! $this->requiresQa($ticket)) {
            return [];
        }

        $ticket->loadMissing(['testResults', 'testEvidences', 'validations', 'tipo:id,nombre']);
        $blockers = [];
        $hasApprovedTest = $ticket->testResults->contains('status', 'aprobado');
        $hasFailedTests = $ticket->testResults->contains('status', 'fallido');
        $hasEvidence = $ticket->testEvidences->isNotEmpty();
        $hasApprovedValidation = $ticket->validations->contains(fn ($validation) => $validation->status === 'aprobado' && in_array($validation->tipo, ['interna', 'qa', 'soporte'], true));
        $type = mb_strtolower($ticket->tipo?->nombre ?? '');

        if (str_contains($type, 'bug') && ! $hasApprovedTest) {
            $blockers[] = 'Los bugs requieren al menos una prueba aprobada.';
        }

        if (($ticket->has_code_changes || $ticket->requires_code_change) && ! $hasApprovedValidation && $ticket->qa_status !== 'aprobado') {
            $blockers[] = 'Los cambios de codigo requieren QA aprobado o validacion interna.';
        }

        if ($ticket->requires_code_change && ! $hasEvidence) {
            $blockers[] = 'Los cambios de codigo requieren evidencia de prueba.';
        }

        if (str_contains($type, 'incidente') && ! $hasEvidence) {
            $blockers[] = 'Los incidentes criticos requieren evidencia minima.';
        }

        if ($hasFailedTests) {
            $blockers[] = 'Hay pruebas fallidas sin resolver.';
        }

        if (in_array($ticket->qa_status, ['rechazado', 'bloqueado'], true)) {
            $blockers[] = "El estado QA actual es {$ticket->qa_status}.";
        }

        return $blockers;
    }
}
