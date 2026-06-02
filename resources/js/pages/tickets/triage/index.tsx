import { Head, Link, router, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import { Eye, Play, Search, XCircle } from 'lucide-react';
import { route } from 'ziggy-js';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { ModuleHeader } from '@/components/module-header';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, CatalogOption, ClientOption, ProjectOption, SharedData, TicketOptionProps, UserOption } from '@/types';
import { useEffect, useState } from 'react';

type TicketRow = {
    id: string;
    folio: string;
    titulo: string;
    created_at: string;
    cliente?: { nombre: string | null; razon_social: string | null } | null;
    proyecto?: { nombre: string } | null;
    responsable?: { name: string } | null;
    estado?: { nombre: string } | null;
    prioridad?: { nombre: string } | null;
    tipo?: { nombre: string } | null;
};

type PaginatedTickets = {
    data: TicketRow[];
    links: { url: string | null; label: string; active: boolean }[];
    from: number | null;
    to: number | null;
    total: number;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Tickets', href: route('tickets.dashboard') },
    { title: 'Triage', href: route('tickets.triage.index') },
];

export default function TicketTriageIndex({
    tickets,
    filters,
    clientes,
    proyectos,
    estados,
    prioridades,
    tipos,
    users,
}: Pick<TicketOptionProps, 'clientes' | 'proyectos' | 'estados' | 'prioridades' | 'tipos' | 'users'> & {
    tickets: PaginatedTickets;
    filters: Record<string, string | null>;
}) {
    const { flash } = usePage<SharedData>().props;

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const [localFilters, setLocalFilters] = useState({
        search: filters.search ?? '',
        cliente_id: filters.cliente_id ?? 'todos',
        proyecto_id: filters.proyecto_id ?? 'todos',
        estado_id: filters.estado_id ?? 'todos',
        prioridad_id: filters.prioridad_id ?? 'todos',
        responsable_id: filters.responsable_id ?? 'todos',
        tipo_id: filters.tipo_id ?? 'todos',
    });

    const columns: DataTableColumn<TicketRow>[] = [
        { key: 'folio', header: 'Folio', cell: (row) => <Link className="font-medium text-primary hover:underline" href={route('tickets.triage.show', row.id)}>{row.folio}</Link> },
        { key: 'titulo', header: 'Titulo', accessor: (row) => row.titulo, cell: (row) => row.titulo },
        { key: 'cliente', header: 'Cliente', cell: (row) => row.cliente?.nombre ?? row.cliente?.razon_social ?? '-' },
        { key: 'proyecto', header: 'Proyecto', cell: (row) => row.proyecto?.nombre ?? '-' },
        { key: 'estado', header: 'Estado', cell: (row) => <Badge variant="outline">{row.estado?.nombre ?? '-'}</Badge> },
        { key: 'prioridad', header: 'Prioridad actual', cell: (row) => <Badge variant={row.prioridad?.nombre?.startsWith('P0') ? 'destructive' : 'secondary'}>{row.prioridad?.nombre ?? '-'}</Badge> },
        { key: 'tipo', header: 'Tipo', cell: (row) => row.tipo?.nombre ?? '-' },
        { key: 'responsable', header: 'Responsable', cell: (row) => row.responsable?.name ?? '-' },
        { key: 'created_at', header: 'Creado', cell: (row) => new Date(row.created_at).toLocaleDateString('es-MX') },
        { key: 'age', header: 'Antiguedad', cell: (row) => `${Math.max(0, Math.floor((Date.now() - new Date(row.created_at).getTime()) / 86400000))} dias` },
        {
            key: 'actions',
            header: 'Acciones',
            className: 'w-40',
            cell: (row) => (
                <div className="flex gap-2">
                    <Button size="sm" variant="outline" onClick={() => router.patch(route('tickets.triage.start', row.id))}>
                        <Play className="size-4" /> Iniciar
                    </Button>
                    <Button asChild size="sm">
                        <Link href={route('tickets.triage.show', row.id)}><Eye className="size-4" /> Continuar</Link>
                    </Button>
                </div>
            ),
        },
    ];

    const applyFilters = () => {
        router.get(route('tickets.triage.index'), normalizeFilters(localFilters), { preserveState: true, preserveScroll: true });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Tickets - Triage" />
            <div className="space-y-4 rounded-xl p-4">
                <ModuleHeader title="Triage" description="Clasifica tickets nuevos antes de que lleguen al equipo tecnico. Aqui se define tipo, impacto, urgencia, riesgo, prioridad, faltantes y siguiente paso." />

                <div className="grid gap-3 md:grid-cols-4 xl:grid-cols-7">
                    <Input className="md:col-span-2" value={localFilters.search} onChange={(event) => setLocalFilters({ ...localFilters, search: event.target.value })} placeholder="Folio o titulo..." />
                    <FilterSelect value={localFilters.cliente_id} onChange={(value) => setLocalFilters({ ...localFilters, cliente_id: value })} options={toClientOptions(clientes)} placeholder="Cliente" />
                    <FilterSelect value={localFilters.proyecto_id} onChange={(value) => setLocalFilters({ ...localFilters, proyecto_id: value })} options={toProjectOptions(proyectos)} placeholder="Proyecto" />
                    <FilterSelect value={localFilters.estado_id} onChange={(value) => setLocalFilters({ ...localFilters, estado_id: value })} options={toCatalogOptions(estados)} placeholder="Estado" />
                    <FilterSelect value={localFilters.prioridad_id} onChange={(value) => setLocalFilters({ ...localFilters, prioridad_id: value })} options={toCatalogOptions(prioridades)} placeholder="Prioridad" />
                    <FilterSelect value={localFilters.tipo_id} onChange={(value) => setLocalFilters({ ...localFilters, tipo_id: value })} options={toCatalogOptions(tipos)} placeholder="Tipo" />
                    <FilterSelect value={localFilters.responsable_id} onChange={(value) => setLocalFilters({ ...localFilters, responsable_id: value })} options={toUserOptions(users)} placeholder="Responsable" />
                    <div className="flex gap-2">
                        <Button type="button" onClick={applyFilters}><Search className="size-4" /> Filtrar</Button>
                        <Button type="button" variant="outline" onClick={() => router.get(route('tickets.triage.index'))}><XCircle className="size-4" /> Limpiar</Button>
                    </div>
                </div>

                <DataTable columns={columns} data={tickets.data} showSearch={false} emptyMessage="No hay tickets pendientes de triage." />

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

const toCatalogOptions = (items: CatalogOption[]) => items.map((item) => ({ value: String(item.id), label: item.nombre }));
const toClientOptions = (items: ClientOption[]) => items.map((item) => ({ value: item.id, label: item.nombre ?? item.razon_social ?? item.id }));
const toProjectOptions = (items: ProjectOption[]) => items.map((item) => ({ value: item.id, label: item.nombre }));
const toUserOptions = (items: UserOption[]) => items.map((item) => ({ value: String(item.id), label: item.name }));
