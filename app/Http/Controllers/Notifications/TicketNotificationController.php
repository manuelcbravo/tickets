<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notifications\SendTicketEmailNotificationRequest;
use App\Models\Ticket;
use App\Services\Notifications\TicketNotificationService;
use Illuminate\Http\RedirectResponse;

class TicketNotificationController extends Controller
{
    public function sendEmail(SendTicketEmailNotificationRequest $request, Ticket $ticket, TicketNotificationService $service): RedirectResponse
    {
        $log = $service->sendEmail($ticket, $request->validated(), $request->user()->id);

        return back()->with($log->status === 'sent' ? 'success' : 'error', $log->status === 'sent' ? 'Correo enviado y registrado.' : 'El correo no pudo enviarse; se registro el fallo.');
    }

    public function resend(): RedirectResponse
    {
        return back()->with('error', 'Usa el historial de notificaciones para reenviar correos.');
    }
}
