import { Head, Link, router, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import { Bell, Eye, MessageSquare, MoreHorizontal, Pencil, Plus, Power, Search, Trash2, Webhook, XCircle } from 'lucide-react';
import { useEffect, useState } from 'react';
import { route } from 'ziggy-js';
import { ConfirmDeleteDialog } from '@/components/confirm-delete-dialog';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { ModuleHeader } from '@/components/module-header';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type Integration = {
    id: string;
    nombre: string;
    tipo: string;
    proveedor: string | null;
    activo: boolean;
    updated_at: string;
};

type Paginated<T> = {
    data: T[];
    links: { url: string | null; label: string; active: boolean }[];
    from: number | null;
    to: number | null;
    total: number;
};

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Integraciones', href: route('integrations.index') }];

export default function IntegrationsIndex({ integrations, filters, types }: { integrations: Paginated<Integration>; filters: Record<string, string | null>; types: string[] }) {
    const { flash } = usePage<SharedData>().props;

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const permissions = usePage<SharedData>().props.auth.permissions ?? [];
    const canManage = permissions.includes('integrations.manage');
    const canViewWebhooks = permissions.includes('integrations.webhooks.view') || permissions.includes('integrations.webhooks.manage');
    const canViewNotifications = permissions.includes('notifications.view') || permissions.includes('notifications.manage');
    const [deleteTarget, setDeleteTarget] = useState<Integration | null>(null);
    const [localFilters, setLocalFilters] = useState({
        search: filters.search ?? '',
        tipo: filters.tipo ?? 'todos',
        activo: filters.activo ?? 'todos',
    });

    const columns: DataTableColumn<Integration>[] = [
        { key: 'nombre', header: 'Nombre', cell: (row) => <Link className="font-medium text-primary hover:underline" href={route('integrations.show', row.id)}>{row.nombre}</Link> },
        { key: 'tipo', header: 'Tipo', cell: (row) => <Badge variant="outline">{labelize(row.tipo)}</Badge> },
        { key: 'proveedor', header: 'Proveedor', cell: (row) => row.proveedor ? labelize(row.proveedor) : '-' },
        { key: 'activo', header: 'Activo', cell: (row) => <Badge variant={row.activo ? 'default' : 'secondary'}>{row.activo ? 'Activa' : 'Inactiva'}</Badge> },
        { key: 'updated_at', header: 'Actualizada', cell: (row) => new Date(row.updated_at).toLocaleDateString('es-MX') },
        {
            key: 'actions',
            header: 'Acciones',
            className: 'w-20',
            cell: (row) => (
                <DropdownMenu>
                    <DropdownMenuTrigger asChild><Button variant="ghost" size="icon" className="size-8"><MoreHorizontal className="size-4" /></Button></DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuItem asChild><Link href={route('integrations.show', row.id)}><Eye className="mr-2 size-4" /> Ver</Link></DropdownMenuItem>
                        {canManage && <DropdownMenuItem asChild><Link href={route('integrations.edit', row.id)}><Pencil className="mr-2 size-4" /> Editar</Link></DropdownMenuItem>}
                        {canManage && <DropdownMenuItem onClick={() => router.patch(route(row.activo ? 'integrations.deactivate' : 'integrations.activate', row.id), {}, { preserveScroll: true })}><Power className="mr-2 size-4" /> {row.activo ? 'Desactivar' : 'Activar'}</DropdownMenuItem>}
                        {canViewWebhooks && <DropdownMenuItem asChild><Link href={route('integrations.webhooks.index')}><Webhook className="mr-2 size-4" /> Webhooks</Link></DropdownMenuItem>}
                        <DropdownMenuItem asChild><Link href={route('integrations.messages.index')}><MessageSquare className="mr-2 size-4" /> Mensajes</Link></DropdownMenuItem>
                        {canViewNotifications && <DropdownMenuItem asChild><Link href={route('notifications.logs.index')}><Bell className="mr-2 size-4" /> Notificaciones</Link></DropdownMenuItem>}
                        {canManage && <><DropdownMenuSeparator /><DropdownMenuItem variant="destructive" onClick={() => setDeleteTarget(row)}><Trash2 className="mr-2 size-4" /> Eliminar</DropdownMenuItem></>}
                    </DropdownMenuContent>
                </DropdownMenu>
            ),
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Integraciones" />
            <div className="space-y-4 rounded-xl p-4">
                <ModuleHeader title="Integraciones" description="Conecta eventos externos, correo, webhooks y repositorios con los tickets. Su objetivo es registrar comunicacion y trazabilidad sin trabajar fuera del sistema.">
                    {canManage && <Button asChild><Link href={route('integrations.create')}><Plus className="size-4" /> Nueva integracion</Link></Button>}
                </ModuleHeader>

                <div className="grid gap-3 md:grid-cols-5">
                    <Input className="md:col-span-2" value={localFilters.search} onChange={(event) => setLocalFilters({ ...localFilters, search: event.target.value })} placeholder="Nombre, tipo o proveedor..." />
                    <FilterSelect value={localFilters.tipo} onChange={(value) => setLocalFilters({ ...localFilters, tipo: value })} options={types.map((type) => ({ value: type, label: labelize(type) }))} placeholder="Tipo" />
                    <FilterSelect value={localFilters.activo} onChange={(value) => setLocalFilters({ ...localFilters, activo: value })} options={[{ value: '1', label: 'Activas' }, { value: '0', label: 'Inactivas' }]} placeholder="Activo" />
                    <div className="flex gap-2">
                        <Button type="button" onClick={() => router.get(route('integrations.index'), normalizeFilters(localFilters), { preserveState: true, preserveScroll: true })}><Search className="size-4" /> Filtrar</Button>
                        <Button type="button" variant="outline" onClick={() => router.get(route('integrations.index'))}><XCircle className="size-4" /> Limpiar</Button>
                    </div>
                </div>

                <Card className="rounded-lg">
                    <CardHeader><CardTitle>Listado</CardTitle><CardDescription>No se muestran secretos ni tokens.</CardDescription></CardHeader>
                    <CardContent>
                        <DataTable columns={columns} data={integrations.data} showSearch={false} emptyMessage="No hay integraciones." />
                        <Pagination page={integrations} />
                    </CardContent>
                </Card>
            </div>

            <ConfirmDeleteDialog
                open={deleteTarget !== null}
                onOpenChange={(open) => !open && setDeleteTarget(null)}
                title="Eliminar integracion"
                entityLabel="la integracion"
                itemName={deleteTarget?.nombre}
                onConfirm={() => {
                    if (!deleteTarget) return;
                    router.delete(route('integrations.destroy', deleteTarget.id), {
                        onSuccess: () => setDeleteTarget(null),
                    });
                }}
            />
        </AppLayout>
    );
}

function FilterSelect({ value, onChange, options, placeholder }: { value: string; onChange: (value: string) => void; options: { value: string; label: string }[]; placeholder: string }) {
    return (
        <Select value={value} onValueChange={onChange}>
            <SelectTrigger><SelectValue placeholder={placeholder} /></SelectTrigger>
            <SelectContent><SelectItem value="todos">Todos</SelectItem>{options.map((option) => <SelectItem key={option.value} value={option.value}>{option.label}</SelectItem>)}</SelectContent>
        </Select>
    );
}

function Pagination<T>({ page }: { page: Paginated<T> }) {
    return <div className="mt-4 flex flex-wrap items-center justify-between gap-2"><p className="text-sm text-muted-foreground">Mostrando {page.from ?? 0}-{page.to ?? 0} de {page.total}</p><div className="flex flex-wrap gap-1">{page.links.map((link, index) => <Button key={`${link.label}-${index}`} variant={link.active ? 'default' : 'outline'} size="sm" disabled={!link.url} onClick={() => link.url && router.get(link.url, {}, { preserveScroll: true })}><span dangerouslySetInnerHTML={{ __html: link.label }} /></Button>)}</div></div>;
}

function normalizeFilters(filters: Record<string, string>) {
    return Object.fromEntries(Object.entries(filters).filter(([, value]) => value !== '' && value !== 'todos'));
}

const labelize = (value: string) => value.replaceAll('_', ' ');
