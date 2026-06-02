import { Head, Link, router, usePage } from '@inertiajs/react';
import { Bell, CheckCheck, Eye, MailCheck, MailOpen, Trash2, XCircle } from 'lucide-react';
import { useEffect, useState } from 'react';
import { toast } from 'sonner';
import { route } from 'ziggy-js';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type NotificationRow = {
    id: string;
    title: string;
    message: string;
    level: string;
    module: string;
    action_url?: string | null;
    read_at?: string | null;
    created_at?: string | null;
};

type Paginated<T> = {
    data: T[];
    links: { url: string | null; label: string; active: boolean }[];
    from: number | null;
    to: number | null;
    total: number;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Mis notificaciones', href: route('notifications.index') },
];

export default function NotificationsIndex({
    notifications,
    filters,
    modules,
    levels,
}: {
    notifications: Paginated<NotificationRow>;
    filters: Record<string, string | null>;
    modules: string[];
    levels: string[];
}) {
    const { flash } = usePage<SharedData>().props;
    const [localFilters, setLocalFilters] = useState({
        status: filters.status ?? 'all',
        module: filters.module ?? 'all',
        level: filters.level ?? 'all',
    });

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const columns: DataTableColumn<NotificationRow>[] = [
        {
            key: 'title',
            header: 'Titulo',
            cell: (row) => (
                <div className="min-w-64">
                    <p className="font-medium">{row.title}</p>
                    <p className="line-clamp-2 text-sm text-muted-foreground">
                        {row.message}
                    </p>
                </div>
            ),
        },
        {
            key: 'module',
            header: 'Modulo',
            cell: (row) => <Badge variant="outline">{row.module}</Badge>,
        },
        {
            key: 'level',
            header: 'Nivel',
            cell: (row) => <LevelBadge level={row.level} />,
        },
        {
            key: 'created_at',
            header: 'Fecha',
            cell: (row) => formatDate(row.created_at),
        },
        {
            key: 'read_at',
            header: 'Estado',
            cell: (row) => (
                <Badge variant={row.read_at ? 'secondary' : 'default'}>
                    {row.read_at ? 'Leida' : 'No leida'}
                </Badge>
            ),
        },
        {
            key: 'actions',
            header: 'Acciones',
            cell: (row) => (
                <div className="flex flex-wrap gap-1">
                    <Button
                        variant="ghost"
                        size="sm"
                        onClick={() => openNotification(row)}
                    >
                        <Eye className="size-4" /> Abrir
                    </Button>
                    {row.read_at ? (
                        <Button
                            variant="ghost"
                            size="sm"
                            onClick={() =>
                                router.patch(
                                    route('notifications.unread', row.id),
                                    {},
                                    { preserveScroll: true },
                                )
                            }
                        >
                            <MailOpen className="size-4" />
                        </Button>
                    ) : (
                        <Button
                            variant="ghost"
                            size="sm"
                            onClick={() =>
                                router.patch(
                                    route('notifications.read', row.id),
                                    {},
                                    { preserveScroll: true },
                                )
                            }
                        >
                            <MailCheck className="size-4" />
                        </Button>
                    )}
                    <Button
                        variant="ghost"
                        size="sm"
                        onClick={() =>
                            router.delete(route('notifications.destroy', row.id), {
                                preserveScroll: true,
                            })
                        }
                    >
                        <Trash2 className="size-4" />
                    </Button>
                </div>
            ),
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Mis notificaciones" />
            <div className="space-y-4 p-4">
                <section className="rounded-xl border bg-sidebar-accent/20 p-4">
                    <div className="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <h1 className="text-xl font-semibold">
                                Mis notificaciones
                            </h1>
                            <p className="text-sm text-muted-foreground">
                                Consulta los avisos relacionados con tickets,
                                actividades, pagos y eventos importantes del
                                sistema.
                            </p>
                        </div>
                        <Button
                            variant="outline"
                            onClick={() =>
                                router.patch(
                                    route('notifications.read-all'),
                                    {},
                                    { preserveScroll: true },
                                )
                            }
                        >
                            <CheckCheck className="size-4" /> Marcar todas
                        </Button>
                    </div>
                </section>

                <Card className="rounded-lg">
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2">
                            <Bell className="size-5" /> Como activar las
                            notificaciones
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p className="text-sm text-muted-foreground">
                            Las notificaciones internas se generan
                            automaticamente cuando se te asigna un ticket o una
                            actividad. Si el sistema tiene notificaciones en
                            tiempo real configuradas, la campana se actualizara
                            al momento. Si no, veras los avisos al cambiar de
                            pantalla o recargar. Para recibir correos de
                            cobranza, verifica que el correo del sistema este
                            configurado correctamente.
                        </p>
                        <p className="mt-3 text-sm text-muted-foreground">
                            Para revisar pagos proximos a vencer manualmente:
                            <code className="ml-2 rounded bg-muted px-2 py-1">
                                php artisan
                                notifications:check-project-payments-due
                            </code>
                        </p>
                    </CardContent>
                </Card>

                <div className="grid gap-3 md:grid-cols-[220px_220px_220px_auto]">
                    <Filter
                        value={localFilters.status}
                        onChange={(value) =>
                            setLocalFilters({ ...localFilters, status: value })
                        }
                        options={[
                            { value: 'all', label: 'Todas' },
                            { value: 'unread', label: 'No leidas' },
                            { value: 'read', label: 'Leidas' },
                        ]}
                    />
                    <Filter
                        value={localFilters.module}
                        onChange={(value) =>
                            setLocalFilters({ ...localFilters, module: value })
                        }
                        options={[
                            { value: 'all', label: 'Todos los modulos' },
                            ...modules.map((module) => ({
                                value: module,
                                label: module,
                            })),
                        ]}
                    />
                    <Filter
                        value={localFilters.level}
                        onChange={(value) =>
                            setLocalFilters({ ...localFilters, level: value })
                        }
                        options={[
                            { value: 'all', label: 'Todos los niveles' },
                            ...levels.map((level) => ({
                                value: level,
                                label: level,
                            })),
                        ]}
                    />
                    <div className="flex gap-2">
                        <Button
                            onClick={() =>
                                router.get(
                                    route('notifications.index'),
                                    normalize(localFilters),
                                    { preserveState: true },
                                )
                            }
                        >
                            Filtrar
                        </Button>
                        <Button
                            variant="outline"
                            onClick={() => router.get(route('notifications.index'))}
                        >
                            <XCircle className="size-4" />
                        </Button>
                    </div>
                </div>

                <Card className="rounded-lg">
                    <CardHeader>
                        <CardTitle>Listado</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <DataTable
                            columns={columns}
                            data={notifications.data}
                            showSearch={false}
                            emptyMessage="No hay notificaciones con los filtros actuales."
                        />
                        <Pagination page={notifications} />
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}

function openNotification(notification: NotificationRow) {
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
}

function Filter({
    value,
    onChange,
    options,
}: {
    value: string;
    onChange: (value: string) => void;
    options: { value: string; label: string }[];
}) {
    return (
        <Select value={value} onValueChange={onChange}>
            <SelectTrigger>
                <SelectValue />
            </SelectTrigger>
            <SelectContent>
                {options.map((option) => (
                    <SelectItem key={option.value} value={option.value}>
                        {option.label}
                    </SelectItem>
                ))}
            </SelectContent>
        </Select>
    );
}

function Pagination<T>({ page }: { page: Paginated<T> }) {
    return (
        <div className="mt-4 flex flex-wrap items-center justify-between gap-2">
            <p className="text-sm text-muted-foreground">
                Mostrando {page.from ?? 0}-{page.to ?? 0} de {page.total}
            </p>
            <div className="flex flex-wrap gap-1">
                {page.links.map((link, index) => (
                    <Button
                        key={`${link.label}-${index}`}
                        variant={link.active ? 'default' : 'outline'}
                        size="sm"
                        disabled={!link.url}
                        onClick={() =>
                            link.url && router.get(link.url, {}, { preserveScroll: true })
                        }
                    >
                        <span dangerouslySetInnerHTML={{ __html: link.label }} />
                    </Button>
                ))}
            </div>
        </div>
    );
}

function LevelBadge({ level }: { level: string }) {
    return (
        <Badge
            variant={
                level === 'warning'
                    ? 'destructive'
                    : level === 'info'
                      ? 'outline'
                      : 'secondary'
            }
        >
            {level}
        </Badge>
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

function normalize(filters: Record<string, string>): Record<string, string> {
    return Object.fromEntries(
        Object.entries(filters).filter(([, value]) => value !== 'all' && value !== ''),
    );
}
