<?php

namespace App\Jobs\Tickets;

use App\Models\Ticket;
use App\Services\Tickets\TicketAiAnalysisService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RunTicketAiAnalysisJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly string $ticketId,
        public readonly array $options,
        public readonly int $userId,
    ) {}

    public function handle(TicketAiAnalysisService $service): void
    {
        $ticket = Ticket::query()->findOrFail($this->ticketId);

        $service->run($ticket, $this->options, $this->userId);
    }
}
