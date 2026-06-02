import { Link, router, usePage } from '@inertiajs/react';
import { Bell, CheckCheck, Circle, ExternalLink, Inbox } from 'lucide-react';
import { route } from 'ziggy-js';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import type { SharedData, UserNotificationSummary } from '@/types';

export function NotificationBell() {
    const { auth } = usePage<SharedData>().props;
    const notifications = auth.user.recent_notifications ?? [];
    const unreadCount = auth.user.unread_notifications_count ?? 0;

    const openNotification = (notification: UserNotificationSummary) => {
        const target = notification.action_url ?? route('notifications.index');

        if (notification.read_at) {
            router.visit(target);
            return;
        }

        router.patch(
            route('notifications.read', notification.id),
            {},
            {
                preserveScroll: true,
                onSuccess: () => router.visit(target),
            },
        );
    };

    return (
        <DropdownMenu>
            <DropdownMenuTrigger asChild>
                <Button
                    variant="ghost"
                    size="icon"
                    className="relative size-9"
                    aria-label="Notificaciones"
                >
                    <Bell className="size-5" />
                    {unreadCount > 0 && (
                        <span className="absolute -top-1 -right-1 min-w-5 rounded-full bg-destructive px-1.5 text-[10px] leading-5 font-semibold text-white">
                            {unreadCount > 99 ? '99+' : unreadCount}
                        </span>
                    )}
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end" className="w-96 max-w-[calc(100vw-2rem)]">
                <div className="flex items-center justify-between gap-2 px-2 py-1.5">
                    <DropdownMenuLabel className="px-0 py-0">
                        Notificaciones
                    </DropdownMenuLabel>
                    {unreadCount > 0 && (
                        <Button
                            variant="ghost"
                            size="sm"
                            className="h-8 px-2"
                            onClick={() =>
                                router.patch(
                                    route('notifications.read-all'),
                                    {},
                                    { preserveScroll: true },
                                )
                            }
                        >
                            <CheckCheck className="size-4" />
                        </Button>
                    )}
                </div>
                <DropdownMenuSeparator />

                <div className="max-h-96 overflow-y-auto">
                    {notifications.length === 0 ? (
                        <div className="flex flex-col items-center gap-2 px-4 py-8 text-center text-sm text-muted-foreground">
                            <Inbox className="size-8" />
                            <span>No hay notificaciones recientes.</span>
                        </div>
                    ) : (
                        notifications.map((notification) => (
                            <DropdownMenuItem
                                key={notification.id}
                                className="items-start gap-3 py-3"
                                onSelect={(event) => {
                                    event.preventDefault();
                                    openNotification(notification);
                                }}
                            >
                                <Circle
                                    className={
                                        notification.read_at
                                            ? 'mt-1 size-2 fill-transparent text-muted-foreground'
                                            : 'mt-1 size-2 fill-primary text-primary'
                                    }
                                />
                                <div className="min-w-0 flex-1 space-y-1">
                                    <div className="flex items-center gap-2">
                                        <p className="truncate text-sm font-medium">
                                            {notification.title}
                                        </p>
                                        <Badge
                                            variant="outline"
                                            className="shrink-0 text-[10px]"
                                        >
                                            {notification.module}
                                        </Badge>
                                    </div>
                                    <p className="line-clamp-2 text-xs text-muted-foreground">
                                        {notification.message}
                                    </p>
                                    <p className="text-[11px] text-muted-foreground">
                                        {formatDate(notification.created_at)}
                                    </p>
                                </div>
                                <ExternalLink className="mt-1 size-4 text-muted-foreground" />
                            </DropdownMenuItem>
                        ))
                    )}
                </div>

                <DropdownMenuSeparator />
                <DropdownMenuItem asChild>
                    <Link href={route('notifications.index')}>
                        <Inbox className="mr-2 size-4" /> Ver todas
                    </Link>
                </DropdownMenuItem>
            </DropdownMenuContent>
        </DropdownMenu>
    );
}

function formatDate(value?: string | null): string {
    if (!value) return '-';

    const date = new Date(value);
    if (Number.isNaN(date.getTime())) return '-';

    return new Intl.DateTimeFormat('es-MX', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: true,
    }).format(date);
}
