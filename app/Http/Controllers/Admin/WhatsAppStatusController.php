<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\WhatsAppGatewayService;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class WhatsAppStatusController extends Controller
{
    public function __construct(private readonly WhatsAppGatewayService $whatsAppGatewayService)
    {
    }

    public function index(): Response
    {
        $status = $this->whatsAppGatewayService->getStatusData();

        return Inertia::render('config/whatsapp/index', [
            'connected' => $status['connected'],
            'has_qr' => $status['has_qr'],
            'qr' => $status['qr'],
            'gateway_ok' => $status['gateway_ok'],
        ]);
    }

    public function data(): JsonResponse
    {
        $status = $this->whatsAppGatewayService->getStatusData();

        return response()->json([
            'connected' => $status['connected'],
            'has_qr' => $status['has_qr'],
            'qr' => $status['qr'],
            'gateway_ok' => $status['gateway_ok'],
        ]);
    }

    public function connect(): JsonResponse
    {
        $result = $this->whatsAppGatewayService->connect();

        return response()->json($result, $result['ok'] ? 200 : 503);
    }

    public function disconnect(): JsonResponse
    {
        $result = $this->whatsAppGatewayService->disconnect();

        return response()->json($result, $result['ok'] ? 200 : 503);
    }
}
