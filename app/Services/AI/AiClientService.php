<?php

namespace App\Services\AI;

use App\Exceptions\InvalidAiResponseException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class AiClientService
{
    public function isConfigured(): bool
    {
        return (bool) config('ai.enabled') && filled(config('openai.api_key'));
    }

    public function analyze(string $prompt): array
    {
        if (! $this->isConfigured()) {
            throw new RuntimeException('La IA no esta configurada o esta desactivada.');
        }

        $baseUri = config('openai.base_uri') ?: 'https://api.openai.com/v1';

        try {
            $response = Http::withToken((string) config('openai.api_key'))
                ->acceptJson()
                ->asJson()
                ->timeout((int) config('ai.timeout', 60))
                ->post(rtrim((string) $baseUri, '/').'/responses', [
                    'model' => config('ai.model'),
                    'input' => $prompt,
                    'text' => [
                        'format' => [
                            'type' => 'json_object',
                        ],
                    ],
                ]);
        } catch (ConnectionException $exception) {
            throw new RuntimeException('No se pudo conectar con el proveedor de IA: '.$exception->getMessage(), previous: $exception);
        }

        if ($response->failed()) {
            throw new RuntimeException('El proveedor de IA respondio con error '.$response->status().': '.$response->body());
        }

        $payload = $response->json();
        $text = $payload['output_text']
            ?? data_get($payload, 'output.0.content.0.text')
            ?? data_get($payload, 'choices.0.message.content');

        if (! is_string($text) || trim($text) === '') {
            throw new InvalidAiResponseException('El proveedor de IA no devolvio contenido interpretable.', $payload);
        }

        $decoded = json_decode($text, true);

        if (! is_array($decoded)) {
            throw new InvalidAiResponseException('La IA devolvio JSON invalido.', $payload, $text);
        }

        return [
            'text' => $text,
            'json' => $decoded,
            'raw' => $payload,
        ];
    }
}
