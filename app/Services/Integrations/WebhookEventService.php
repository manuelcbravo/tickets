<?php

namespace App\Services\Integrations;

use App\Models\Integracion;
use App\Models\Ticket;
use App\Models\WebhookEvent;
use App\Services\Tickets\TicketHistoryService;
use Illuminate\Validation\ValidationException;

class WebhookEventService
{
    public function __construct(
        private readonly GitProviderEventService $gitEvents,
        private readonly TicketHistoryService $history,
    ) {}

    public function register(string $provider, array $payload, array $headers = [], ?Integracion $integration = null): WebhookEvent
    {
        $eventType = $this->gitEvents->eventType($provider, $payload, $headers);
        $externalId = $this->gitEvents->externalId($provider, $payload);
        $ticket = $this->findUniqueTicket($this->gitEvents->searchableText($payload));
        $status = $ticket ? 'linked' : 'received';

        $data = [
            'integration_id' => $integration?->id,
            'ticket_id' => $ticket?->id,
            'payload' => $payload,
            'headers' => $headers,
            'status' => $status,
            'processed_at' => $ticket ? now() : null,
            'error_message' => null,
        ];

        $event = $externalId
            ? WebhookEvent::query()->updateOrCreate([
                'provider' => $provider,
                'external_id' => $externalId,
                'event_type' => $eventType,
            ], $data)
            : WebhookEvent::query()->create([
                ...$data,
                'provider' => $provider,
                'external_id' => null,
                'event_type' => $eventType,
            ]);

        if ($ticket) {
            $this->history->log($ticket, 'webhook_event_received', null, descripcion: 'Webhook recibido para el ticket.', metadata: [
                'webhook_event_id' => $event->id,
                'provider' => $event->provider,
                'event_type' => $event->event_type,
                'external_id' => $event->external_id,
            ]);
            $this->logLinked($event, $ticket, 'webhook_event_linked');
            $this->history->log($ticket, 'integration_event_processed', null, descripcion: 'Evento externo procesado sin acciones destructivas.', metadata: [
                'webhook_event_id' => $event->id,
                'provider' => $event->provider,
                'event_type' => $event->event_type,
            ]);
            $this->logGitSpecificEvent($event, $ticket);
        }

        return $event;
    }

    public function linkToTicket(WebhookEvent $event, Ticket $ticket, ?int $userId = null): WebhookEvent
    {
        $event->update([
            'ticket_id' => $ticket->id,
            'status' => 'linked',
            'processed_at' => now(),
            'failed_at' => null,
            'error_message' => null,
        ]);

        $this->logLinked($event, $ticket, 'webhook_event_linked', $userId);

        return $event->refresh();
    }

    public function ignore(WebhookEvent $event): WebhookEvent
    {
        $event->update(['status' => 'ignored']);

        return $event->refresh();
    }

    public function retry(WebhookEvent $event): WebhookEvent
    {
        $ticket = $this->findUniqueTicket($this->gitEvents->searchableText($event->payload ?? []));

        if (! $ticket) {
            $event->update([
                'status' => 'failed',
                'failed_at' => now(),
                'error_message' => 'No se encontro un folio unico de ticket para vincular.',
            ]);

            throw ValidationException::withMessages(['ticket_id' => 'No se encontro un folio unico de ticket para vincular.']);
        }

        return $this->linkToTicket($event, $ticket);
    }

    public function markFailed(WebhookEvent $event, string $message): WebhookEvent
    {
        $event->update([
            'status' => 'failed',
            'failed_at' => now(),
            'error_message' => $message,
        ]);

        if ($event->ticket) {
            $this->history->log($event->ticket, 'integration_event_failed', null, descripcion: 'Evento externo fallo al procesarse.', metadata: [
                'webhook_event_id' => $event->id,
                'provider' => $event->provider,
                'event_type' => $event->event_type,
                'error' => $message,
            ]);
        }

        return $event->refresh();
    }

    private function findUniqueTicket(string $text): ?Ticket
    {
        preg_match_all(config('integrations.context.ticket_folio_pattern'), $text, $matches);
        $folios = collect($matches[1] ?? [])->map(fn (string $folio) => strtoupper($folio))->unique()->values();

        if ($folios->count() !== 1) {
            return null;
        }

        return Ticket::query()->where('folio', $folios->first())->first();
    }

    private function logLinked(WebhookEvent $event, Ticket $ticket, string $action, ?int $userId = null): void
    {
        $this->history->log($ticket, $action, $userId, descripcion: 'Evento externo vinculado al ticket.', metadata: [
            'webhook_event_id' => $event->id,
            'provider' => $event->provider,
            'event_type' => $event->event_type,
            'external_id' => $event->external_id,
            'url' => $this->gitEvents->publicUrl($event->provider, $event->payload ?? []),
        ]);
    }

    private function logGitSpecificEvent(WebhookEvent $event, Ticket $ticket): void
    {
        $payload = $event->payload ?? [];
        $action = null;

        if (in_array($event->provider, ['github', 'gitlab', 'bitbucket'], true)) {
            $text = strtolower(($event->event_type ?? '').' '.json_encode($payload));
            $action = str_contains($text, 'pull_request') || str_contains($text, 'merge_request') ? 'github_pr_linked' : null;
            $action = str_contains($text, 'commit') || str_contains($text, 'push') ? 'commit_linked' : $action;
        }

        if (! $action) {
            return;
        }

        $this->history->log($ticket, $action, null, descripcion: 'Evento Git vinculado al ticket.', metadata: [
            'webhook_event_id' => $event->id,
            'provider' => $event->provider,
            'event_type' => $event->event_type,
            'external_id' => $event->external_id,
            'url' => $this->gitEvents->publicUrl($event->provider, $payload),
        ]);
    }
}
