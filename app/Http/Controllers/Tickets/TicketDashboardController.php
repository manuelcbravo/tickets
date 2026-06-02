<?php

namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use App\Services\Tickets\TicketDashboardService;
use Inertia\Inertia;
use Inertia\Response;

class TicketDashboardController extends Controller
{
    public function __invoke(TicketDashboardService $service): Response
    {
        return Inertia::render('tickets/dashboard', $service->data(auth()->id()));
    }
}
