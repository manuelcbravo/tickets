import { Head, Link, router, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import { useEffect } from 'react';
import { Eye } from 'lucide-react';
import { route } from 'ziggy-js';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type LogRow = {
    id: string;
    channel: string;
    direction: string;
    recipient: string | null;
    subject: string | null;
    status: string;
    sent_at: string | null;
    error_message: string | null;
    ticket?: { id: string; folio: string; titulo: string } | null;
    cliente?: { nombre?: string | null; razon_social?: string | null } | null;
};

type Page<T> = { data: T[]; links: { url: string | null; label: string; active: boolean }[]; from: number | null; to: number | null; total: number };

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Notificaciones', href: route('notifications.logs.index') }];

export default function NotificationLogsIndex({ logs }: { logs: Page<LogRow> }) {
    const { flash } = usePage<SharedData>().props;

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const columns: DataTableColumn<LogRow>[] = [
        { key: 'channel', header: 'Canal', cell: (row) => <Badge variant="outline">{row.channel}</Badge> },
        { key: 'direction', header: 'Direccion', cell: (row) => row.direction },
        { key: 'ticket', header: 'Ticket', cell: (row) => row.ticket ? <Link className="text-primary hover:underline" href={route('tickets.show', row.ticket.id)}>{row.ticket.folio}</Link> : '-' },
        { key: 'cliente', header: 'Cliente', cell: (row) => row.cliente?.nombre ?? row.cliente?.razon_social ?? '-' },
        { key: 'recipient', header: 'Destinatario', cell: (row) => row.recipient ?? '-' },
        { key: 'subject', header: 'Asunto', cell: (row) => row.subject ?? '-' },
        { key: 'status', header: 'Estado', cell: (row) => <Badge variant={row.status === 'failed' ? 'destructive' : row.status === 'sent' ? 'default' : 'secondary'}>{row.status}</Badge> },
        { key: 'sent_at', header: 'Enviado', cell: (row) => row.sent_at ? new Date(row.sent_at).toLocaleString('es-MX') : '-' },
        { key: 'actions', header: 'Acciones', cell: (row) => <Button asChild variant="ghost" size="sm"><Link href={route('notifications.logs.show', row.id)}><Eye className="size-4" /> Ver</Link></Button> },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Notificaciones" />
            <div className="space-y-4 rounded-xl p-4">
                <div><h1 className="text-xl font-semibold">Historial de notificaciones</h1><p className="text-sm text-muted-foreground">Registro de comunicaciones internas y salientes.</p></div>
                <Card className="rounded-lg"><CardHeader><CardTitle>Logs</CardTitle></CardHeader><CardContent><DataTable columns={columns} data={logs.data} showSearch={false} /><Pagination page={logs} /></CardContent></Card>
            </div>
        </AppLayout>
    );
}

function Pagination<T>({ page }: { page: Page<T> }) {
    return <div className="mt-4 flex flex-wrap items-center justify-between gap-2"><p className="text-sm text-muted-foreground">Mostrando {page.from ?? 0}-{page.to ?? 0} de {page.total}</p><div className="flex flex-wrap gap-1">{page.links.map((link, index) => <Button key={`${link.label}-${index}`} variant={link.active ? 'default' : 'outline'} size="sm" disabled={!link.url} onClick={() => link.url && router.get(link.url, {}, { preserveScroll: true })}><span dangerouslySetInnerHTML={{ __html: link.label }} /></Button>)}</div></div>;
}
