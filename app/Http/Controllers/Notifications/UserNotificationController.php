<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Inertia\Inertia;
use Inertia\Response;

class UserNotificationController extends Controller
{
    public function index(Request $request): Response
    {
        $filters = $request->only(['status', 'module', 'level']);
        $query = $request->user()->notifications()->latest();

        $query
            ->when(($filters['status'] ?? null) === 'unread', fn ($notifications) => $notifications->whereNull('read_at'))
            ->when(($filters['status'] ?? null) === 'read', fn ($notifications) => $notifications->whereNotNull('read_at'))
            ->when($filters['module'] ?? null, fn ($notifications, $module) => $notifications->where('data->module', $module))
            ->when($filters['level'] ?? null, fn ($notifications, $level) => $notifications->where('data->level', $level));

        $allUserNotifications = $request->user()->notifications()->get(['data']);

        return Inertia::render('notifications/index', [
            'notifications' => $query
                ->paginate(15)
                ->withQueryString()
                ->through(fn (DatabaseNotification $notification): array => $this->serialize($notification)),
            'filters' => $filters,
            'modules' => $allUserNotifications
                ->pluck('data.module')
                ->filter()
                ->unique()
                ->values(),
            'levels' => $allUserNotifications
                ->pluck('data.level')
                ->filter()
                ->unique()
                ->values(),
        ]);
    }

    public function markAsRead(Request $request, string $notification): RedirectResponse
    {
        $this->findOwned($request, $notification)->markAsRead();

        return back()->with('success', 'Notificacion marcada como leida.');
    }

    public function markAsUnread(Request $request, string $notification): RedirectResponse
    {
        $this->findOwned($request, $notification)->markAsUnread();

        return back()->with('success', 'Notificacion marcada como no leida.');
    }

    public function markAllAsRead(Request $request): RedirectResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Todas las notificaciones fueron marcadas como leidas.');
    }

    public function destroy(Request $request, string $notification): RedirectResponse
    {
        $this->findOwned($request, $notification)->delete();

        return back()->with('success', 'Notificacion eliminada correctamente.');
    }

    private function findOwned(Request $request, string $notification): DatabaseNotification
    {
        return $request->user()
            ->notifications()
            ->whereKey($notification)
            ->firstOrFail();
    }

    private function serialize(DatabaseNotification $notification): array
    {
        return [
            'id' => $notification->id,
            'title' => data_get($notification->data, 'title', 'Notificacion'),
            'message' => data_get($notification->data, 'message', ''),
            'level' => data_get($notification->data, 'level', 'info'),
            'module' => data_get($notification->data, 'module', 'system'),
            'action_url' => data_get($notification->data, 'action_url'),
            'read_at' => $notification->read_at?->toISOString(),
            'created_at' => $notification->created_at?->toISOString(),
        ];
    }
}
