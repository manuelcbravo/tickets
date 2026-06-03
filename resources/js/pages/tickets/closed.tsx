import { Head, Link, router, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import { Eye, MoreHorizontal, RefreshCcw, Search, XCircle } from 'lucide-react';
import { useEffect, useState } from 'react';
import { route } from 'ziggy-js';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { ModuleHeader } from '@/components/module-header';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, CatalogOption, ClientOption, ProjectOption, UserOption, SharedData } from '@/types';

type ClosedTicketRow = {
    id: string;
    folio: string;
    titulo: string;
    closed_at: string | null;
    resolution: string | null;
    cliente?: { nombre: string | null; razon_social: string | null } | null;
    proyecto?: { nombre: string } | null;
    responsable?: { name: string } | null;
    cerrado_por?: { name: string } | null;
    estado?: { id: number; nombre: string } | null;
    tipo?: { id: number; nombre: string } | null;
};

type PaginatedTickets = {
    data: ClosedTicketRow[];
    links: { url: string | null; label: string; active: boolean }[];
    from: number | null;
    to: number | null;
    total: number;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Tickets', href: route('tickets.index') },
    { title: 'Tickets cerrados', href: route('tickets.closed') },
];

export default function TicketsClosed({
    tickets,
    filters,
    clientes,
    proyectos,
    tipos,
    users,
}: {
    tickets: PaginatedTickets;
    filters: Record<string, string | null>;
    clientes: ClientOption[];
    proyectos: ProjectOption[];
    tipos: CatalogOption[];
    users: UserOption[];
}) {
    const { flash, auth } = usePage<SharedData>().props;
    const permissions = auth.permissions ?? [];
    const canReopen = permissions.includes('tickets.reopen') || permissions.includes('tickets.close');

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const [localFilters, setLocalFilters] = useState({
        search: filters.search ?? '',
        cliente_id: filters.cliente_id ?? 'todos',
        proyecto_id: filters.proyecto_id ?? 'todos',
        responsable_id: filters.responsable_id ?? 'todos',
        tipo_id: filters.tipo_id ?? 'todos',
    });

    const applyFilters = () => {
        router.get(route('tickets.closed'), normalizeFilters(localFilters), { preserveState: true, preserveScroll: true });
    };

    const columns: DataTableColumn<ClosedTicketRow>[] = [
        { key: 'folio', header: 'Folio', accessor: (row) => row.folio, cell: (row) => <Link className="font-medium text-primary hover:underline" href={route('tickets.show', row.id)}>{row.folio}</Link> },
        { key: 'cliente', header: 'Cliente', cell: (row) => row.cliente?.nombre ?? row.cliente?.razon_social ?? '-' },
        { key: 'proyecto', header: 'Proyecto', cell: (row) => row.proyecto?.nombre ?? '-' },
        { key: 'titulo', header: 'Titulo', accessor: (row) => row.titulo, cell: (row) => row.titulo },
        { key: 'tipo', header: 'Tipo', cell: (row) => row.tipo?.nombre ?? '-' },
        { key: 'estado', header: 'Estado', cell: (row) => <Badge variant="outline">{row.estado?.nombre ?? '-'}</Badge> },
        { key: 'responsable', header: 'Responsable', cell: (row) => row.responsable?.name ?? '-' },
        { key: 'cerrado_por', header: 'Cerrado por', cell: (row) => row.cerrado_por?.name ?? '-' },
        { key: 'closed_at', header: 'Fecha cierre', cell: (row) => row.closed_at ? new Date(row.closed_at).toLocaleString('es-MX') : '-' },
        { key: 'resolution', header: 'Resolucion', cell: (row) => row.resolution ? <span className="text-xs text-muted-foreground line-clamp-2">{row.resolution}</span> : <span className="text-xs text-muted-foreground">-</span> },
        {
            key: 'actions',
            header: 'Acciones',
            className: 'w-16',
            cell: (row) => (
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <Button variant="ghost" size="icon" className="size-8"><MoreHorizontal className="size-4" /></Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuItem asChild><Link href={route('tickets.show', row.id)}><Eye className="mr-2 size-4" /> Ver detalle</Link></DropdownMenuItem>
                        {canReopen && (
                            <DropdownMenuItem asChild><Link href={route('tickets.show', row.id)}><RefreshCcw className="mr-2 size-4" /> Reabrir</Link></DropdownMenuItem>
                        )}
                    </DropdownMenuContent>
                </DropdownMenu>
            ),
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Tickets cerrados" />
            <div className="space-y-4 rounded-xl p-4">
                <ModuleHeader title="Tickets cerrados" description="Historial de tickets que han sido cerrados. Puedes consultar la resolucion o reabrirlos si es necesario." />

                <div className="grid gap-3 md:grid-cols-4 xl:grid-cols-6">
                    <Input className="md:col-span-2" value={localFilters.search} onChange={(e) => setLocalFilters({ ...localFilters, search: e.target.value })} placeholder="Folio, titulo o descripcion..." />
                    <FilterSelect value={localFilters.cliente_id} onChange={(v) => setLocalFilters({ ...localFilters, cliente_id: v })} options={clientes.map((c) => ({ value: c.id, label: c.nombre ?? c.razon_social ?? c.id }))} placeholder="Cliente" />
                    <FilterSelect value={localFilters.proyecto_id} onChange={(v) => setLocalFilters({ ...localFilters, proyecto_id: v })} options={proyectos.map((p) => ({ value: p.id, label: p.nombre }))} placeholder="Proyecto" />
                    <FilterSelect value={localFilters.tipo_id} onChange={(v) => setLocalFilters({ ...localFilters, tipo_id: v })} options={tipos.map((t) => ({ value: String(t.id), label: t.nombre }))} placeholder="Tipo" />
                    <FilterSelect value={localFilters.responsable_id} onChange={(v) => setLocalFilters({ ...localFilters, responsable_id: v })} options={users.map((u) => ({ value: String(u.id), label: u.name }))} placeholder="Responsable" />
                    <div className="flex gap-2">
                        <Button type="button" onClick={applyFilters}><Search className="size-4" /> Filtrar</Button>
                        <Button type="button" variant="outline" onClick={() => router.get(route('tickets.closed'))}><XCircle className="size-4" /> Limpiar</Button>
                    </div>
                </div>

                <DataTable columns={columns} data={tickets.data} showSearch={false} emptyMessage="No hay tickets cerrados con los filtros actuales." />

                <div className="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <p className="text-sm text-muted-foreground">Mostrando {tickets.from ?? 0}-{tickets.to ?? 0} de {tickets.total}</p>
                    <div className="flex flex-wrap gap-1">
                        {tickets.links.map((link, index) => (
                            <Button key={`${link.label}-${index}`} variant={link.active ? 'default' : 'outline'} size="sm" disabled={!link.url} onClick={() => link.url && router.get(link.url, {}, { preserveScroll: true })}>
                                <span dangerouslySetInnerHTML={{ __html: link.label }} />
                            </Button>
                        ))}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}

function normalizeFilters(filters: Record<string, string>) {
    return Object.fromEntries(Object.entries(filters).filter(([, value]) => value !== '' && value !== 'todos'));
}

function FilterSelect({ value, onChange, options, placeholder }: { value: string; onChange: (value: string) => void; options: { value: string; label: string }[]; placeholder: string }) {
    return (
        <Select value={value} onValueChange={onChange}>
            <SelectTrigger className="w-full"><SelectValue placeholder={placeholder} /></SelectTrigger>
            <SelectContent>
                <SelectItem value="todos">Todos</SelectItem>
                {options.map((option) => <SelectItem key={option.value} value={option.value}>{option.label}</SelectItem>)}
            </SelectContent>
        </Select>
    );
}
