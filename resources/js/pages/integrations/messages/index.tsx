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

type MessageRow = {
    id: string;
    channel: string;
    direction: string;
    sender: string | null;
    recipient: string | null;
    message: string | null;
    created_at: string;
    ticket?: { id: string; folio: string; titulo: string } | null;
};

type Page<T> = { data: T[]; links: { url: string | null; label: string; active: boolean }[]; from: number | null; to: number | null; total: number };

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Mensajes externos', href: route('integrations.messages.index') }];

export default function ExternalMessagesIndex({ messages }: { messages: Page<MessageRow> }) {
    const { flash } = usePage<SharedData>().props;

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const columns: DataTableColumn<MessageRow>[] = [
        { key: 'channel', header: 'Canal', cell: (row) => <Badge variant="outline">{row.channel}</Badge> },
        { key: 'direction', header: 'Direccion', cell: (row) => row.direction },
        { key: 'sender', header: 'Remitente', cell: (row) => row.sender ?? '-' },
        { key: 'recipient', header: 'Destinatario', cell: (row) => row.recipient ?? '-' },
        { key: 'message', header: 'Mensaje', cell: (row) => <span className="line-clamp-2">{row.message ?? '-'}</span> },
        { key: 'ticket', header: 'Ticket', cell: (row) => row.ticket ? <Link className="text-primary hover:underline" href={route('tickets.show', row.ticket.id)}>{row.ticket.folio}</Link> : '-' },
        { key: 'created_at', header: 'Fecha', cell: (row) => new Date(row.created_at).toLocaleString('es-MX') },
        { key: 'actions', header: 'Acciones', cell: (row) => <Button asChild variant="ghost" size="sm"><Link href={route('integrations.messages.show', row.id)}><Eye className="size-4" /> Ver</Link></Button> },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Mensajes externos" />
            <div className="space-y-4 rounded-xl p-4">
                <div><h1 className="text-xl font-semibold">Mensajes externos</h1><p className="text-sm text-muted-foreground">Mensajes registrados para vinculacion manual con tickets.</p></div>
                <Card className="rounded-lg"><CardHeader><CardTitle>Mensajes</CardTitle></CardHeader><CardContent><DataTable columns={columns} data={messages.data} showSearch={false} /><Pagination page={messages} /></CardContent></Card>
            </div>
        </AppLayout>
    );
}

function Pagination<T>({ page }: { page: Page<T> }) {
    return <div className="mt-4 flex flex-wrap items-center justify-between gap-2"><p className="text-sm text-muted-foreground">Mostrando {page.from ?? 0}-{page.to ?? 0} de {page.total}</p><div className="flex flex-wrap gap-1">{page.links.map((link, index) => <Button key={`${link.label}-${index}`} variant={link.active ? 'default' : 'outline'} size="sm" disabled={!link.url} onClick={() => link.url && router.get(link.url, {}, { preserveScroll: true })}><span dangerouslySetInnerHTML={{ __html: link.label }} /></Button>)}</div></div>;
}
