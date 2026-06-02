<?php

namespace App\Services\Development;

use App\Models\Release;
use App\Models\ReleaseTicket;
use App\Models\Ticket;
use App\Services\Tickets\TicketHistoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReleaseService
{
    public function __construct(
        private readonly TicketHistoryService $history,
        private readonly ReleaseNotesService $notes,
    ) {
    }

    public function create(array $data, ?int $userId = null): Release
    {
        return Release::query()->create([
            ...$data,
            'estado' => $data['estado'] ?? 'borrador',
            'release_notes' => $data['release_notes'] ?? null,
            'created_by_id' => $userId,
        ]);
    }

    public function update(Release $release, array $data): Release
    {
        $release->update($data);

        return $release;
    }

    public function addTicket(Release $release, array $data, ?int $userId = null): ReleaseTicket
    {
        return DB::transaction(function () use ($release, $data, $userId): ReleaseTicket {
            $exists = ReleaseTicket::query()
                ->where('release_id', $release->id)
                ->where('ticket_id', $data['ticket_id'])
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages(['ticket_id' => 'Este ticket ya esta incluido en el release.']);
            }

            $releaseTicket = ReleaseTicket::query()->create([
                ...$data,
                'release_id' => $release->id,
                'created_by_id' => $userId,
            ]);

            $ticket = Ticket::query()->findOrFail($data['ticket_id']);
            $this->history->log($ticket, 'ticket_added_to_release', $userId, descripcion: "Ticket agregado al release {$release->nombre}.", metadata: ['release_id' => $release->id, 'release_version' => $release->version]);

            return $releaseTicket;
        });
    }

    public function removeTicket(Release $release, Ticket $ticket, ?int $userId = null): void
    {
        ReleaseTicket::query()
            ->where('release_id', $release->id)
            ->where('ticket_id', $ticket->id)
            ->delete();

        $this->history->log($ticket, 'ticket_removed_from_release', $userId, descripcion: "Ticket removido del release {$release->nombre}.", metadata: ['release_id' => $release->id, 'release_version' => $release->version]);
    }

    public function publish(Release $release, ?int $userId = null): Release
    {
        if ($release->releaseTickets()->count() === 0 && blank($release->descripcion)) {
            throw ValidationException::withMessages([
                'descripcion' => 'Agrega tickets al release o registra una nota antes de liberarlo.',
            ]);
        }

        return DB::transaction(function () use ($release, $userId): Release {
            if (blank($release->release_notes)) {
                $release->release_notes = $this->notes->generate($release);
            }

            $release->forceFill([
                'estado' => 'liberado',
                'released_at' => $release->released_at ?? now(),
                'released_by_id' => $userId,
            ])->save();

            $release->load('tickets');

            foreach ($release->tickets as $ticket) {
                if ($ticket->has_code_changes) {
                    $oldStatus = $ticket->development_status;
                    $ticket->forceFill(['development_status' => 'liberado'])->save();
                    $this->history->log($ticket, 'release_published', $userId, descripcion: "Release liberado: {$release->nombre}.", metadata: ['release_id' => $release->id, 'release_version' => $release->version]);

                    if ($oldStatus !== 'liberado') {
                        $this->history->log($ticket, 'ticket_development_status_changed', $userId, 'development_status', $oldStatus, 'liberado', 'Ticket marcado como liberado tecnicamente.', ['release_id' => $release->id]);
                    }
                }
            }

            return $release;
        });
    }
}
