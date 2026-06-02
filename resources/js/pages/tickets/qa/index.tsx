import { Head, Link, router, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import { Eye, Search, XCircle } from 'lucide-react';
import { useEffect, useState } from 'react';
import { route } from 'ziggy-js';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { ModuleHeader } from '@/components/module-header';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, CatalogOption, ClientOption, ProjectOption, SharedData, UserOption } from '@/types';

type QaTicketRow = {
    id: string;
    folio: string;
    titulo: string;
    qa_status: string | null;
    has_code_changes: boolean;
    requires_code_change: boolean;
    reopen_count: number;
    approved_tests_count: number;
    failed_tests_count: number;
    evidences_count: number;
    cliente?: { nombre: string | null; razon_social: string | null } | null;
    proyecto?: { nombre: string | null } | null;
    estado?: { nombre: string | null } | null;
    prioridad?: { id: number; nombre: string | null } | null;
    tipo?: { id: number; nombre: string | null } | null;
    responsable?: { name: string | null } | null;
};

type PaginatedTickets = {
    data: QaTicketRow[];
    links: { url: string | null; label: string; active: boolean }[];
    from: number | null;
    to: number | null;
    total: number;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Tickets', href: route('tickets.dashboard') },
    { title: 'QA', href: route('tickets.qa.index') },
];

const qaStatuses = ['pendiente', 'en_pruebas', 'aprobado', 'rechazado', 'bloqueado', 'no_requiere'];

export default function TicketsQaIndex({
    tickets,
    filters,
    clientes,
    proyectos,
    prioridades,
    tipos,
    users,
}: {
    tickets: PaginatedTickets;
    filters: Record<string, string | null>;
    clientes: ClientOption[];
    proyectos: ProjectOption[];
    prioridades: CatalogOption[];
    tipos: CatalogOption[];
    users: UserOption[];
}) {
    const { flash } = usePage<SharedData>().props;

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const [localFilters, setLocalFilters] = useState({
        qa_status: filters.qa_status ?? 'todos',
        cliente_id: filters.cliente_id ?? 'todos',
        proyecto_id: filters.proyecto_id ?? 'todos',
        responsable_id: filters.responsable_id ?? 'todos',
        prioridad_id: filters.prioridad_id ?? 'todos',
        tipo_id: filters.tipo_id ?? 'todos',
        with_code: filters.with_code ? '1' : 'todos',
        reopened: filters.reopened ? '1' : 'todos',
    });

    const applyFilters = () => {
        router.get(route('tickets.qa.index'), normalizeFilters(localFilters), { preserveScroll: true, preserveState: true });
    };

    const columns: DataTableColumn<QaTicketRow>[] = [
        { key: 'folio', header: 'Folio', cell: (row) => <Link className="font-medium text-primary hover:underline" href={route('tickets.show', row.id)}>{row.folio}</Link> },
        { key: 'titulo', header: 'Titulo', accessor: (row) => row.titulo, cell: (row) => row.titulo },
        { key: 'cliente', header: 'Cliente', cell: (row) => row.cliente?.nombre ?? row.cliente?.razon_social ?? '-' },
        { key: 'proyecto', header: 'Proyecto', cell: (row) => row.proyecto?.nombre ?? '-' },
        { key: 'estado', header: 'Estado ticket', cell: (row) => <Badge variant="outline">{row.estado?.nombre ?? '-'}</Badge> },
        { key: 'qa_status', header: 'Estado QA', cell: (row) => <Badge variant={qaStatusVariant(row.qa_status)}>{row.qa_status ?? 'pendiente'}</Badge> },
        { key: 'code', header: 'Cambios de codigo', cell: (row) => <Badge variant={row.has_code_changes || row.requires_code_change ? 'secondary' : 'outline'}>{row.has_code_changes || row.requires_code_change ? 'Si' : 'No'}</Badge> },
        { key: 'approved', header: 'Aprobadas', cell: (row) => row.approved_tests_count },
        { key: 'failed', header: 'Fallidas', cell: (row) => row.failed_tests_count },
        { key: 'evidence', header: 'Evidencias', cell: (row) => row.evidences_count },
        { key: 'reopen', header: 'Reaperturas', cell: (row) => row.reopen_count },
        {
            key: 'actions',
            header: 'Acciones',
            className: 'w-24',
            cell: (row) => <Button asChild variant="outline" size="sm"><Link href={route('tickets.show', row.id)}><Eye className="size-4" /> Ver</Link></Button>,
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="QA de tickets" />
            <div className="space-y-4 rounded-xl p-4">
                <ModuleHeader title="QA" description="Valida que los cambios esten probados antes de cerrar tickets. Aqui se registran casos de prueba, evidencias, aprobaciones, rechazos y reaperturas." />

                <div className="grid gap-3 md:grid-cols-4 xl:grid-cols-8">
                    <FilterSelect value={localFilters.qa_status} onChange={(value) => setLocalFilters({ ...localFilters, qa_status: value })} options={qaStatuses.map((status) => ({ value: status, label: status }))} placeholder="Estado QA" />
                    <FilterSelect value={localFilters.cliente_id} onChange={(value) => setLocalFilters({ ...localFilters, cliente_id: value })} options={clientes.map((cliente) => ({ value: cliente.id, label: cliente.nombre ?? cliente.razon_social ?? cliente.id }))} placeholder="Cliente" />
                    <FilterSelect value={localFilters.proyecto_id} onChange={(value) => setLocalFilters({ ...localFilters, proyecto_id: value })} options={proyectos.map((proyecto) => ({ value: proyecto.id, label: proyecto.nombre }))} placeholder="Proyecto" />
                    <FilterSelect value={localFilters.responsable_id} onChange={(value) => setLocalFilters({ ...localFilters, responsable_id: value })} options={users.map((user) => ({ value: String(user.id), label: user.name }))} placeholder="Responsable" />
                    <FilterSelect value={localFilters.prioridad_id} onChange={(value) => setLocalFilters({ ...localFilters, prioridad_id: value })} options={prioridades.map((item) => ({ value: String(item.id), label: item.nombre }))} placeholder="Prioridad" />
                    <FilterSelect value={localFilters.tipo_id} onChange={(value) => setLocalFilters({ ...localFilters, tipo_id: value })} options={tipos.map((item) => ({ value: String(item.id), label: item.nombre }))} placeholder="Tipo" />
                    <FilterSelect value={localFilters.with_code} onChange={(value) => setLocalFilters({ ...localFilters, with_code: value })} options={[{ value: '1', label: 'Con cambios' }]} placeholder="Codigo" />
                    <FilterSelect value={localFilters.reopened} onChange={(value) => setLocalFilters({ ...localFilters, reopened: value })} options={[{ value: '1', label: 'Reabiertos' }]} placeholder="Reaperturas" />
                    <div className="flex gap-2 md:col-span-2">
                        <Button type="button" onClick={applyFilters}><Search className="size-4" /> Filtrar</Button>
                        <Button type="button" variant="outline" onClick={() => router.get(route('tickets.qa.index'))}><XCircle className="size-4" /> Limpiar</Button>
                    </div>
                </div>

                <DataTable columns={columns} data={tickets.data} showSearch={false} emptyMessage="No hay tickets con los filtros actuales." />

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

function qaStatusVariant(status?: string | null): 'default' | 'secondary' | 'destructive' | 'outline' {
    if (status === 'rechazado' || status === 'fallido' || status === 'bloqueado') return 'destructive';
    if (status === 'aprobado' || status === 'no_requiere') return 'default';
    if (status === 'en_pruebas') return 'secondary';
    return 'outline';
}
