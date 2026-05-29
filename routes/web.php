<?php

use App\Http\Controllers\Config\AuditController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Admin\WhatsAppController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Config\RoleController;
use App\Http\Controllers\Config\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\SeguimientoController;
use App\Services\WhatsAppService;

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

    Route::resource('clients', ClientController::class)->only(['index', 'store', 'destroy']);
    Route::resource('files', FileController::class)->only(['index', 'store', 'destroy']);

    Route::get('seguimientos/tipos', [SeguimientoController::class, 'tipos'])->name('seguimientos.tipos');
    Route::get('seguimientos', [SeguimientoController::class, 'index'])->name('seguimientos.index');


    Route::post('seguimientos', [SeguimientoController::class, 'store'])->name('seguimientos.store');
    Route::put('seguimientos/{seguimiento}', [SeguimientoController::class, 'update'])->name('seguimientos.update');
    Route::delete('seguimientos/{seguimiento}', [SeguimientoController::class, 'destroy'])->name('seguimientos.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('whatsapp', [WhatsAppController::class, 'index'])->name('whatsapp.index');
        Route::get('whatsapp/status', [WhatsAppController::class, 'status'])->name('whatsapp.status');
        Route::post('whatsapp/disconnect', [WhatsAppController::class, 'disconnect'])->name('whatsapp.disconnect');
        Route::post('whatsapp/reconnect', [WhatsAppController::class, 'reconnect'])->name('whatsapp.reconnect');
        Route::post('whatsapp/qr', [WhatsAppController::class, 'qr'])->name('whatsapp.qr');
    });

});

Route::get('/test-whatsapp', function (WhatsAppService $whatsAppService) {
    $result = $whatsAppService->sendText(
        '5217711615578',
        'Hola, este mensaje salió desde Laravel'
    );

    return response()->json($result);
});

require __DIR__ . '/settings.php';
