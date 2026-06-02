import { Head, Link, router, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import { Banknote, Boxes, Cloud, Eye, FileText, FolderKanban, KanbanSquare, ListChecks, MoreHorizontal, Pencil, Plus, Receipt, Ticket, Trash2, WalletCards } from 'lucide-react';
import { useEffect, useMemo, useState } from 'react';
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
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type Proyecto = {
    id: string;
    nombre: string;
    estado: string;
    criticidad: string;
    url_produccion: string | null;
    cliente?: { id: string; nombre: string | null; razon_social: string | null } | null;
    responsable_tecnico?: { id: number; name: string } | null;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Tickets', href: route('tickets.dashboard') },
    { title: 'Proyectos', href: route('proyectos.index') },
];

export default function ProyectosIndex({
    proyectos,
    estadoOptions,
    criticidadOptions,
}: {
    proyectos: Proyecto[];
    estadoOptions: string[];
    criticidadOptions: string[];
}) {
    const { flash } = usePage<SharedData>().props;

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash]);

    const [search, setSearch] = useState('');
    const [estado, setEstado] = useState('todos');
    const [criticidad, setCriticidad] = useState('todos');
    const [deleteTarget, setDeleteTarget] = useState<Proyecto | null>(null);
    const permissions = usePage<SharedData>().props.auth.permissions ?? [];
    const canCreate = permissions.includes('proyectos.create');
    const canManage = permissions.includes('proyectos.manage');
    const canDelete = permissions.includes('proyectos.delete');
    const canViewProjectDocuments = permissions.includes('project-planning.documents.view') || permissions.includes('project-planning.documents.manage');
    const canViewBilling = permissions.some((permission) => ['project-billing.view', 'project-billing.reports', 'project-billing.manage'].includes(permission));
    const canViewCharges = permissions.includes('project-billing.charges.view') || permissions.includes('project-billing.charges.manage');
    const canViewPayments = permissions.includes('project-billing.payments.view') || permissions.includes('project-billing.payments.manage');
    const canViewPlanning = permissions.includes('project-planning.view');
    const canViewActivities = permissions.includes('project-planning.activities.view') || permissions.includes('project-planning.activities.manage');
    const canViewKanban = permissions.includes('project-planning.kanban.view') || permissions.includes('project-planning.kanban.manage');
    const canViewTickets = permissions.includes('tickets.view') || permissions.includes('tickets.manage');
    const canViewProjectSections = permissions.includes('proyectos.view') || permissions.includes('proyectos.manage');

    const filteredProyectos = useMemo(() => {
        const term = search.trim().toLowerCase();

        return proyectos.filter((proyecto) => {
            const cliente = proyecto.cliente?.nombre ?? proyecto.cliente?.razon_social ?? '';
            const matchesSearch = term.length === 0
                || [proyecto.nombre, cliente]
                    .some((value) => value.toLowerCase().includes(term));
            const matchesEstado = estado === 'todos' || proyecto.estado === estado;
            const matchesCriticidad = criticidad === 'todos' || proyecto.criticidad === criticidad;

            return matchesSearch && matchesEstado && matchesCriticidad;
        });
    }, [criticidad, estado, proyectos, search]);

    const columns: DataTableColumn<Proyecto>[] = [
        {
            key: 'nombre',
            header: 'Nombre',
            accessor: (proyecto) => proyecto.nombre,
            cell: (proyecto) => proyecto.nombre,
        },
        {
            key: 'cliente',
            header: 'Cliente',
            accessor: (proyecto) => proyecto.cliente?.nombre ?? proyecto.cliente?.razon_social ?? '',
            cell: (proyecto) => proyecto.cliente?.nombre ?? proyecto.cliente?.razon_social ?? '-',
        },
        { key: 'estado', header: 'Estado', accessor: (proyecto) => proyecto.estado, cell: (proyecto) => <Badge variant="outline">{proyecto.estado}</Badge> },
        { key: 'criticidad', header: 'Criticidad', accessor: (proyecto) => proyecto.criticidad, cell: (proyecto) => <Badge variant={proyecto.criticidad === 'critica' ? 'destructive' : 'secondary'}>{proyecto.criticidad}</Badge> },
        { key: 'responsable', header: 'Responsable tecnico', cell: (proyecto) => proyecto.responsable_tecnico?.name ?? '-' },
        {
            key: 'url_produccion',
            header: 'URL produccion',
            cell: (proyecto) => proyecto.url_produccion ? (
                <a className="text-primary hover:underline" href={proyecto.url_produccion} target="_blank" rel="noreferrer">
                    Abrir
                </a>
            ) : '-',
        },
        {
            key: 'actions',
            header: 'Acciones',
            className: 'w-24',
            cell: (proyecto) => (
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <Button variant="ghost" size="icon" className="size-8">
                            <MoreHorizontal className="size-4" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuItem asChild>
                            <Link href={route('proyectos.show', proyecto.id)}>
                                <Eye className="mr-2 size-4" /> Ver resumen
                            </Link>
                        </DropdownMenuItem>
                        {canManage && (
                            <DropdownMenuItem asChild>
                                <Link href={route('proyectos.edit', proyecto.id)}>
                                    <Pencil className="mr-2 size-4" /> Editar
                                </Link>
                            </DropdownMenuItem>
                        )}
                        {canViewBilling && (
                            <DropdownMenuItem asChild>
                                <Link href={route('proyectos.billing.index', proyecto.id)}>
                                    <Banknote className="mr-2 size-4" /> Cobranza
                                </Link>
                            </DropdownMenuItem>
                        )}
                        {canViewCharges && (
                            <DropdownMenuItem asChild>
                                <Link href={route('proyectos.billing.charges.index', proyecto.id)}>
                                    <Receipt className="mr-2 size-4" /> Cargos
                                </Link>
                            </DropdownMenuItem>
                        )}
                        {canViewPayments && (
                            <DropdownMenuItem asChild>
                                <Link href={route('proyectos.billing.payments.index', proyecto.id)}>
                                    <WalletCards className="mr-2 size-4" /> Pagos
                                </Link>
                            </DropdownMenuItem>
                        )}
                        {canViewProjectDocuments && (
                            <DropdownMenuItem asChild>
                                <Link href={route('proyectos.documents.index', proyecto.id)}>
                                    <FileText className="mr-2 size-4" /> Documentos
                                </Link>
                            </DropdownMenuItem>
                        )}
                        {canViewProjectSections && (
                            <>
                                <DropdownMenuItem asChild>
                                    <Link href={route('proyectos.ambientes.index', proyecto.id)}>
                                        <Cloud className="mr-2 size-4" /> Ambientes
                                    </Link>
                                </DropdownMenuItem>
                                <DropdownMenuItem asChild>
                                    <Link href={route('proyectos.modulos.index', proyecto.id)}>
                                        <Boxes className="mr-2 size-4" /> Modulos
                                    </Link>
                                </DropdownMenuItem>
                            </>
                        )}
                        {canDelete && (
                            <>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem variant="destructive" onClick={() => setDeleteTarget(proyecto)}>
                                    <Trash2 className="mr-2 size-4" /> Eliminar
                                </DropdownMenuItem>
                            </>
                        )}
                    </DropdownMenuContent>
                </DropdownMenu>
            ),
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Proyectos" />

            <div className="space-y-4 rounded-xl p-4">
                <ModuleHeader title="Proyectos" description="Administra los sistemas o desarrollos de cada cliente. Aqui puedes consultar informacion general, ambientes, documentos, actividades, tickets, pagos y avance operativo del proyecto.">
                    {canCreate && (
                        <Button asChild>
                            <Link href={route('proyectos.create')}>
                                <Plus className="size-4" /> Nuevo proyecto
                            </Link>
                        </Button>
                    )}
                </ModuleHeader>

                <div className="grid gap-3 md:grid-cols-[minmax(0,1fr)_180px_180px]">
                    <Input
                        value={search}
                        onChange={(event) => setSearch(event.target.value)}
                        placeholder="Buscar por nombre o cliente..."
                    />
                    <Select value={estado} onValueChange={setEstado}>
                        <SelectTrigger className="w-full">
                            <SelectValue placeholder="Estado" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="todos">Todos</SelectItem>
                            {estadoOptions.map((option) => (
                                <SelectItem key={option} value={option}>
                                    {option}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    <Select value={criticidad} onValueChange={setCriticidad}>
                        <SelectTrigger className="w-full">
                            <SelectValue placeholder="Criticidad" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="todos">Todas</SelectItem>
                            {criticidadOptions.map((option) => (
                                <SelectItem key={option} value={option}>
                                    {option}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                </div>

                <DataTable
                    columns={columns}
                    data={filteredProyectos}
                    showSearch={false}
                    emptyMessage="No hay proyectos con los filtros actuales."
                />
            </div>

            <ConfirmDeleteDialog
                open={deleteTarget !== null}
                onOpenChange={(open) => !open && setDeleteTarget(null)}
                title="Eliminar proyecto"
                entityLabel="el proyecto"
                itemName={deleteTarget?.nombre}
                onConfirm={() => {
                    if (!deleteTarget) return;
                    router.delete(route('proyectos.destroy', deleteTarget.id), {
                        onSuccess: () => setDeleteTarget(null),
                    });
                }}
            />
        </AppLayout>
    );
}
