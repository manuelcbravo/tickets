import { Head, Link, router, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import { Banknote, ContactRound, Eye, FileText, FolderKanban, MoreHorizontal, Pencil, Plus, Ticket, Trash2 } from 'lucide-react';
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

type Cliente = {
    id: string;
    nombre: string | null;
    razon_social: string | null;
    rfc: string | null;
    email: string | null;
    phone: string | null;
    estatus: string | null;
    clasificacion: string | null;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Tickets', href: route('tickets.dashboard') },
    { title: 'Clientes', href: route('clientes.index') },
];

const riskyStatuses = ['suspendido', 'moroso'];

const statusVariant = (status: string | null) =>
    status && riskyStatuses.includes(status) ? 'destructive' : status === 'activo' ? 'secondary' : 'outline';

export default function ClientesIndex({
    clientes,
    estatusOptions,
}: {
    clientes: Cliente[];
    estatusOptions: string[];
}) {
    const { flash } = usePage<SharedData>().props;

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const [search, setSearch] = useState('');
    const [estatus, setEstatus] = useState('todos');
    const [deleteTarget, setDeleteTarget] = useState<Cliente | null>(null);
    const permissions = usePage<SharedData>().props.auth.permissions ?? [];
    const canCreate = permissions.includes('clientes.create');
    const canManage = permissions.includes('clientes.manage');
    const canDelete = permissions.includes('clientes.delete');
    const canViewProjects = permissions.includes('proyectos.view') || permissions.includes('proyectos.manage');
    const canViewTickets = permissions.includes('tickets.view') || permissions.includes('tickets.manage');
    const canViewQuotes = permissions.includes('quotes.view') || permissions.includes('quotes.manage');
    const canViewBilling = permissions.some((permission) => ['project-billing.view', 'project-billing.reports', 'project-billing.manage', 'project-billing.charges.view', 'project-billing.charges.manage'].includes(permission));

    const filteredClientes = useMemo(() => {
        const term = search.trim().toLowerCase();

        return clientes.filter((cliente) => {
            const matchesSearch = term.length === 0
                || [
                    cliente.nombre,
                    cliente.razon_social,
                    cliente.rfc,
                    cliente.email,
                ]
                    .filter(Boolean)
                    .some((value) => String(value).toLowerCase().includes(term));
            const matchesStatus = estatus === 'todos' || cliente.estatus === estatus;

            return matchesSearch && matchesStatus;
        });
    }, [clientes, estatus, search]);

    const columns: DataTableColumn<Cliente>[] = [
        {
            key: 'nombre',
            header: 'Nombre',
            accessor: (cliente) => cliente.nombre ?? '',
            cell: (cliente) => cliente.nombre ?? 'Sin nombre',
        },
        {
            key: 'razon_social',
            header: 'Razon social',
            accessor: (cliente) => cliente.razon_social ?? '',
            cell: (cliente) => cliente.razon_social ?? '-',
        },
        { key: 'rfc', header: 'RFC', accessor: (cliente) => cliente.rfc ?? '', cell: (cliente) => cliente.rfc ?? '-' },
        { key: 'email', header: 'Email', accessor: (cliente) => cliente.email ?? '', cell: (cliente) => cliente.email ?? '-' },
        { key: 'phone', header: 'Telefono', accessor: (cliente) => cliente.phone ?? '', cell: (cliente) => cliente.phone ?? '-' },
        {
            key: 'estatus',
            header: 'Estado',
            accessor: (cliente) => cliente.estatus ?? '',
            cell: (cliente) => (
                <Badge variant={statusVariant(cliente.estatus)}>
                    {cliente.estatus ?? 'sin estatus'}
                </Badge>
            ),
        },
        {
            key: 'clasificacion',
            header: 'Clasificacion',
            accessor: (cliente) => cliente.clasificacion ?? '',
            cell: (cliente) => cliente.clasificacion ?? '-',
        },
        {
            key: 'actions',
            header: 'Acciones',
            className: 'w-24',
            cell: (cliente) => (
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <Button variant="ghost" size="icon" className="size-8">
                            <MoreHorizontal className="size-4" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuItem asChild>
                            <Link href={route('clientes.show', cliente.id)}>
                                <Eye className="mr-2 size-4" /> Ver resumen
                            </Link>
                        </DropdownMenuItem>
                        {canManage && (
                            <DropdownMenuItem asChild>
                                <Link href={route('clientes.edit', cliente.id)}>
                                    <Pencil className="mr-2 size-4" /> Editar
                                </Link>
                            </DropdownMenuItem>
                        )}
                        {canManage && (
                            <DropdownMenuItem asChild>
                                <Link href={route('clientes.show', cliente.id)}>
                                    <ContactRound className="mr-2 size-4" /> Contactos
                                </Link>
                            </DropdownMenuItem>
                        )}
                        {canViewProjects && (
                            <DropdownMenuItem asChild>
                                <Link href={route('clientes.show', cliente.id)}>
                                    <FolderKanban className="mr-2 size-4" /> Proyectos
                                </Link>
                            </DropdownMenuItem>
                        )}
                        {canViewTickets && (
                            <DropdownMenuItem asChild>
                                <Link href={route('tickets.index', { cliente_id: cliente.id })}>
                                    <Ticket className="mr-2 size-4" /> Tickets
                                </Link>
                            </DropdownMenuItem>
                        )}
                        {canViewQuotes && (
                            <DropdownMenuItem asChild>
                                <Link href={route('quotes.index', { cliente_id: cliente.id })}>
                                    <FileText className="mr-2 size-4" /> Cotizaciones
                                </Link>
                            </DropdownMenuItem>
                        )}
                        {canViewBilling && (
                            <DropdownMenuItem asChild>
                                <Link href={route('project-billing.charges.index', { cliente_id: cliente.id })}>
                                    <Banknote className="mr-2 size-4" /> Cobranza
                                </Link>
                            </DropdownMenuItem>
                        )}
                        {canDelete && (
                            <>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem
                                    variant="destructive"
                                    onClick={() => setDeleteTarget(cliente)}
                                >
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
            <Head title="Clientes" />

            <div className="space-y-4 rounded-xl p-4">
                <ModuleHeader title="Clientes" description="Gestiona las empresas y contactos atendidos. Sirve como base para relacionar proyectos, tickets, cotizaciones, pagos e historial de soporte.">
                    {canCreate && (
                        <Button asChild>
                            <Link href={route('clientes.create')}>
                                <Plus className="size-4" /> Nuevo cliente
                            </Link>
                        </Button>
                    )}
                </ModuleHeader>

                <div className="grid gap-3 md:grid-cols-[minmax(0,1fr)_220px]">
                    <Input
                        value={search}
                        onChange={(event) => setSearch(event.target.value)}
                        placeholder="Buscar por nombre, razon social, RFC o email..."
                    />
                    <Select value={estatus} onValueChange={setEstatus}>
                        <SelectTrigger className="w-full">
                            <SelectValue placeholder="Estatus" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="todos">Todos</SelectItem>
                            {estatusOptions.map((option) => (
                                <SelectItem key={option} value={option}>
                                    {option}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                </div>

                <DataTable
                    columns={columns}
                    data={filteredClientes}
                    showSearch={false}
                    emptyMessage="No hay clientes con los filtros actuales."
                />
            </div>

            <ConfirmDeleteDialog
                open={deleteTarget !== null}
                onOpenChange={(open) => !open && setDeleteTarget(null)}
                title="Eliminar cliente"
                entityLabel="el cliente"
                itemName={deleteTarget?.nombre ?? undefined}
                onConfirm={() => {
                    if (!deleteTarget) return;
                    router.delete(route('clientes.destroy', deleteTarget.id), {
                        onSuccess: () => setDeleteTarget(null),
                    });
                }}
            />
        </AppLayout>
    );
}
