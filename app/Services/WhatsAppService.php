<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class WhatsAppService
{
    public function sendText(string $phone, string $message): array
    {
        $response = Http::timeout(20)
            ->post(config('services.whatsapp.url') . '/send', [
                'phone' => $phone,
                'message' => $message,
            ]);

        if ($response->failed()) {
            throw new RuntimeException('Error enviando WhatsApp: ' . $response->body());
        }

        return $response->json();
    }
}