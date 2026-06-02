<?php

namespace App\Services\Integrations;

class GitProviderEventService
{
    public function eventType(string $provider, array $payload, array $headers = []): ?string
    {
        return match ($provider) {
            'github' => $headers['x-github-event'][0] ?? $payload['action'] ?? null,
            'gitlab' => $headers['x-gitlab-event'][0] ?? $payload['object_kind'] ?? null,
            'bitbucket' => $headers['x-event-key'][0] ?? $payload['event'] ?? null,
            default => $payload['event_type'] ?? $payload['type'] ?? null,
        };
    }

    public function externalId(string $provider, array $payload): ?string
    {
        return match ($provider) {
            'github' => (string) ($payload['pull_request']['id'] ?? $payload['issue']['id'] ?? $payload['head_commit']['id'] ?? $payload['after'] ?? null),
            'gitlab' => (string) ($payload['object_attributes']['id'] ?? $payload['checkout_sha'] ?? $payload['after'] ?? null),
            'bitbucket' => (string) ($payload['pullrequest']['id'] ?? $payload['push']['changes'][0]['new']['target']['hash'] ?? null),
            default => (string) ($payload['id'] ?? $payload['external_id'] ?? null),
        } ?: null;
    }

    public function searchableText(array $payload): string
    {
        return json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '';
    }

    public function publicUrl(string $provider, array $payload): ?string
    {
        return match ($provider) {
            'github' => $payload['pull_request']['html_url'] ?? $payload['issue']['html_url'] ?? $payload['head_commit']['url'] ?? null,
            'gitlab' => $payload['object_attributes']['url'] ?? $payload['project']['web_url'] ?? null,
            'bitbucket' => $payload['pullrequest']['links']['html']['href'] ?? null,
            default => $payload['url'] ?? null,
        };
    }
}
