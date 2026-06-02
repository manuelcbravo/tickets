<?php

namespace App\Jobs\Integrations;

use App\Models\WebhookEvent;
use App\Services\Integrations\WebhookEventService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessWebhookEventJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public function __construct(public string $webhookEventId) {}

    public function handle(WebhookEventService $service): void
    {
        $event = WebhookEvent::query()->findOrFail($this->webhookEventId);

        try {
            $service->retry($event);
        } catch (\Throwable $exception) {
            $service->markFailed($event, $exception->getMessage());
        }
    }
}
