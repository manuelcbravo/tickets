import { Head, Link, router, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import {
    Bot,
    BookOpen,
    Clock,
    Code2,
    Eye,
    FileText,
    History,
    MessageSquare,
    MoreHorizontal,
    Paperclip,
    Pencil,
    Plug,
    Plus,
    RefreshCcw,
    Search,
    ShieldCheck,
    Stethoscope,
    Trash2,
    XCircle,
} from 'lucide-react';
import { useEffect, useState } from 'react';
import { route } from 'ziggy-js';
import { ConfirmDeleteDialog } from '@/components/confirm-delete-dialog';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { ModuleHeader } from '@/components/module-header';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, CatalogOption, ClientOption, ProjectOption, TicketOptionProps, UserOption, SharedData } from '@/types';

type TicketRow = {
    id: string;
    folio: string;
    titulo: string;
    descripcion: string;
    fecha_objetivo: string | null;
    tiempo_real_min: number;
    created_at: string;
    cliente?: { nombre: string | null; razon_social: string | null } | null;
    proyecto?: { nombre: string } | null;
    responsable?: { name: string } | null;
    estado?: { id: number; nombre: string } | null;
    prioridad?: { id: number; nombre: string } | null;
    tipo?: { id: number; nombre: string } | null;
    sla?: { estado_sla: string; vence_resolucion_at: string | null } | null;
};

type PaginatedTickets = {
    data: TicketRow[];
    links: { url: string | null; label: string; active: boolean }[];
    from: number | null;
    to: number | null;
    total: number;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Tickets', href: route('tickets.index') },
    { title: 'Lista de tickets', href: route('tickets.index') },
];

