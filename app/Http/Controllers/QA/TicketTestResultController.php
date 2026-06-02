<?php

namespace App\Http\Controllers\QA;

use App\Http\Controllers\Controller;
use App\Http\Requests\QA\StoreTicketTestResultRequest;
use App\Http\Requests\QA\UpdateTicketTestResultRequest;
use App\Models\Ticket;
use App\Models\TicketTestResult;
use App\Services\QA\TicketTestResultService;
use Illuminate\Http\RedirectResponse;

class TicketTestResultController extends Controller
{
    public function store(StoreTicketTestResultRequest $request, Ticket $ticket, TicketTestResultService $service): RedirectResponse
    {
        $service->create($ticket, $request->validated(), $request->user()->id);

        return back()->with('success', 'Resultado de prueba registrado.');
    }

    public function update(UpdateTicketTestResultRequest $request, Ticket $ticket, TicketTestResult $result, TicketTestResultService $service): RedirectResponse
    {
        $service->update($ticket, $result, $request->validated(), $request->user()->id);

        return back()->with('success', 'Resultado de prueba actualizado.');
    }

    public function destroy(Ticket $ticket, TicketTestResult $result, TicketTestResultService $service): RedirectResponse
    {
        $service->delete($ticket, $result, auth()->id());

        return back()->with('success', 'Resultado de prueba eliminado.');
    }

    public function markApproved(Ticket $ticket, TicketTestResult $result, TicketTestResultService $service): RedirectResponse
    {
        $service->update($ticket, $result, [
            ...$result->only(['test_case_id', 'development_task_id', 'titulo', 'pasos', 'resultado_esperado', 'resultado_obtenido', 'notas']),
            'status' => 'aprobado',
            'resultado_obtenido' => $result->resultado_obtenido ?: 'Prueba aprobada manualmente.',
        ], auth()->id());

        return back()->with('success', 'Prueba marcada como aprobada.');
    }

    public function markFailed(UpdateTicketTestResultRequest $request, Ticket $ticket, TicketTestResult $result, TicketTestResultService $service): RedirectResponse
    {
        $service->update($ticket, $result, [
            ...$request->validated(),
            'status' => 'fallido',
        ], $request->user()->id);

        return back()->with('success', 'Prueba marcada como fallida.');
    }

    public function markBlocked(UpdateTicketTestResultRequest $request, Ticket $ticket, TicketTestResult $result, TicketTestResultService $service): RedirectResponse
    {
        $service->update($ticket, $result, [
            ...$request->validated(),
            'status' => 'bloqueado',
        ], $request->user()->id);

        return back()->with('success', 'Prueba marcada como bloqueada.');
    }
}
