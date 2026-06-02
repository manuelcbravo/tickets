<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use App\Services\Notifications\EmailNotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NotificationLogController extends Controller
{
    public function index(Request $request): Response
    {
        $logs = NotificationLog::query()
            ->with(['ticket:id,folio,titulo', 'cliente:id,nombre,razon_social'])
            ->when($request->input('channel'), fn ($query, $value) => $query->where('channel', $value))
            ->when($request->input('status'), fn ($query, $value) => $query->where('status', $value))
            ->when($request->input('ticket_id'), fn ($query, $value) => $query->where('ticket_id', $value))
            ->when($request->input('cliente_id'), fn ($query, $value) => $query->where('cliente_id', $value))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('notifications/logs/index', [
            'logs' => $logs,
            'filters' => $request->only(['channel', 'status', 'ticket_id', 'cliente_id']),
            'channels' => NotificationLog::CHANNELS,
            'statuses' => NotificationLog::STATUSES,
        ]);
    }

    public function show(NotificationLog $log): Response
    {
        $log->load(['ticket:id,folio,titulo', 'cliente:id,nombre,razon_social', 'contacto:id,nombre,email', 'user:id,name', 'integration:id,nombre,tipo,proveedor']);

        return Inertia::render('notifications/logs/show', ['log' => $log]);
    }

    public function resend(NotificationLog $log, EmailNotificationService $email): RedirectResponse
    {
        if ($log->channel !== 'email') {
            return back()->with('error', 'Solo se pueden reenviar notificaciones de correo.');
        }

        $email->send($log);

        return back()->with('success', 'Reenvio procesado.');
    }
}