export default function TicketsIndex({
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

    const [deleteTarget, setDeleteTarget] = useState<TicketRow | null>(null);
    const [localFilters, setLocalFilters] = useState({
        search: filters.search ?? '',
        cliente_id: filters.cliente_id ?? 'todos',
        proyecto_id: filters.proyecto_id ?? 'todos',
        estado_id: filters.estado_id ?? 'todos',
        prioridad_id: filters.prioridad_id ?? 'todos',
        responsable_id: filters.responsable_id ?? 'todos',
        tipo_id: filters.tipo_id ?? 'todos',
        quick_filter: filters.quick_filter ?? 'todos',
    });
    const permissions = usePage<SharedData>().props.auth.permissions ?? [];
    const canCreate = permissions.includes('tickets.create');
    const canManage = permissions.includes('tickets.manage');
    const canTriage = permissions.includes('tickets.triage') || permissions.includes('tickets.manage');
    const canViewSla = permissions.includes('tickets.sla.view') || permissions.includes('tickets.sla.manage');
    const canViewTime = permissions.includes('tickets.time.view') || permissions.includes('tickets.time.manage');
    const canViewKnowledge = permissions.includes('knowledge.view') || permissions.includes('knowledge.manage');
    const canViewAi = permissions.includes('tickets.ai') || permissions.includes('tickets.ai.view');
    const canViewDevelopment = permissions.some((permission) => ['tickets.development.view', 'tickets.development.manage', 'development.view', 'development.manage'].includes(permission));
    const canViewQa = permissions.includes('tickets.qa.view') || permissions.includes('tickets.qa.manage');
    const canQuote = permissions.includes('tickets.quote') || permissions.includes('quotes.create') || permissions.includes('quotes.manage');
    const canViewIntegrations = permissions.includes('integrations.view') || permissions.includes('integrations.manage');
    const canClose = permissions.includes('tickets.close');
    const canReopen = permissions.includes('tickets.reopen') || permissions.includes('tickets.close');

    const applyFilters = () => {
        router.get(route('tickets.index'), normalizeFilters(localFilters), { preserveState: true, preserveScroll: true });
    };

    const columns: DataTableColumn<TicketRow>[] = [
        { key: 'folio', header: 'Folio', accessor: (row) => row.folio, cell: (row) => <Link className="font-medium text-primary hover:underline" href={route('tickets.show', row.id)}>{row.folio}</Link> },
        { key: 'cliente', header: 'Cliente', cell: (row) => row.cliente?.nombre ?? row.cliente?.razon_social ?? '-' },
        { key: 'proyecto', header: 'Proyecto', cell: (row) => row.proyecto?.nombre ?? '-' },
        { key: 'titulo', header: 'Titulo', accessor: (row) => row.titulo, cell: (row) => row.titulo },
        { key: 'tipo', header: 'Tipo', cell: (row) => row.tipo?.nombre ?? '-' },
        { key: 'estado', header: 'Estado', cell: (row) => <Badge variant="outline">{row.estado?.nombre ?? '-'}</Badge> },
        { key: 'prioridad', header: 'Prioridad', cell: (row) => <Badge variant={row.prioridad?.nombre?.startsWith('P0') ? 'destructive' : 'secondary'}>{row.prioridad?.nombre ?? '-'}</Badge> },
        { key: 'responsable', header: 'Responsable', cell: (row) => row.responsable?.name ?? '-' },
        { key: 'fecha_objetivo', header: 'Fecha objetivo', cell: (row) => row.fecha_objetivo ? new Date(row.fecha_objetivo).toLocaleString('es-MX') : '-' },
        { key: 'sla', header: 'Estado SLA', cell: (row) => row.sla ? <Badge variant={slaVariant(row.sla.estado_sla)}>{row.sla.estado_sla}</Badge> : '-' },
        { key: 'vence_resolucion', header: 'Vence resolucion', cell: (row) => row.sla?.vence_resolucion_at ? new Date(row.sla.vence_resolucion_at).toLocaleString('es-MX') : '-' },
        { key: 'tiempo_real', header: 'Tiempo real', cell: (row) => formatMinutes(row.tiempo_real_min ?? 0) },
        { key: 'created_at', header: 'Creado', cell: (row) => new Date(row.created_at).toLocaleDateString('es-MX') },
        {
            key: 'actions',
            header: 'Acciones',
            className: 'w-24',
            cell: (row) => {
                const ticketDetail = route('tickets.show', row.id);
                const status = row.estado?.nombre.toLowerCase() ?? '';
                const isClosed = ['cerrado', 'resuelto'].includes(status);

                return (
                    <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                            <Button variant="ghost" size="icon" className="size-8"><MoreHorizontal className="size-4" /></Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end">
                            <DropdownMenuItem asChild><Link href={ticketDetail}><Eye className="mr-2 size-4" /> Ver resumen</Link></DropdownMenuItem>
                            {canManage && <DropdownMenuItem asChild><Link href={route('tickets.edit', row.id)}><Pencil className="mr-2 size-4" /> Editar</Link></DropdownMenuItem>}
                            <DropdownMenuSeparator />
                            <DropdownMenuItem asChild><Link href={`${ticketDetail}#comentarios`}><MessageSquare className="mr-2 size-4" /> Comentarios</Link></DropdownMenuItem>
                            <DropdownMenuItem asChild><Link href={`${ticketDetail}#adjuntos`}><Paperclip className="mr-2 size-4" /> Adjuntos</Link></DropdownMenuItem>
                            <DropdownMenuItem asChild><Link href={`${ticketDetail}#historial`}><History className="mr-2 size-4" /> Historial</Link></DropdownMenuItem>
                            {canViewTime && <DropdownMenuItem asChild><Link href={`${ticketDetail}#tiempos`}><Clock className="mr-2 size-4" /> Tiempos</Link></DropdownMenuItem>}
                            {canViewKnowledge && <DropdownMenuItem asChild><Link href={`${ticketDetail}#base-conocimiento`}><BookOpen className="mr-2 size-4" /> Base de conocimiento</Link></DropdownMenuItem>}
                            {canViewAi && <DropdownMenuItem asChild><Link href={route('tickets.ai.show', row.id)}><Bot className="mr-2 size-4" /> IA</Link></DropdownMenuItem>}
                            {canViewDevelopment && <DropdownMenuItem asChild><Link href={`${ticketDetail}#desarrollo`}><Code2 className="mr-2 size-4" /> Desarrollo</Link></DropdownMenuItem>}
                            {canViewIntegrations && <DropdownMenuItem asChild><Link href={`${ticketDetail}#integraciones`}><Plug className="mr-2 size-4" /> Integraciones</Link></DropdownMenuItem>}
                            {(canClose || canReopen || canManage) && <DropdownMenuSeparator />}
                            {canClose && !isClosed && <DropdownMenuItem asChild><Link href={ticketDetail}><XCircle className="mr-2 size-4" /> Cerrar</Link></DropdownMenuItem>}
                            {canReopen && isClosed && <DropdownMenuItem asChild><Link href={ticketDetail}><RefreshCcw className="mr-2 size-4" /> Reabrir</Link></DropdownMenuItem>}
                            {canManage && <DropdownMenuItem variant="destructive" onClick={() => setDeleteTarget(row)}><Trash2 className="mr-2 size-4" /> Eliminar</DropdownMenuItem>}
                        </DropdownMenuContent>
                    </DropdownMenu>
                );
            },
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Tickets" />
            <div className="space-y-4 rounded-xl p-4">
                <ModuleHeader title="Tickets" description="Centraliza solicitudes, bugs, soporte, mejoras y nuevos desarrollos. Desde aqui puedes dar seguimiento, asignar responsables, registrar evidencia, medir tiempos y cerrar solicitudes con historial completo.">
                    {canCreate && <Button asChild><Link href={route('tickets.create')}><Plus className="size-4" /> Nuevo ticket</Link></Button>}
                </ModuleHeader>

                <div className="grid gap-3 md:grid-cols-4 xl:grid-cols-7">
                    <Input className="md:col-span-2" value={localFilters.search} onChange={(event) => setLocalFilters({ ...localFilters, search: event.target.value })} placeholder="Folio, titulo o descripcion..." />
                    <FilterSelect value={localFilters.cliente_id} onChange={(value) => setLocalFilters({ ...localFilters, cliente_id: value })} options={toClientOptions(clientes)} placeholder="Cliente" />
                    <FilterSelect value={localFilters.proyecto_id} onChange={(value) => setLocalFilters({ ...localFilters, proyecto_id: value })} options={toProjectOptions(proyectos)} placeholder="Proyecto" />
                    <FilterSelect value={localFilters.estado_id} onChange={(value) => setLocalFilters({ ...localFilters, estado_id: value })} options={toCatalogOptions(estados)} placeholder="Estado" />
                    <FilterSelect value={localFilters.prioridad_id} onChange={(value) => setLocalFilters({ ...localFilters, prioridad_id: value })} options={toCatalogOptions(prioridades)} placeholder="Prioridad" />
                    <FilterSelect value={localFilters.tipo_id} onChange={(value) => setLocalFilters({ ...localFilters, tipo_id: value })} options={toCatalogOptions(tipos)} placeholder="Tipo" />
                    <FilterSelect value={localFilters.responsable_id} onChange={(value) => setLocalFilters({ ...localFilters, responsable_id: value })} options={toUserOptions(users)} placeholder="Responsable" />
                    <FilterSelect value={localFilters.quick_filter} onChange={(value) => setLocalFilters({ ...localFilters, quick_filter: value })} options={[
                        { value: 'pendientes_triage', label: 'Pendientes de triage' },
                        { value: 'falta_informacion', label: 'Falta informacion' },
                        { value: 'priorizados', label: 'Priorizados' },
                        { value: 'mis_por_analizar', label: 'Mis tickets por analizar' },
                        { value: 'vencidos', label: 'Vencidos SLA' },
                        { value: 'en_riesgo', label: 'En riesgo SLA' },
                        { value: 'sin_tiempo', label: 'Sin tiempo registrado' },
                        { value: 'con_tiempo_facturable', label: 'Con tiempo facturable' },
                        { value: 'mis_vencidos', label: 'Mis tickets vencidos' },
                    ]} placeholder="Filtro rapido" />
                    <div className="flex gap-2">
                        <Button type="button" onClick={applyFilters}><Search className="size-4" /> Filtrar</Button>
                        <Button type="button" variant="outline" onClick={() => router.get(route('tickets.index'))}><XCircle className="size-4" /> Limpiar</Button>
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

            <ConfirmDeleteDialog open={deleteTarget !== null} onOpenChange={(open) => !open && setDeleteTarget(null)} title="Eliminar ticket" entityLabel="el ticket" itemName={deleteTarget?.folio} onConfirm={() => {
                if (!deleteTarget) return;
                router.delete(route('tickets.destroy', deleteTarget.id), { onSuccess: () => setDeleteTarget(null) });
            }} />
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

function formatMinutes(minutes: number) {
    if (minutes < 60) return `${minutes} min`;
    const hours = Math.floor(minutes / 60);
    const rest = minutes % 60;
    return rest > 0 ? `${hours} h ${rest} min` : `${hours} h`;
}

function slaVariant(status?: string | null): 'default' | 'secondary' | 'destructive' | 'outline' {
    if (status === 'vencido' || status === 'incumplido') return 'destructive';
    if (status === 'en_riesgo') return 'secondary';
    if (status === 'cumplido' || status === 'en_tiempo') return 'default';
    return 'outline';
}
