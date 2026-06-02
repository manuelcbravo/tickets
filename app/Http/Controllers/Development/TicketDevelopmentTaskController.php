<?php

namespace App\Http\Controllers\Development;

use App\Http\Controllers\Controller;
use App\Http\Requests\Development\ChangeTicketDevelopmentTaskStatusRequest;
use App\Http\Requests\Development\ReviewTicketDevelopmentTaskRequest;
use App\Http\Requests\Development\StoreTicketDevelopmentTaskRequest;
use App\Http\Requests\Development\UpdateTicketDevelopmentTaskRequest;
use App\Models\Ticket;
use App\Models\TicketDevelopmentTask;
use App\Services\Development\TicketDevelopmentTaskService;
use Illuminate\Http\RedirectResponse;

class TicketDevelopmentTaskController extends Controller
{
    public function store(StoreTicketDevelopmentTaskRequest $request, Ticket $ticket, TicketDevelopmentTaskService $service): RedirectResponse
    {
        $service->create($ticket, $request->validated(), $request->user()->id);

        return back()->with('success', 'Tarea tecnica creada correctamente.');
    }

    public function update(UpdateTicketDevelopmentTaskRequest $request, Ticket $ticket, TicketDevelopmentTask $task, TicketDevelopmentTaskService $service): RedirectResponse
    {
        $service->update($ticket, $task, $request->validated(), $request->user()->id);

        return back()->with('success', 'Tarea tecnica actualizada correctamente.');
    }

    public function destroy(Ticket $ticket, TicketDevelopmentTask $task, TicketDevelopmentTaskService $service): RedirectResponse
    {
        $service->delete($ticket, $task, auth()->id());

        return back()->with('success', 'Tarea tecnica eliminada correctamente.');
    }

    public function changeStatus(ChangeTicketDevelopmentTaskStatusRequest $request, Ticket $ticket, TicketDevelopmentTask $task, TicketDevelopmentTaskService $service): RedirectResponse
    {
        $service->update($ticket, $task, [
            ...$task->only(['proyecto_id', 'repositorio_id', 'asignado_a_id', 'titulo', 'descripcion', 'tipo', 'prioridad', 'branch_name', 'estimacion_min', 'tiempo_real_min', 'reviewed_by_id', 'reviewed_at']),
            ...$request->validated(),
        ], $request->user()->id);

        return back()->with('success', 'Estado tecnico actualizado correctamente.');
    }

    public function review(ReviewTicketDevelopmentTaskRequest $request, Ticket $ticket, TicketDevelopmentTask $task, TicketDevelopmentTaskService $service): RedirectResponse
    {
        $service->review($ticket, $task, $request->validated(), $request->user()->id);

        return back()->with('success', 'Revision tecnica registrada correctamente.');
    }
}
