<?php

namespace App\Services\Integrations;

use App\Models\Integracion;
use Illuminate\Http\Request;

class WebhookSecurityService
{
    public function isValid(Request $request, string $provider, ?Integracion $integration = null): bool
    {
        if (! config('integrations.enabled') || ! config('integrations.webhooks.enabled')) {
            return false;
        }

        $secret = $this->secretFor($provider, $integration);

        if (! $secret) {
            return true;
        }

        return match ($provider) {
            'github' => $this->validGithubSignature($request, $secret),
            'gitlab' => hash_equals($secret, (string) $request->header('X-Gitlab-Token')),
            'bitbucket', 'custom' => hash_equals($secret, (string) ($request->header('X-Webhook-Secret') ?: $request->query('secret'))),
            default => hash_equals($secret, (string) $request->header('X-Webhook-Secret')),
        };
    }

    public function sanitizeHeaders(Request $request): array
    {
        return collect($request->headers->all())
            ->mapWithKeys(function (array $value, string $key): array {
                $name = strtolower($key);
                $safe = str_contains($name, 'authorization')
                    || str_contains($name, 'token')
                    || str_contains($name, 'secret')
                    || str_contains($name, 'signature')
                    ? ['[redacted]']
                    : $value;

                return [$key => $safe];
            })
            ->all();
    }

    private function secretFor(string $provider, ?Integracion $integration): ?string
    {
        $configSecret = $integration?->config['webhook_secret'] ?? null;

        if ($configSecret) {
            return $configSecret;
        }

        return config("integrations.{$provider}.secret") ?: config('integrations.webhooks.default_secret');
    }

    private function validGithubSignature(Request $request, string $secret): bool
    {
        $signature = (string) $request->header('X-Hub-Signature-256');
        if (! str_starts_with($signature, 'sha256=')) {
            return false;
        }

        $expected = 'sha256='.hash_hmac('sha256', $request->getContent(), $secret);

        return hash_equals($expected, $signature);
    }
}
