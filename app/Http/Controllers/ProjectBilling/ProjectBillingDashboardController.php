<?php

namespace App\Http\Controllers\ProjectBilling;

use App\Http\Controllers\Controller;
use App\Services\ProjectBilling\ProjectBillingDashboardService;
use Inertia\Inertia;
use Inertia\Response;

class ProjectBillingDashboardController extends Controller
{
    public function index(ProjectBillingDashboardService $dashboard): Response
    {
        return Inertia::render('project-billing/index', $dashboard->data());
    }
}
