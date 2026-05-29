<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\WhatsAppGatewayService;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class WhatsAppController extends Controller
{
    public function __construct(private readonly WhatsAppGatewayService $whatsAppGatewayService)
    {
    }

    public function index(): Response
    {
        return Inertia::render('config/whatsapp/index');
    }

    public function status(): JsonResponse
    {
        return response()->json($this->whatsAppGatewayService->getStatus());
    }

    public function qr(): JsonResponse
    {
        return response()->json($this->whatsAppGatewayService->getQr());
    }

    public function disconnect(): JsonResponse
    {
        return response()->json($this->whatsAppGatewayService->disconnect());
    }

    public function reconnect(): JsonResponse
    {
        return response()->json($this->whatsAppGatewayService->reconnect());
    }
}
