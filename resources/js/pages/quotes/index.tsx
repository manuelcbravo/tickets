import { Head, Link, router, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import { CheckCircle2, CircleDollarSign, Eye, ListChecks, MoreHorizontal, Pencil, Plus, Search, Ticket, UsersRound, XCircle } from 'lucide-react';
import { useEffect, useState } from 'react';
import { route } from 'ziggy-js';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { ModuleHeader } from '@/components/module-header';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, ClientOption, ProjectOption, SharedData } from '@/types';

type QuoteRow = {
    id: string;
    folio: string;
    titulo: string;
    estado: string;
    total: string | number;
    created_at: string;
    aprobada_internamente_at: string | null;
    aprobada_cliente_at: string | null;
    cliente?: { nombre?: string | null; razon_social?: string | null } | null;
    proyecto?: { nombre?: string | null } | null;
};

type PaginatedQuotes = {
    data: QuoteRow[];
    links: { url: string | null; label: string; active: boolean }[];
    from: number | null;
    to: number | null;
    total: number;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Cotizaciones', href: route('quotes.index') },
];

export default function QuotesIndex({
    quotes,
    filters,
    clientes,
    proyectos,
    estados,
}: {
    quotes: PaginatedQuotes;
    filters: Record<string, string | null>;
    clientes: ClientOption[];
    proyectos: ProjectOption[];
    estados: string[];
}) {
    const { flash } = usePage<SharedData>().props;

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const permissions = usePage<SharedData>().props.auth.permissions ?? [];
    const canCreate = permissions.includes('quotes.create');
    const canManage = permissions.includes('quotes.manage');
    const canApproveInternal = permissions.includes('quotes.approve.internal');
    const canApproveClient = permissions.includes('quotes.approve.client');
    const canConvert = permissions.includes('quotes.convert');
    const [localFilters, setLocalFilters] = useState({
        search: filters.search ?? '',
        cliente_id: filters.cliente_id ?? 'todos',
        proyecto_id: filters.proyecto_id ?? 'todos',
        estado: filters.estado ?? 'todos',
    });

    const columns: DataTableColumn<QuoteRow>[] = [
        { key: 'folio', header: 'Folio', cell: (row) => <Link className="font-medium text-primary hover:underline" href={route('quotes.show', row.id)}>{row.folio}</Link> },
        { key: 'titulo', header: 'Titulo', cell: (row) => row.titulo },
        { key: 'cliente', header: 'Cliente', cell: (row) => row.cliente?.nombre ?? row.cliente?.razon_social ?? '-' },
        { key: 'proyecto', header: 'Proyecto', cell: (row) => row.proyecto?.nombre ?? '-' },
        { key: 'estado', header: 'Estado', cell: (row) => <Badge variant={quoteStatusVariant(row.estado)}>{labelize(row.estado)}</Badge> },
        { key: 'total', header: 'Total', cell: (row) => formatCurrency(row.total) },
        { key: 'created_at', header: 'Creada', cell: (row) => new Date(row.created_at).toLocaleDateString('es-MX') },
        { key: 'internal', header: 'Aprob. interna', cell: (row) => row.aprobada_internamente_at ? <Badge variant="secondary">Aprobada</Badge> : <Badge variant="outline">Pendiente</Badge> },
        { key: 'client', header: 'Aprob. cliente', cell: (row) => row.aprobada_cliente_at ? <Badge>Aprobada</Badge> : <Badge variant="outline">Pendiente</Badge> },
        {
            key: 'actions',
            header: 'Acciones',
            className: 'w-20',
            cell: (row) => {
                const quoteDetail = route('quotes.show', row.id);

                return (
                    <DropdownMenu>
                        <DropdownMenuTrigger asChild><Button variant="ghost" size="icon" className="size-8"><MoreHorizontal className="size-4" /></Button></DropdownMenuTrigger>
                        <DropdownMenuContent align="end">
                            <DropdownMenuItem asChild><Link href={quoteDetail}><Eye className="mr-2 size-4" /> Ver resumen</Link></DropdownMenuItem>
                            {canManage && row.estado !== 'convertida' && <DropdownMenuItem asChild><Link href={route('quotes.edit', row.id)}><Pencil className="mr-2 size-4" /> Editar</Link></DropdownMenuItem>}
                            <DropdownMenuSeparator />
                            <DropdownMenuItem asChild><Link href={`${quoteDetail}#partidas`}><ListChecks className="mr-2 size-4" /> Partidas</Link></DropdownMenuItem>
                            <DropdownMenuItem asChild><Link href={`${quoteDetail}#aprobaciones`}><UsersRound className="mr-2 size-4" /> Aprobaciones</Link></DropdownMenuItem>
                            <DropdownMenuItem asChild><Link href={`${quoteDetail}#tickets-relacionados`}><Ticket className="mr-2 size-4" /> Tickets relacionados</Link></DropdownMenuItem>
                            {(canApproveInternal || canApproveClient || canConvert || canManage) && <DropdownMenuSeparator />}
                            {canApproveInternal && row.estado === 'borrador' && <DropdownMenuItem onClick={() => router.patch(route('quotes.approve-internal', row.id), {}, { preserveScroll: true })}><CheckCircle2 className="mr-2 size-4" /> Aprobar interna</DropdownMenuItem>}
                            {canApproveClient && ['aprobada_internamente', 'enviada'].includes(row.estado) && <DropdownMenuItem onClick={() => router.patch(route('quotes.approve-client', row.id), {}, { preserveScroll: true })}><CheckCircle2 className="mr-2 size-4" /> Aprobar cliente</DropdownMenuItem>}
                            {canConvert && row.estado === 'aprobada_cliente' && <DropdownMenuItem onClick={() => router.patch(route('quotes.convert', row.id), { create_single_ticket: true }, { preserveScroll: true })}><CircleDollarSign className="mr-2 size-4" /> Convertir</DropdownMenuItem>}
                            {canManage && !['cancelada', 'convertida'].includes(row.estado) && <DropdownMenuItem asChild><Link href={quoteDetail}><XCircle className="mr-2 size-4" /> Cancelar</Link></DropdownMenuItem>}
                        </DropdownMenuContent>
                    </DropdownMenu>
                );
            },
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Cotizaciones" />
            <div className="space-y-4 rounded-xl p-4">
                <ModuleHeader title="Cotizaciones" description="Controla solicitudes fuera de alcance y conviertelas en propuestas comerciales con partidas, costos, aprobaciones y tickets de ejecucion.">
                    {canCreate && <Button asChild><Link href={route('quotes.create')}><Plus className="size-4" /> Nueva cotizacion</Link></Button>}
                </ModuleHeader>

                <div className="grid gap-3 md:grid-cols-5">
                    <Input className="md:col-span-2" value={localFilters.search} onChange={(event) => setLocalFilters({ ...localFilters, search: event.target.value })} placeholder="Folio, titulo o cliente..." />
                    <FilterSelect value={localFilters.cliente_id} onChange={(value) => setLocalFilters({ ...localFilters, cliente_id: value })} options={clientes.map((item) => ({ value: item.id, label: item.nombre ?? item.razon_social ?? item.id }))} placeholder="Cliente" />
                    <FilterSelect value={localFilters.proyecto_id} onChange={(value) => setLocalFilters({ ...localFilters, proyecto_id: value })} options={proyectos.map((item) => ({ value: item.id, label: item.nombre }))} placeholder="Proyecto" />
                    <FilterSelect value={localFilters.estado} onChange={(value) => setLocalFilters({ ...localFilters, estado: value })} options={estados.map((item) => ({ value: item, label: labelize(item) }))} placeholder="Estado" />
                    <div className="flex gap-2 md:col-span-5">
                        <Button type="button" onClick={() => router.get(route('quotes.index'), normalizeFilters(localFilters), { preserveState: true, preserveScroll: true })}><Search className="size-4" /> Filtrar</Button>
                        <Button type="button" variant="outline" onClick={() => router.get(route('quotes.index'))}><XCircle className="size-4" /> Limpiar</Button>
                    </div>
                </div>

                <Card className="rounded-lg">
                    <CardHeader>
                        <CardTitle>Listado</CardTitle>
                        <CardDescription>Cotizaciones comerciales y de alcance.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <DataTable columns={columns} data={quotes.data} showSearch={false} emptyMessage="No hay cotizaciones con los filtros actuales." />
                        <div className="mt-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                            <p className="text-sm text-muted-foreground">Mostrando {quotes.from ?? 0}-{quotes.to ?? 0} de {quotes.total}</p>
                            <div className="flex flex-wrap gap-1">
                                {quotes.links.map((link, index) => (
                                    <Button key={`${link.label}-${index}`} variant={link.active ? 'default' : 'outline'} size="sm" disabled={!link.url} onClick={() => link.url && router.get(link.url, {}, { preserveScroll: true })}>
                                        <span dangerouslySetInnerHTML={{ __html: link.label }} />
                                    </Button>
                                ))}
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
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

function normalizeFilters(filters: Record<string, string>) {
    return Object.fromEntries(Object.entries(filters).filter(([, value]) => value !== '' && value !== 'todos'));
}

function quoteStatusVariant(status: string) {
    if (['aprobada_cliente', 'convertida'].includes(status)) return 'default';
    if (['rechazada_cliente', 'cancelada'].includes(status)) return 'destructive';
    if (['aprobada_internamente', 'enviada'].includes(status)) return 'secondary';
    return 'outline';
}

const labelize = (value: string) => value.replaceAll('_', ' ');
const formatCurrency = (value: string | number) => new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(Number(value ?? 0));
