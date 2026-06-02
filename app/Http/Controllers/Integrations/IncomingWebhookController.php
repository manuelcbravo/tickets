<?php

namespace App\Http\Controllers\Integrations;

use App\Http\Controllers\Controller;
use App\Models\Integracion;
use App\Services\Integrations\WebhookEventService;
use App\Services\Integrations\WebhookSecurityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IncomingWebhookController extends Controller
{
    public function github(Request $request, WebhookSecurityService $security, WebhookEventService $events): JsonResponse
    {
        return $this->handle($request, 'github', $security, $events);
    }

    public function gitlab(Request $request, WebhookSecurityService $security, WebhookEventService $events): JsonResponse
    {
        return $this->handle($request, 'gitlab', $security, $events);
    }

    public function bitbucket(Request $request, WebhookSecurityService $security, WebhookEventService $events): JsonResponse
    {
        return $this->handle($request, 'bitbucket', $security, $events);
    }

    public function custom(Request $request, Integracion $integration, WebhookSecurityService $security, WebhookEventService $events): JsonResponse
    {
        return $this->handle($request, 'custom', $security, $events, $integration);
    }

    private function handle(Request $request, string $provider, WebhookSecurityService $security, WebhookEventService $events, ?Integracion $integration = null): JsonResponse
    {
        if (! $security->isValid($request, $provider, $integration)) {
            return response()->json([
                'message' => 'No se pudo validar la firma del webhook.',
                'type' => 'error',
            ], 403);
        }

        $event = $events->register(
            $provider,
            $request->json()->all() ?: $request->all(),
            $security->sanitizeHeaders($request),
            $integration,
        );

        return response()->json([
            'id' => $event->id,
            'message' => 'Webhook registrado correctamente.',
            'status' => $event->status,
            'type' => 'success',
        ], 202);
    }
}
