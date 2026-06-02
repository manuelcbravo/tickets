<?php

namespace App\Services\Integrations;

use App\Models\Integracion;
use Illuminate\Validation\ValidationException;

class IntegrationService
{
    private const SENSITIVE_KEYS = ['secret', 'token', 'password', 'api_key', 'apikey', 'authorization', 'private_key'];

    public function create(array $data, int $userId): Integracion
    {
        $this->rejectForbiddenMessagingProvider($data);

        return Integracion::query()->create([
            ...$data,
            'config' => $this->sanitizeConfig($data['config'] ?? null),
            'created_by_id' => $userId,
            'updated_by_id' => $userId,
        ]);
    }

    public function update(Integracion $integration, array $data, int $userId): Integracion
    {
        $this->rejectForbiddenMessagingProvider($data);

        $integration->update([
            ...$data,
            'config' => $this->sanitizeConfig($data['config'] ?? null),
            'updated_by_id' => $userId,
        ]);

        return $integration->refresh();
    }

    public function activate(Integracion $integration, int $userId): Integracion
    {
        $integration->update(['activo' => true, 'updated_by_id' => $userId]);

        return $integration->refresh();
    }

    public function deactivate(Integracion $integration, int $userId): Integracion
    {
        $integration->update(['activo' => false, 'updated_by_id' => $userId]);

        return $integration->refresh();
    }

    public function safeConfig(?array $config): ?array
    {
        if ($config === null) {
            return null;
        }

        return collect($config)
            ->mapWithKeys(fn ($value, string $key) => [$key => $this->isSensitive($key) ? '********' : $value])
            ->all();
    }

    private function sanitizeConfig(?array $config): ?array
    {
        if ($config === null) {
            return null;
        }

        return collect($config)
            ->reject(fn ($value, string $key) => $this->isSensitive($key))
            ->all();
    }

    private function isSensitive(string $key): bool
    {
        $normalized = strtolower($key);

        return collect(self::SENSITIVE_KEYS)->contains(fn (string $needle) => str_contains($normalized, $needle));
    }

    private function rejectForbiddenMessagingProvider(array $data): void
    {
        $haystack = strtolower(($data['tipo'] ?? '').' '.($data['proveedor'] ?? '').' '.($data['nombre'] ?? ''));

        if (str_contains($haystack, 'whatsapp') || str_contains($haystack, 'twilio') || str_contains($haystack, 'baileys')) {
            throw ValidationException::withMessages([
                'tipo' => 'Este sprint no permite integraciones de WhatsApp o proveedores equivalentes.',
            ]);
        }
    }
}
