import { Head, Link, router, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import { Eye, Search, XCircle } from 'lucide-react';
import { useEffect, useState } from 'react';
import { route } from 'ziggy-js';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type EventRow = {
    id: string;
    provider: string;
    event_type: string | null;
    external_id: string | null;
    status: string;
    processed_at: string | null;
    created_at: string;
    ticket?: { id: string; folio: string; titulo: string } | null;
};

type Page<T> = { data: T[]; links: { url: string | null; label: string; active: boolean }[]; from: number | null; to: number | null; total: number };

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Webhooks', href: route('integrations.webhooks.index') }];

export default function WebhookEventsIndex({ events, filters, statuses }: { events: Page<EventRow>; filters: Record<string, string | null>; statuses: string[] }) {
    const { flash } = usePage<SharedData>().props;

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const [localFilters, setLocalFilters] = useState({
        provider: filters.provider ?? '',
        event_type: filters.event_type ?? '',
        status: filters.status ?? 'todos',
        linked: filters.linked ?? 'todos',
    });
    const columns: DataTableColumn<EventRow>[] = [
        { key: 'provider', header: 'Proveedor', cell: (row) => <Badge variant="outline">{row.provider}</Badge> },
        { key: 'event_type', header: 'Evento', cell: (row) => row.event_type ?? '-' },
        { key: 'status', header: 'Estado', cell: (row) => <Badge variant={row.status === 'failed' ? 'destructive' : row.status === 'linked' ? 'default' : 'secondary'}>{row.status}</Badge> },
        { key: 'ticket', header: 'Ticket', cell: (row) => row.ticket ? <Link className="text-primary hover:underline" href={route('tickets.show', row.ticket.id)}>{row.ticket.folio}</Link> : '-' },
        { key: 'external_id', header: 'External ID', cell: (row) => row.external_id ?? '-' },
        { key: 'created_at', header: 'Recibido', cell: (row) => new Date(row.created_at).toLocaleString('es-MX') },
        { key: 'actions', header: 'Acciones', cell: (row) => <Button asChild variant="ghost" size="sm"><Link href={route('integrations.webhooks.show', row.id)}><Eye className="size-4" /> Ver</Link></Button> },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Webhooks" />
            <div className="space-y-4 rounded-xl p-4">
                <div><h1 className="text-xl font-semibold">Eventos webhook</h1><p className="text-sm text-muted-foreground">Eventos recibidos sin ejecutar acciones destructivas.</p></div>
                <div className="grid gap-3 md:grid-cols-5">
                    <Input value={localFilters.provider} onChange={(event) => setLocalFilters({ ...localFilters, provider: event.target.value })} placeholder="Proveedor" />
                    <Input value={localFilters.event_type} onChange={(event) => setLocalFilters({ ...localFilters, event_type: event.target.value })} placeholder="Tipo evento" />
                    <FilterSelect value={localFilters.status} onChange={(value) => setLocalFilters({ ...localFilters, status: value })} options={statuses.map((status) => ({ value: status, label: status }))} placeholder="Estado" />
                    <FilterSelect value={localFilters.linked} onChange={(value) => setLocalFilters({ ...localFilters, linked: value })} options={[{ value: 'yes', label: 'Con ticket' }, { value: 'no', label: 'Sin ticket' }]} placeholder="Vinculo" />
                    <div className="flex gap-2"><Button onClick={() => router.get(route('integrations.webhooks.index'), normalizeFilters(localFilters), { preserveState: true })}><Search className="size-4" /> Filtrar</Button><Button variant="outline" onClick={() => router.get(route('integrations.webhooks.index'))}><XCircle className="size-4" /></Button></div>
                </div>
                <Card className="rounded-lg"><CardHeader><CardTitle>Eventos</CardTitle></CardHeader><CardContent><DataTable columns={columns} data={events.data} showSearch={false} /><Pagination page={events} /></CardContent></Card>
            </div>
        </AppLayout>
    );
}

function FilterSelect({ value, onChange, options, placeholder }: { value: string; onChange: (value: string) => void; options: { value: string; label: string }[]; placeholder: string }) {
    return <Select value={value} onValueChange={onChange}><SelectTrigger><SelectValue placeholder={placeholder} /></SelectTrigger><SelectContent><SelectItem value="todos">Todos</SelectItem>{options.map((option) => <SelectItem key={option.value} value={option.value}>{option.label}</SelectItem>)}</SelectContent></Select>;
}

function Pagination<T>({ page }: { page: Page<T> }) {
    return <div className="mt-4 flex flex-wrap items-center justify-between gap-2"><p className="text-sm text-muted-foreground">Mostrando {page.from ?? 0}-{page.to ?? 0} de {page.total}</p><div className="flex flex-wrap gap-1">{page.links.map((link, index) => <Button key={`${link.label}-${index}`} variant={link.active ? 'default' : 'outline'} size="sm" disabled={!link.url} onClick={() => link.url && router.get(link.url, {}, { preserveScroll: true })}><span dangerouslySetInnerHTML={{ __html: link.label }} /></Button>)}</div></div>;
}

function normalizeFilters(filters: Record<string, string>) {
    return Object.fromEntries(Object.entries(filters).filter(([, value]) => value !== '' && value !== 'todos'));
}
