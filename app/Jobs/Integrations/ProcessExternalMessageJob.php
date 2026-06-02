<?php

namespace App\Jobs\Integrations;

use App\Models\ExternalMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessExternalMessageJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public function __construct(public string $externalMessageId) {}

    public function handle(): void
    {
        ExternalMessage::query()->findOrFail($this->externalMessageId);
    }
}
