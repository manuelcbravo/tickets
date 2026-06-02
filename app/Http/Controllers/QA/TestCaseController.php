<?php

namespace App\Http\Controllers\QA;

use App\Http\Controllers\Controller;
use App\Http\Requests\QA\StoreTestCaseRequest;
use App\Http\Requests\QA\UpdateTestCaseRequest;
use App\Models\TestCase;
use App\Models\Ticket;
use App\Services\QA\TestCaseService;
use Illuminate\Http\RedirectResponse;

class TestCaseController extends Controller
{
    public function store(StoreTestCaseRequest $request, Ticket $ticket, TestCaseService $service): RedirectResponse
    {
        $service->create($ticket, $request->validated(), $request->user()->id);

        return back()->with('success', 'Caso de prueba creado correctamente.');
    }

    public function update(UpdateTestCaseRequest $request, Ticket $ticket, TestCase $testCase, TestCaseService $service): RedirectResponse
    {
        $service->update($ticket, $testCase, $request->validated(), $request->user()->id);

        return back()->with('success', 'Caso de prueba actualizado correctamente.');
    }

    public function destroy(Ticket $ticket, TestCase $testCase, TestCaseService $service): RedirectResponse
    {
        $service->delete($ticket, $testCase, auth()->id());

        return back()->with('success', 'Caso de prueba eliminado correctamente.');
    }

    public function generate(Ticket $ticket, TestCaseService $service): RedirectResponse
    {
        $created = $service->generateFromTicket($ticket, auth()->id());

        return back()->with('success', $created > 0 ? "Se generaron {$created} casos de prueba." : 'No se generaron casos nuevos.');
    }
}
