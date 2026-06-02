<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Schema;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        $recentNotifications = [];
        $unreadNotificationsCount = 0;

        if ($user && Schema::hasTable('notifications')) {
            $unreadNotificationsCount = $user->unreadNotifications()->count();
            $recentNotifications = $user->notifications()
                ->latest()
                ->limit(5)
                ->get()
                ->map(fn (DatabaseNotification $notification): array => [
                    'id' => $notification->id,
                    'title' => data_get($notification->data, 'title', 'Notificacion'),
                    'message' => data_get($notification->data, 'message', ''),
                    'level' => data_get($notification->data, 'level', 'info'),
                    'module' => data_get($notification->data, 'module', 'system'),
                    'action_url' => data_get($notification->data, 'action_url'),
                    'read_at' => $notification->read_at?->toISOString(),
                    'created_at' => $notification->created_at?->toISOString(),
                ])
                ->values();
        }

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $user ? [
                    ...$user->toArray(),
                    'unread_notifications_count' => $unreadNotificationsCount,
                    'recent_notifications' => $recentNotifications,
                ] : null,
                'permissions' => $user?->getAllPermissions()->pluck('name'),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
        ];
    }
}
