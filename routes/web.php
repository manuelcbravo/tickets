<?php

use App\Http\Controllers\Config\AuditController;
use App\Http\Controllers\Development\ReleaseController;
use App\Http\Controllers\Development\ReleaseTicketController;
use App\Http\Controllers\Development\RepositoryController;
use App\Http\Controllers\Development\TicketDevelopmentLinkController;
use App\Http\Controllers\Development\TicketDevelopmentTaskController;
use App\Http\Controllers\Integrations\ExternalMessageController;
use App\Http\Controllers\Integrations\IncomingWebhookController;
use App\Http\Controllers\Integrations\IntegrationController;
use App\Http\Controllers\Integrations\WebhookEventController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Knowledge\KnowledgeArticleController;
use App\Http\Controllers\Knowledge\KnowledgeCategoryController;
use App\Http\Controllers\Knowledge\TicketKnowledgeArticleController;
use App\Http\Controllers\Clientes\ClienteContactoController;
use App\Http\Controllers\Clientes\ClienteController;
use App\Http\Controllers\Config\RoleController;
use App\Http\Controllers\Config\UserController;
use App\Http\Controllers\Proyectos\AmbienteController;
use App\Http\Controllers\Proyectos\ProyectoController;
use App\Http\Controllers\Proyectos\ProyectoModuloController;
use App\Http\Controllers\Proyectos\ProyectoSectionController;
use App\Http\Controllers\ProjectBilling\ProjectBillingDashboardController;
use App\Http\Controllers\ProjectBilling\ProjectBillingProfileController;
use App\Http\Controllers\ProjectBilling\ProjectChargeController;
use App\Http\Controllers\ProjectBilling\ProjectPaymentAllocationController;
use App\Http\Controllers\ProjectBilling\ProjectPaymentController;
use App\Http\Controllers\ProjectBilling\ProjectPaymentDocumentController;
use App\Http\Controllers\ProjectBilling\TicketBillingWarningController;
use App\Http\Controllers\Quotes\QuoteApprovalController;
use App\Http\Controllers\Quotes\QuoteController;
use App\Http\Controllers\Quotes\QuoteConversionController;
use App\Http\Controllers\Quotes\QuoteFromTicketController;
use App\Http\Controllers\Quotes\QuoteItemController;
use App\Http\Controllers\Notifications\NotificationLogController;
use App\Http\Controllers\Notifications\TicketNotificationController;
use App\Http\Controllers\Notifications\UserNotificationController;
use App\Http\Controllers\ProjectPlanning\ProjectActivityController;
use App\Http\Controllers\ProjectPlanning\ProjectActivityTicketController;
use App\Http\Controllers\ProjectPlanning\ProjectActivityTimeController;
use App\Http\Controllers\ProjectPlanning\ProjectKanbanController;
use App\Http\Controllers\ProjectPlanning\ProjectPlanningController;
use App\Http\Controllers\QA\TestCaseController;
use App\Http\Controllers\QA\TicketQaDashboardController;
use App\Http\Controllers\QA\TicketTestEvidenceController;
use App\Http\Controllers\QA\TicketTestResultController;
use App\Http\Controllers\QA\TicketValidationController;
use App\Http\Controllers\Tickets\TicketCatalogController;
use App\Http\Controllers\Tickets\TicketAiActionController;
use App\Http\Controllers\Tickets\TicketAiController;
use App\Http\Controllers\Tickets\TicketAssignmentController;
use App\Http\Controllers\Tickets\TicketAttachmentController;
use App\Http\Controllers\Tickets\TicketChecklistController;
use App\Http\Controllers\Tickets\TicketController;
use App\Http\Controllers\Tickets\TicketDashboardController;
use App\Http\Controllers\Tickets\TicketMessageController;
use App\Http\Controllers\Tickets\TicketPriorityController;
use App\Http\Controllers\Tickets\TicketRelationController;
use App\Http\Controllers\Tickets\TicketStatusController;
use App\Http\Controllers\Tickets\TicketSlaController;
use App\Http\Controllers\Tickets\TicketTimeController;
use App\Http\Controllers\Tickets\TicketTriageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\SeguimientoController;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('dashboard', fn() => Inertia::render('dashboard'))
        ->name('dashboard');

    Route::prefix('config')->name('config.')->group(function () {
        Route::resource('users', UserController::class)->only(['index', 'store', 'destroy']);
        Route::resource('roles', RoleController::class)->only(['index', 'store', 'destroy']);

        Route::get('audits', [AuditController::class, 'index'])->name('audits.index');
    });

    Route::resource('files', FileController::class)->only(['index', 'store', 'destroy']);
    Route::patch('files/{file}/rename', [FileController::class, 'rename'])->name('files.rename');

    Route::prefix('integrations')->name('integrations.')->group(function () {
        Route::get('/', [IntegrationController::class, 'index'])
            ->middleware('permission:integrations.view|integrations.manage')
            ->name('index');
        Route::get('create', [IntegrationController::class, 'create'])
            ->middleware('permission:integrations.manage')
            ->name('create');
        Route::post('/', [IntegrationController::class, 'store'])
            ->middleware('permission:integrations.manage')
            ->name('store');
        Route::get('webhooks/events', [WebhookEventController::class, 'index'])
            ->middleware('permission:integrations.webhooks.view|integrations.webhooks.manage')
            ->name('webhooks.index');
        Route::get('webhooks/events/{event}', [WebhookEventController::class, 'show'])
            ->middleware('permission:integrations.webhooks.view|integrations.webhooks.manage')
            ->name('webhooks.show');
        Route::patch('webhooks/events/{event}/link-ticket', [WebhookEventController::class, 'linkToTicket'])
            ->middleware('permission:integrations.webhooks.manage')
            ->name('webhooks.link-ticket');
        Route::patch('webhooks/events/{event}/ignore', [WebhookEventController::class, 'ignore'])
            ->middleware('permission:integrations.webhooks.manage')
            ->name('webhooks.ignore');
        Route::patch('webhooks/events/{event}/retry', [WebhookEventController::class, 'retry'])
            ->middleware('permission:integrations.webhooks.manage')
            ->name('webhooks.retry');
        Route::get('messages', [ExternalMessageController::class, 'index'])
            ->middleware('permission:integrations.view|integrations.manage')
            ->name('messages.index');
        Route::get('messages/{message}', [ExternalMessageController::class, 'show'])
            ->middleware('permission:integrations.view|integrations.manage')
            ->name('messages.show');
        Route::patch('messages/{message}/link-ticket', [ExternalMessageController::class, 'linkToTicket'])
            ->middleware('permission:integrations.manage')
            ->name('messages.link-ticket');
        Route::post('messages/{message}/convert-comment', [ExternalMessageController::class, 'convertToComment'])
            ->middleware('permission:integrations.manage')
            ->name('messages.convert-comment');
        Route::get('{integration}', [IntegrationController::class, 'show'])
            ->middleware('permission:integrations.view|integrations.manage')
            ->name('show');
        Route::get('{integration}/edit', [IntegrationController::class, 'edit'])
            ->middleware('permission:integrations.manage')
            ->name('edit');
        Route::match(['put', 'patch'], '{integration}', [IntegrationController::class, 'update'])
            ->middleware('permission:integrations.manage')
            ->name('update');
        Route::delete('{integration}', [IntegrationController::class, 'destroy'])
            ->middleware('permission:integrations.manage')
            ->name('destroy');
        Route::patch('{integration}/activate', [IntegrationController::class, 'activate'])
            ->middleware('permission:integrations.manage')
            ->name('activate');
        Route::patch('{integration}/deactivate', [IntegrationController::class, 'deactivate'])
            ->middleware('permission:integrations.manage')
            ->name('deactivate');
    });

    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [UserNotificationController::class, 'index'])->name('index');
        Route::patch('read-all', [UserNotificationController::class, 'markAllAsRead'])->name('read-all');
        Route::patch('{notification}/read', [UserNotificationController::class, 'markAsRead'])->name('read');
        Route::patch('{notification}/unread', [UserNotificationController::class, 'markAsUnread'])->name('unread');
        Route::delete('{notification}', [UserNotificationController::class, 'destroy'])->name('destroy');

        Route::get('logs', [NotificationLogController::class, 'index'])
            ->middleware('permission:notifications.view|notifications.manage')
            ->name('logs.index');
        Route::get('logs/{log}', [NotificationLogController::class, 'show'])
            ->middleware('permission:notifications.view|notifications.manage')
            ->name('logs.show');
        Route::patch('logs/{log}/resend', [NotificationLogController::class, 'resend'])
            ->middleware('permission:notifications.manage')
            ->name('logs.resend');
    });

    Route::prefix('project-billing')->name('project-billing.')->group(function () {
        Route::get('/', [ProjectBillingDashboardController::class, 'index'])
            ->middleware('permission:project-billing.view|project-billing.reports')
            ->name('dashboard');
        Route::get('profiles/create', [ProjectBillingProfileController::class, 'create'])
            ->middleware('permission:project-billing.manage')
            ->name('profiles.create');
        Route::post('profiles', [ProjectBillingProfileController::class, 'storeGlobal'])
            ->middleware('permission:project-billing.manage')
            ->name('profiles.store');
        Route::get('profiles/{profile}/edit', [ProjectBillingProfileController::class, 'edit'])
            ->middleware('permission:project-billing.manage')
            ->name('profiles.edit');
        Route::match(['put', 'patch'], 'profiles/{profile}', [ProjectBillingProfileController::class, 'updateGlobal'])
            ->middleware('permission:project-billing.manage')
            ->name('profiles.update');
        Route::get('charges', [ProjectChargeController::class, 'index'])
            ->middleware('permission:project-billing.charges.view|project-billing.charges.manage')
            ->name('charges.index');
        Route::get('payments', [ProjectPaymentController::class, 'index'])
            ->middleware('permission:project-billing.payments.view|project-billing.payments.manage')
            ->name('payments.index');
        Route::get('payments/create', [ProjectPaymentController::class, 'create'])
            ->middleware('permission:project-billing.payments.manage')
            ->name('payments.create');
        Route::post('payments', [ProjectPaymentController::class, 'store'])
            ->middleware('permission:project-billing.payments.manage')
            ->name('payments.store');
        Route::get('payments/{payment}', [ProjectPaymentController::class, 'show'])
            ->middleware('permission:project-billing.payments.view|project-billing.payments.manage')
            ->name('payments.show');
        Route::get('payments/{payment}/edit', [ProjectPaymentController::class, 'edit'])
            ->middleware('permission:project-billing.payments.manage')
            ->name('payments.edit');
        Route::match(['put', 'patch'], 'payments/{payment}', [ProjectPaymentController::class, 'update'])
            ->middleware('permission:project-billing.payments.manage')
            ->name('payments.update');
        Route::patch('payments/{payment}/confirm', [ProjectPaymentController::class, 'confirm'])
            ->middleware('permission:project-billing.payments.confirm')
            ->name('payments.confirm');
        Route::patch('payments/{payment}/reject', [ProjectPaymentController::class, 'reject'])
            ->middleware('permission:project-billing.payments.manage')
            ->name('payments.reject');
        Route::patch('payments/{payment}/cancel', [ProjectPaymentController::class, 'cancel'])
            ->middleware('permission:project-billing.payments.manage')
            ->name('payments.cancel');
        Route::post('payments/{payment}/documents', [ProjectPaymentDocumentController::class, 'store'])
            ->middleware('permission:project-billing.documents.manage')
            ->name('payments.documents.store');
        Route::delete('payments/{payment}/documents/{document}', [ProjectPaymentDocumentController::class, 'destroy'])
            ->middleware('permission:project-billing.documents.manage')
            ->name('payments.documents.destroy');
        Route::get('payments/{payment}/documents/{document}/download', [ProjectPaymentDocumentController::class, 'download'])
            ->middleware('permission:project-billing.payments.view|project-billing.payments.manage')
            ->name('payments.documents.download');
        Route::post('payments/{payment}/allocations', [ProjectPaymentAllocationController::class, 'store'])
            ->middleware('permission:project-billing.payments.manage')
            ->name('payments.allocations.store');
        Route::delete('payments/{payment}/allocations/{allocation}', [ProjectPaymentAllocationController::class, 'destroy'])
            ->middleware('permission:project-billing.payments.manage')
            ->name('payments.allocations.destroy');
    });

    Route::prefix('knowledge')->name('knowledge.')->group(function () {
        Route::get('/', [KnowledgeArticleController::class, 'index'])
            ->middleware('permission:knowledge.view')
            ->name('index');
        Route::get('create', [KnowledgeArticleController::class, 'create'])
            ->middleware('permission:knowledge.create')
            ->name('create');
        Route::post('/', [KnowledgeArticleController::class, 'store'])
            ->middleware('permission:knowledge.create')
            ->name('store');
        Route::get('categories', [KnowledgeCategoryController::class, 'index'])
            ->middleware('permission:knowledge.manage')
            ->name('categories.index');
        Route::post('categories', [KnowledgeCategoryController::class, 'store'])
            ->middleware('permission:knowledge.manage')
            ->name('categories.store');
        Route::match(['put', 'patch'], 'categories/{category}', [KnowledgeCategoryController::class, 'update'])
            ->middleware('permission:knowledge.manage')
            ->name('categories.update');
        Route::delete('categories/{category}', [KnowledgeCategoryController::class, 'destroy'])
            ->middleware('permission:knowledge.delete')
            ->name('categories.destroy');
        Route::get('{article}', [KnowledgeArticleController::class, 'show'])
            ->middleware('permission:knowledge.view')
            ->name('show');
        Route::get('{article}/edit', [KnowledgeArticleController::class, 'edit'])
            ->middleware('permission:knowledge.manage')
            ->name('edit');
        Route::match(['put', 'patch'], '{article}', [KnowledgeArticleController::class, 'update'])
            ->middleware('permission:knowledge.manage')
            ->name('update');
        Route::delete('{article}', [KnowledgeArticleController::class, 'destroy'])
            ->middleware('permission:knowledge.delete')
            ->name('destroy');
        Route::patch('{article}/publish', [KnowledgeArticleController::class, 'publish'])
            ->middleware('permission:knowledge.publish')
            ->name('publish');
        Route::patch('{article}/archive', [KnowledgeArticleController::class, 'archive'])
            ->middleware('permission:knowledge.manage')
            ->name('archive');
    });

    Route::resource('clientes', ClienteController::class)
        ->parameters(['clientes' => 'client'])
        ->middlewareFor(['index', 'show'], 'permission:clientes.view')
        ->middlewareFor(['create', 'store'], 'permission:clientes.create')
        ->middlewareFor(['edit', 'update'], 'permission:clientes.manage')
        ->middlewareFor(['destroy'], 'permission:clientes.delete');

    Route::get('clientes/{client}/proyectos', [ClienteController::class, 'proyectos'])
        ->middleware('permission:clientes.view|proyectos.view')
        ->name('clientes.proyectos.index');

    Route::prefix('clientes/{client}/contactos')
        ->name('clientes.contactos.')
        ->middleware('permission:clientes.manage')
        ->group(function () {
            Route::post('/', [ClienteContactoController::class, 'store'])->name('store');
            Route::match(['put', 'patch'], '{contacto}', [ClienteContactoController::class, 'update'])->name('update');
            Route::delete('{contacto}', [ClienteContactoController::class, 'destroy'])->name('destroy');
        });

    Route::prefix('actividades')
        ->name('activities.')
        ->group(function () {
            Route::get('dashboard', [ProjectActivityController::class, 'dashboard'])
                ->middleware('permission:project-planning.activities.view|project-planning.activities.manage')
                ->name('dashboard');
            Route::get('kanban', [ProjectActivityController::class, 'kanban'])
                ->middleware('permission:project-planning.kanban.view|project-planning.kanban.manage')
                ->name('kanban');
            Route::redirect('finalizadas', '/actividades/terminadas')->name('completed.redirect');
            Route::get('terminadas', [ProjectActivityController::class, 'completed'])
                ->middleware('permission:project-planning.activities.view|project-planning.activities.manage')
                ->name('completed');
            Route::get('/', [ProjectActivityController::class, 'index'])
                ->middleware('permission:project-planning.activities.view|project-planning.activities.manage')
                ->name('index');
            Route::post('/', [ProjectActivityController::class, 'storeGlobal'])
                ->middleware('permission:project-planning.activities.manage')
                ->name('store');
            Route::get('{activity}', [ProjectActivityController::class, 'show'])
                ->middleware('permission:project-planning.activities.view|project-planning.activities.manage')
                ->name('show');
            Route::match(['put', 'patch'], '{activity}', [ProjectActivityController::class, 'updateGlobal'])
                ->middleware('permission:project-planning.activities.manage')
                ->name('update');
            Route::delete('{activity}', [ProjectActivityController::class, 'destroyGlobal'])
                ->middleware('permission:project-planning.activities.manage')
                ->name('destroy');
            Route::patch('{activity}/complete', [ProjectActivityController::class, 'completeGlobal'])
                ->middleware('permission:project-planning.activities.manage')
                ->name('complete');
            Route::patch('{activity}/cancel', [ProjectActivityController::class, 'cancelGlobal'])
                ->middleware('permission:project-planning.activities.manage')
                ->name('cancel');
            Route::patch('{activity}/kanban', [ProjectActivityController::class, 'kanbanGlobal'])
                ->middleware('permission:project-planning.kanban.manage')
                ->name('kanban.update');
        });

    Route::resource('proyectos', ProyectoController::class)
        ->parameters(['proyectos' => 'proyecto'])
        ->middlewareFor(['index', 'show'], 'permission:proyectos.view')
        ->middlewareFor(['create', 'store'], 'permission:proyectos.create')
        ->middlewareFor(['edit', 'update'], 'permission:proyectos.manage')
        ->middlewareFor(['destroy'], 'permission:proyectos.delete');

    Route::get('proyectos/{proyecto}/documents', [ProyectoSectionController::class, 'documents'])
        ->middleware('permission:project-planning.documents.view|project-planning.documents.manage')
        ->name('proyectos.documents.index');

    Route::get('proyectos/{proyecto}/tickets', [ProyectoSectionController::class, 'tickets'])
        ->middleware('permission:tickets.view|tickets.manage')
        ->name('proyectos.tickets.index');

    Route::prefix('proyectos/{proyecto}/modulos')
        ->name('proyectos.modulos.')
        ->group(function () {
            Route::get('/', [ProyectoSectionController::class, 'modulos'])
                ->middleware('permission:proyectos.view|proyectos.manage')
                ->name('index');
            Route::middleware('permission:proyectos.manage')->group(function () {
                Route::post('/', [ProyectoModuloController::class, 'store'])->name('store');
                Route::match(['put', 'patch'], '{modulo}', [ProyectoModuloController::class, 'update'])->name('update');
                Route::delete('{modulo}', [ProyectoModuloController::class, 'destroy'])->name('destroy');
            });
        });

    Route::prefix('proyectos/{proyecto}/ambientes')
        ->name('proyectos.ambientes.')
        ->group(function () {
            Route::get('/', [ProyectoSectionController::class, 'ambientes'])
                ->middleware('permission:proyectos.view|proyectos.manage')
                ->name('index');
            Route::middleware('permission:proyectos.manage')->group(function () {
                Route::post('/', [AmbienteController::class, 'store'])->name('store');
                Route::match(['put', 'patch'], '{ambiente}', [AmbienteController::class, 'update'])->name('update');
                Route::delete('{ambiente}', [AmbienteController::class, 'destroy'])->name('destroy');
            });
        });

    Route::prefix('proyectos/{proyecto}/billing')
        ->name('proyectos.billing.')
        ->group(function () {
            Route::get('/', [ProyectoSectionController::class, 'billing'])
                ->middleware('permission:project-billing.view|project-billing.reports|project-billing.manage')
                ->name('index');
            Route::get('charges', [ProyectoSectionController::class, 'charges'])
                ->middleware('permission:project-billing.charges.view|project-billing.charges.manage')
                ->name('charges.index');
            Route::get('payments', [ProyectoSectionController::class, 'payments'])
                ->middleware('permission:project-billing.payments.view|project-billing.payments.manage')
                ->name('payments.index');
            Route::post('profile', [ProjectBillingProfileController::class, 'store'])
                ->middleware('permission:project-billing.manage')
                ->name('profile.store');
            Route::match(['put', 'patch'], 'profile/{profile}', [ProjectBillingProfileController::class, 'update'])
                ->middleware('permission:project-billing.manage')
                ->name('profile.update');
            Route::patch('profile/{profile}/pause', [ProjectBillingProfileController::class, 'pause'])
                ->middleware('permission:project-billing.manage')
                ->name('profile.pause');
            Route::patch('profile/{profile}/activate', [ProjectBillingProfileController::class, 'activate'])
                ->middleware('permission:project-billing.manage')
                ->name('profile.activate');
            Route::patch('profile/{profile}/cancel', [ProjectBillingProfileController::class, 'cancel'])
                ->middleware('permission:project-billing.manage')
                ->name('profile.cancel');
            Route::post('charges', [ProjectChargeController::class, 'store'])
                ->middleware('permission:project-billing.charges.manage')
                ->name('charges.store');
            Route::match(['put', 'patch'], 'charges/{charge}', [ProjectChargeController::class, 'update'])
                ->middleware('permission:project-billing.charges.manage')
                ->name('charges.update');
            Route::patch('charges/{charge}/cancel', [ProjectChargeController::class, 'cancel'])
                ->middleware('permission:project-billing.charges.manage')
                ->name('charges.cancel');
            Route::patch('charges/{charge}/forgive', [ProjectChargeController::class, 'forgive'])
                ->middleware('permission:project-billing.charges.manage')
                ->name('charges.forgive');
        });

    Route::get('proyectos/{proyecto}/planning', [ProjectPlanningController::class, 'show'])
        ->middleware('permission:project-planning.view')
        ->name('proyectos.planning.show');
    Route::match(['put', 'patch'], 'proyectos/{proyecto}/planning', [ProjectPlanningController::class, 'update'])
        ->middleware('permission:project-planning.manage')
        ->name('proyectos.planning.update');

    Route::prefix('proyectos/{proyecto}')->name('proyectos.')->group(function () {
        Route::get('activities', [ProyectoSectionController::class, 'activities'])
            ->middleware('permission:project-planning.activities.view|project-planning.activities.manage')
            ->name('activities.index');
        Route::get('activities/kanban', [ProyectoSectionController::class, 'kanban'])
            ->middleware('permission:project-planning.kanban.view|project-planning.kanban.manage')
            ->name('activities.kanban.index');
        Route::get('activities/{activity}', [ProyectoSectionController::class, 'activityShow'])
            ->middleware('permission:project-planning.activities.view|project-planning.activities.manage')
            ->name('activities.show');
        Route::post('activities', [ProjectActivityController::class, 'store'])
            ->middleware('permission:project-planning.activities.manage')
            ->name('activities.store');
        Route::match(['put', 'patch'], 'activities/{activity}', [ProjectActivityController::class, 'update'])
            ->middleware('permission:project-planning.activities.manage')
            ->name('activities.update');
        Route::delete('activities/{activity}', [ProjectActivityController::class, 'destroy'])
            ->middleware('permission:project-planning.activities.manage')
            ->name('activities.destroy');
        Route::patch('activities/{activity}/complete', [ProjectActivityController::class, 'complete'])
            ->middleware('permission:project-planning.activities.manage')
            ->name('activities.complete');
        Route::patch('activities/{activity}/cancel', [ProjectActivityController::class, 'cancel'])
            ->middleware('permission:project-planning.activities.manage')
            ->name('activities.cancel');
        Route::patch('activities/{activity}/kanban', [ProjectKanbanController::class, 'updateColumn'])
            ->middleware('permission:project-planning.kanban.manage')
            ->name('activities.kanban');
        Route::get('activities/{activity}/kanban/edit', [ProjectKanbanController::class, 'edit'])
            ->middleware('permission:project-planning.kanban.manage')
            ->name('activities.kanban.edit');

        Route::get('activities/{activity}/times/create', [ProjectActivityTimeController::class, 'create'])
            ->middleware('permission:project-planning.activities.time')
            ->name('activities.times.create');
        Route::post('activities/{activity}/times', [ProjectActivityTimeController::class, 'store'])
            ->middleware('permission:project-planning.activities.time')
            ->name('activities.times.store');
        Route::match(['put', 'patch'], 'activities/{activity}/times/{time}', [ProjectActivityTimeController::class, 'update'])
            ->middleware('permission:project-planning.activities.time')
            ->name('activities.times.update');
        Route::delete('activities/{activity}/times/{time}', [ProjectActivityTimeController::class, 'destroy'])
            ->middleware('permission:project-planning.activities.time')
            ->name('activities.times.destroy');

        Route::get('activities/{activity}/tickets/create', [ProjectActivityTicketController::class, 'create'])
            ->middleware('permission:project-planning.activities.manage')
            ->name('activities.tickets.create');
        Route::post('activities/{activity}/tickets', [ProjectActivityTicketController::class, 'store'])
            ->middleware('permission:project-planning.activities.manage')
            ->name('activities.tickets.store');
        Route::delete('activities/{activity}/tickets/{ticket}', [ProjectActivityTicketController::class, 'destroy'])
            ->middleware('permission:project-planning.activities.manage')
            ->name('activities.tickets.destroy');
        Route::get('activities/{activity}/create-ticket/create', [ProjectActivityController::class, 'createTicketForm'])
            ->middleware('permission:tickets.create')
            ->name('activities.create-ticket.create');
        Route::post('activities/{activity}/create-ticket', [ProjectActivityController::class, 'createTicket'])
            ->middleware('permission:tickets.create')
            ->name('activities.create-ticket');
    });

    Route::prefix('development')->name('development.')->group(function () {
        Route::get('repositories', [RepositoryController::class, 'index'])
            ->middleware('permission:development.view|development.manage')
            ->name('repositories.index');
        Route::post('repositories', [RepositoryController::class, 'store'])
            ->middleware('permission:development.manage')
            ->name('repositories.store');
        Route::match(['put', 'patch'], 'repositories/{repository}', [RepositoryController::class, 'update'])
            ->middleware('permission:development.manage')
            ->name('repositories.update');
        Route::delete('repositories/{repository}', [RepositoryController::class, 'destroy'])
            ->middleware('permission:development.manage')
            ->name('repositories.destroy');

        Route::get('releases', [ReleaseController::class, 'index'])
            ->middleware('permission:development.releases.view|development.releases.manage')
            ->name('releases.index');
        Route::get('releases/create', [ReleaseController::class, 'create'])
            ->middleware('permission:development.releases.manage')
            ->name('releases.create');
        Route::post('releases', [ReleaseController::class, 'store'])
            ->middleware('permission:development.releases.manage')
            ->name('releases.store');
        Route::get('releases/{release}', [ReleaseController::class, 'show'])
            ->middleware('permission:development.releases.view|development.releases.manage')
            ->name('releases.show');
        Route::get('releases/{release}/edit', [ReleaseController::class, 'edit'])
            ->middleware('permission:development.releases.manage')
            ->name('releases.edit');
        Route::match(['put', 'patch'], 'releases/{release}', [ReleaseController::class, 'update'])
            ->middleware('permission:development.releases.manage')
            ->name('releases.update');
        Route::delete('releases/{release}', [ReleaseController::class, 'destroy'])
            ->middleware('permission:development.releases.manage')
            ->name('releases.destroy');
        Route::patch('releases/{release}/publish', [ReleaseController::class, 'publish'])
            ->middleware('permission:development.releases.manage')
            ->name('releases.publish');
        Route::post('releases/{release}/tickets', [ReleaseTicketController::class, 'store'])
            ->middleware('permission:development.releases.manage')
            ->name('releases.tickets.store');
        Route::delete('releases/{release}/tickets/{ticket}', [ReleaseTicketController::class, 'destroy'])
            ->middleware('permission:development.releases.manage')
            ->name('releases.tickets.destroy');
    });

    Route::prefix('quotes')->name('quotes.')->group(function () {
        Route::get('/', [QuoteController::class, 'index'])
            ->middleware('permission:quotes.view|quotes.manage')
            ->name('index');
        Route::get('create', [QuoteController::class, 'create'])
            ->middleware('permission:quotes.create')
            ->name('create');
        Route::post('/', [QuoteController::class, 'store'])
            ->middleware('permission:quotes.create')
            ->name('store');
        Route::get('{quote}', [QuoteController::class, 'show'])
            ->middleware('permission:quotes.view|quotes.manage')
            ->name('show');
        Route::get('{quote}/edit', [QuoteController::class, 'edit'])
            ->middleware('permission:quotes.manage')
            ->name('edit');
        Route::match(['put', 'patch'], '{quote}', [QuoteController::class, 'update'])
            ->middleware('permission:quotes.manage')
            ->name('update');
        Route::delete('{quote}', [QuoteController::class, 'destroy'])
            ->middleware('permission:quotes.delete')
            ->name('destroy');
        Route::patch('{quote}/cancel', [QuoteController::class, 'cancel'])
            ->middleware('permission:quotes.manage')
            ->name('cancel');
        Route::post('{quote}/items', [QuoteItemController::class, 'store'])
            ->middleware('permission:quotes.manage')
            ->name('items.store');
        Route::match(['put', 'patch'], '{quote}/items/{item}', [QuoteItemController::class, 'update'])
            ->middleware('permission:quotes.manage')
            ->name('items.update');
        Route::delete('{quote}/items/{item}', [QuoteItemController::class, 'destroy'])
            ->middleware('permission:quotes.manage')
            ->name('items.destroy');
        Route::patch('{quote}/approve-internal', [QuoteApprovalController::class, 'approveInternal'])
            ->middleware('permission:quotes.approve.internal')
            ->name('approve-internal');
        Route::patch('{quote}/approve-client', [QuoteApprovalController::class, 'approveClient'])
            ->middleware('permission:quotes.approve.client')
            ->name('approve-client');
        Route::patch('{quote}/reject-client', [QuoteApprovalController::class, 'rejectClient'])
            ->middleware('permission:quotes.approve.client')
            ->name('reject-client');
        Route::patch('{quote}/convert', [QuoteConversionController::class, 'convert'])
            ->middleware('permission:quotes.convert')
            ->name('convert');
    });

    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::get('dashboard', TicketDashboardController::class)
            ->middleware('permission:tickets.dashboard|tickets.reports|tickets.view')
            ->name('dashboard');

        Route::get('catalogos', TicketCatalogController::class)
            ->middleware('permission:tickets.catalogs|tickets.manage')
            ->name('catalogs');

        Route::get('sla', [TicketSlaController::class, 'index'])
            ->middleware('permission:tickets.sla.view|tickets.sla.manage')
            ->name('sla.index');
        Route::get('sla/configuracion', [TicketSlaController::class, 'settings'])
            ->middleware('permission:tickets.sla.manage')
            ->name('sla.settings');
        Route::match(['put', 'patch'], 'sla/politicas/{politica}', [TicketSlaController::class, 'updatePolicy'])
            ->middleware('permission:tickets.sla.manage')
            ->name('sla.policies.update');

        Route::get('triage', [TicketTriageController::class, 'index'])
            ->middleware('permission:tickets.triage|tickets.manage')
            ->name('triage.index');
        Route::get('qa', [TicketQaDashboardController::class, 'index'])
            ->middleware('permission:tickets.qa.view|tickets.qa.manage')
            ->name('qa.index');

        Route::get('/', [TicketController::class, 'index'])->middleware('permission:tickets.view')->name('index');
        Route::get('create', [TicketController::class, 'create'])->middleware('permission:tickets.create')->name('create');
        Route::post('/', [TicketController::class, 'store'])->middleware('permission:tickets.create')->name('store');
        Route::get('{ticket}/triage', [TicketTriageController::class, 'show'])
            ->middleware('permission:tickets.triage|tickets.manage')
            ->name('triage.show');
        Route::patch('{ticket}/triage/start', [TicketTriageController::class, 'start'])
            ->middleware('permission:tickets.triage|tickets.manage')
            ->name('triage.start');
        Route::patch('{ticket}/triage/complete', [TicketTriageController::class, 'complete'])
            ->middleware('permission:tickets.triage|tickets.manage')
            ->name('triage.complete');
        Route::patch('{ticket}/priority', [TicketPriorityController::class, 'update'])
            ->middleware('permission:tickets.prioritize|tickets.manage')
            ->name('priority.update');
        Route::post('{ticket}/checklist', [TicketChecklistController::class, 'store'])
            ->middleware('permission:tickets.triage|tickets.manage')
            ->name('checklist.store');
        Route::match(['put', 'patch'], '{ticket}/checklist/{item}', [TicketChecklistController::class, 'update'])
            ->middleware('permission:tickets.triage|tickets.manage')
            ->name('checklist.update');
        Route::delete('{ticket}/checklist/{item}', [TicketChecklistController::class, 'destroy'])
            ->middleware('permission:tickets.triage|tickets.manage')
            ->name('checklist.destroy');
        Route::post('{ticket}/relaciones', [TicketRelationController::class, 'store'])
            ->middleware('permission:tickets.manage')
            ->name('relations.store');
        Route::delete('{ticket}/relaciones/{relacion}', [TicketRelationController::class, 'destroy'])
            ->middleware('permission:tickets.manage')
            ->name('relations.destroy');
        Route::get('{ticket}/knowledge/create', [KnowledgeArticleController::class, 'createFromTicket'])
            ->middleware('permission:knowledge.create|tickets.manage')
            ->name('knowledge.create');
        Route::post('{ticket}/knowledge', [KnowledgeArticleController::class, 'storeFromTicket'])
            ->middleware('permission:knowledge.create|tickets.manage')
            ->name('knowledge.store');
        Route::post('{ticket}/knowledge/link', [TicketKnowledgeArticleController::class, 'store'])
            ->middleware('permission:knowledge.link|tickets.manage')
            ->name('knowledge.link');
        Route::delete('{ticket}/knowledge/{article}', [TicketKnowledgeArticleController::class, 'destroy'])
            ->middleware('permission:knowledge.link|tickets.manage')
            ->name('knowledge.unlink');
        Route::get('{ticket}/quote/create', [QuoteFromTicketController::class, 'create'])
            ->middleware('permission:tickets.quote|quotes.create')
            ->name('quote.create');
        Route::post('{ticket}/quote', [QuoteFromTicketController::class, 'store'])
            ->middleware('permission:tickets.quote|quotes.create')
            ->name('quote.store');
        Route::patch('{ticket}/quote/mark-required', [QuoteFromTicketController::class, 'markRequired'])
            ->middleware('permission:tickets.quote')
            ->name('quote.mark-required');
        Route::post('{ticket}/notifications/email', [TicketNotificationController::class, 'sendEmail'])
            ->middleware('permission:tickets.notifications.manage')
            ->name('notifications.email');
        Route::patch('{ticket}/billing-warning/acknowledge', [TicketBillingWarningController::class, 'acknowledge'])
            ->middleware('permission:tickets.manage')
            ->name('billing-warning.acknowledge');
        Route::get('{ticket}/ai', [TicketAiController::class, 'show'])
            ->middleware('permission:tickets.ai.view|tickets.ai')
            ->name('ai.show');
        Route::post('{ticket}/ai/analyze', [TicketAiController::class, 'analyze'])
            ->middleware('permission:tickets.ai.analyze|tickets.ai')
            ->name('ai.analyze');
        Route::get('{ticket}/ai/analyses/{analysis}', [TicketAiController::class, 'showAnalysis'])
            ->middleware('permission:tickets.ai.view|tickets.ai')
            ->name('ai.analysis.show');
        Route::patch('{ticket}/ai/analyses/{analysis}/apply', [TicketAiController::class, 'apply'])
            ->middleware('permission:tickets.ai.apply|tickets.ai')
            ->name('ai.analysis.apply');
        Route::patch('{ticket}/ai/analyses/{analysis}/reject', [TicketAiController::class, 'reject'])
            ->middleware('permission:tickets.ai.apply|tickets.ai')
            ->name('ai.analysis.reject');
        Route::patch('{ticket}/ai/actions/{action}/apply', [TicketAiActionController::class, 'apply'])
            ->middleware('permission:tickets.ai.apply|tickets.ai')
            ->name('ai.actions.apply');
        Route::patch('{ticket}/ai/actions/{action}/reject', [TicketAiActionController::class, 'reject'])
            ->middleware('permission:tickets.ai.apply|tickets.ai')
            ->name('ai.actions.reject');
        Route::get('{ticket}/tiempos', [TicketTimeController::class, 'index'])
            ->middleware('permission:tickets.time.view|tickets.time.manage')
            ->name('times.index');
        Route::post('{ticket}/tiempos', [TicketTimeController::class, 'store'])
            ->middleware('permission:tickets.time.manage')
            ->name('times.store');
        Route::match(['put', 'patch'], '{ticket}/tiempos/{tiempo}', [TicketTimeController::class, 'update'])
            ->middleware('permission:tickets.time.manage')
            ->name('times.update');
        Route::delete('{ticket}/tiempos/{tiempo}', [TicketTimeController::class, 'destroy'])
            ->middleware('permission:tickets.time.manage')
            ->name('times.destroy');
        Route::patch('{ticket}/sla/recalcular', [TicketSlaController::class, 'recalculate'])
            ->middleware('permission:tickets.sla.manage')
            ->name('sla.recalculate');
        Route::post('{ticket}/development/tasks', [TicketDevelopmentTaskController::class, 'store'])
            ->middleware('permission:tickets.development.manage|development.manage')
            ->name('development.tasks.store');
        Route::match(['put', 'patch'], '{ticket}/development/tasks/{task}', [TicketDevelopmentTaskController::class, 'update'])
            ->middleware('permission:tickets.development.manage|development.manage')
            ->name('development.tasks.update');
        Route::delete('{ticket}/development/tasks/{task}', [TicketDevelopmentTaskController::class, 'destroy'])
            ->middleware('permission:tickets.development.manage|development.manage')
            ->name('development.tasks.destroy');
        Route::patch('{ticket}/development/tasks/{task}/status', [TicketDevelopmentTaskController::class, 'changeStatus'])
            ->middleware('permission:tickets.development.manage|development.manage')
            ->name('development.tasks.status');
        Route::patch('{ticket}/development/tasks/{task}/review', [TicketDevelopmentTaskController::class, 'review'])
            ->middleware('permission:tickets.development.manage|development.manage')
            ->name('development.tasks.review');
        Route::post('{ticket}/development/links', [TicketDevelopmentLinkController::class, 'store'])
            ->middleware('permission:tickets.development.manage|development.manage')
            ->name('development.links.store');
        Route::delete('{ticket}/development/links/{link}', [TicketDevelopmentLinkController::class, 'destroy'])
            ->middleware('permission:tickets.development.manage|development.manage')
            ->name('development.links.destroy');
        Route::post('{ticket}/qa/test-cases', [TestCaseController::class, 'store'])
            ->middleware('permission:tickets.qa.manage')
            ->name('qa.test-cases.store');
        Route::match(['put', 'patch'], '{ticket}/qa/test-cases/{testCase}', [TestCaseController::class, 'update'])
            ->middleware('permission:tickets.qa.manage')
            ->name('qa.test-cases.update');
        Route::delete('{ticket}/qa/test-cases/{testCase}', [TestCaseController::class, 'destroy'])
            ->middleware('permission:tickets.qa.manage')
            ->name('qa.test-cases.destroy');
        Route::post('{ticket}/qa/test-cases/generate', [TestCaseController::class, 'generate'])
            ->middleware('permission:tickets.qa.manage')
            ->name('qa.test-cases.generate');
        Route::post('{ticket}/qa/test-results', [TicketTestResultController::class, 'store'])
            ->middleware('permission:tickets.qa.manage')
            ->name('qa.test-results.store');
        Route::match(['put', 'patch'], '{ticket}/qa/test-results/{result}', [TicketTestResultController::class, 'update'])
            ->middleware('permission:tickets.qa.manage')
            ->name('qa.test-results.update');
        Route::delete('{ticket}/qa/test-results/{result}', [TicketTestResultController::class, 'destroy'])
            ->middleware('permission:tickets.qa.manage')
            ->name('qa.test-results.destroy');
        Route::patch('{ticket}/qa/test-results/{result}/approve', [TicketTestResultController::class, 'markApproved'])
            ->middleware('permission:tickets.qa.approve|tickets.qa.manage')
            ->name('qa.test-results.approve');
        Route::patch('{ticket}/qa/test-results/{result}/fail', [TicketTestResultController::class, 'markFailed'])
            ->middleware('permission:tickets.qa.reject|tickets.qa.manage')
            ->name('qa.test-results.fail');
        Route::patch('{ticket}/qa/test-results/{result}/block', [TicketTestResultController::class, 'markBlocked'])
            ->middleware('permission:tickets.qa.reject|tickets.qa.manage')
            ->name('qa.test-results.block');
        Route::post('{ticket}/qa/evidences', [TicketTestEvidenceController::class, 'store'])
            ->middleware('permission:tickets.qa.evidence|tickets.qa.manage')
            ->name('qa.evidences.store');
        Route::delete('{ticket}/qa/evidences/{evidence}', [TicketTestEvidenceController::class, 'destroy'])
            ->middleware('permission:tickets.qa.evidence|tickets.qa.manage')
            ->name('qa.evidences.destroy');
        Route::post('{ticket}/qa/validations', [TicketValidationController::class, 'store'])
            ->middleware('permission:tickets.qa.manage')
            ->name('qa.validations.store');
        Route::patch('{ticket}/qa/validations/{validation}/approve', [TicketValidationController::class, 'approve'])
            ->middleware('permission:tickets.qa.approve|tickets.qa.manage')
            ->name('qa.validations.approve');
        Route::patch('{ticket}/qa/validations/{validation}/reject', [TicketValidationController::class, 'reject'])
            ->middleware('permission:tickets.qa.reject|tickets.qa.manage')
            ->name('qa.validations.reject');
        Route::get('{ticket}', [TicketController::class, 'show'])->middleware('permission:tickets.view')->name('show');
        Route::get('{ticket}/edit', [TicketController::class, 'edit'])->middleware('permission:tickets.manage')->name('edit');
        Route::match(['put', 'patch'], '{ticket}', [TicketController::class, 'update'])->middleware('permission:tickets.manage')->name('update');
        Route::delete('{ticket}', [TicketController::class, 'destroy'])->middleware('permission:tickets.manage')->name('destroy');

        Route::post('{ticket}/mensajes', [TicketMessageController::class, 'store'])
            ->middleware('permission:tickets.manage|tickets.view')
            ->name('messages.store');
        Route::post('{ticket}/adjuntos', [TicketAttachmentController::class, 'store'])
            ->middleware('permission:tickets.manage')
            ->name('attachments.store');
        Route::delete('{ticket}/adjuntos/{attachment}', [TicketAttachmentController::class, 'destroy'])
            ->middleware('permission:tickets.manage')
            ->name('attachments.destroy');
        Route::get('{ticket}/adjuntos/{attachment}/download', [TicketAttachmentController::class, 'download'])
            ->middleware('permission:tickets.view')
            ->name('attachments.download');
        Route::patch('{ticket}/asignar', [TicketAssignmentController::class, 'update'])
            ->middleware('permission:tickets.assign')
            ->name('assign');
        Route::patch('{ticket}/estado', [TicketStatusController::class, 'update'])
            ->middleware('permission:tickets.manage')
            ->name('status.update');
        Route::patch('{ticket}/cerrar', [TicketStatusController::class, 'close'])
            ->middleware('permission:tickets.close')
            ->name('close');
        Route::patch('{ticket}/reopen', [TicketStatusController::class, 'reopen'])
            ->middleware('permission:tickets.reopen|tickets.close')
            ->name('reopen');
    });

    Route::get('seguimientos/tipos', [SeguimientoController::class, 'tipos'])->name('seguimientos.tipos');
    Route::get('seguimientos', [SeguimientoController::class, 'index'])->name('seguimientos.index');


    Route::post('seguimientos', [SeguimientoController::class, 'store'])->name('seguimientos.store');
    Route::put('seguimientos/{seguimiento}', [SeguimientoController::class, 'update'])->name('seguimientos.update');
    Route::delete('seguimientos/{seguimiento}', [SeguimientoController::class, 'destroy'])->name('seguimientos.destroy');

});

Route::post('webhooks/github', [IncomingWebhookController::class, 'github'])->name('webhooks.github');
Route::post('webhooks/gitlab', [IncomingWebhookController::class, 'gitlab'])->name('webhooks.gitlab');
Route::post('webhooks/bitbucket', [IncomingWebhookController::class, 'bitbucket'])->name('webhooks.bitbucket');
Route::post('webhooks/custom/{integration}', [IncomingWebhookController::class, 'custom'])->name('webhooks.custom');


require __DIR__ . '/settings.php';
