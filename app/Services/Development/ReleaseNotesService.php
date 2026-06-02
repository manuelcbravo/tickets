<?php

namespace App\Services\Development;

use App\Models\Release;

class ReleaseNotesService
{
    public function generate(Release $release): string
    {
        $release->loadMissing(['tickets:id,folio,titulo,resolution']);

        $lines = [
            "# {$release->nombre}".($release->version ? " ({$release->version})" : ''),
            '',
            '## Tickets incluidos',
        ];

        foreach ($release->tickets as $ticket) {
            $lines[] = "- {$ticket->folio}: {$ticket->titulo}";
        }

        if ($release->tickets->isEmpty()) {
            $lines[] = '- Sin tickets asociados todavia.';
        }

        return implode("\n", $lines);
    }
}
