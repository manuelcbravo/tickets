<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Throwable;

class WhatsAppGatewayService
{
    private int $timeoutSeconds = 5;

    public function getStatus(): array
    {
        try {
            $response = Http::timeout($this->timeoutSeconds)->get($this->endpoint('/status'));

            if (!$response->successful()) {
                return ['ok' => false, 'connected' => false];
            }

            return [
                'ok' => (bool) data_get($response->json(), 'ok', true),
                'connected' => (bool) data_get($response->json(), 'connected', false),
            ];
        } catch (Throwable $exception) {
            return ['ok' => false, 'connected' => false];
        }
    }

    public function getQr(): array
    {
        try {
            $qr = $this->fetchQrImage();

            if ($qr !== null) {
                return ['ok' => true, 'qr' => $qr];
            }

            Http::timeout($this->timeoutSeconds)->post($this->endpoint('/reconnect'));

            $attempts = 6;

            while ($attempts > 0) {
                $qr = $this->fetchQrImage();

                if ($qr !== null) {
                    return ['ok' => true, 'qr' => $qr];
                }

                usleep(700000);
                $attempts--;
            }

            return ['ok' => true, 'qr' => null];
        } catch (Throwable $exception) {
            return ['ok' => false, 'qr' => null];
        }
    }

    public function disconnect(): array
    {
        try {
            $response = Http::timeout($this->timeoutSeconds)->post($this->endpoint('/disconnect'));

            if (!$response->successful()) {
                return ['ok' => false, 'connected' => false];
            }

            return [
                'ok' => (bool) data_get($response->json(), 'ok', true),
                'connected' => false,
            ];
        } catch (Throwable $exception) {
            return ['ok' => false, 'connected' => false];
        }
    }

    public function reconnect(): array
    {
        try {
            $response = Http::timeout($this->timeoutSeconds)->post($this->endpoint('/reconnect'));

            if (!$response->successful()) {
                return ['ok' => false, 'connected' => false];
            }

            return [
                'ok' => (bool) data_get($response->json(), 'ok', true),
                'connected' => (bool) data_get($response->json(), 'connected', false),
            ];
        } catch (Throwable $exception) {
            return ['ok' => false, 'connected' => false];
        }
    }

    private function endpoint(string $path): string
    {
        return rtrim((string) config('services.whatsapp.url'), '/') . $path;
    }

    private function fetchQrImage(): ?string
    {
        $response = Http::timeout($this->timeoutSeconds)->get($this->endpoint('/qr-json'));

        if (!$response->successful()) {
            return null;
        }

        $payload = $response->json();
        $available = (bool) data_get($payload, 'available', false);
        $qr = data_get($payload, 'qr');

        if (!$available || !is_string($qr) || $qr === '') {
            return null;
        }

        return $qr;
    }
}
