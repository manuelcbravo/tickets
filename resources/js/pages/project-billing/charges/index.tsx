import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import type React from 'react';
import { Banknote, Eye, MoreHorizontal, Pencil, Search, WalletCards, XCircle } from 'lucide-react';
import { useEffect, useState } from 'react';
import { route } from 'ziggy-js';
import { CrudFormDialog } from '@/components/crud-form-dialog';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { FormTextareaField } from '@/components/form-textarea-field';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, ClientOption, ProjectOption, SharedData } from '@/types';

type Charge = {
    id: string;
    folio: string;
    concepto: string;
    periodo_inicio: string | null;
    periodo_fin: string | null;
    fecha_emision: string;
    fecha_vencimiento: string;
    monto: string | number;
    monto_pagado: string | number;
    saldo: string | number;
    estado: string;
    cliente?: { nombre?: string | null; razon_social?: string | null } | null;
    proyecto?: { id: string; nombre?: string | null } | null;
};

type Paginated<T> = { data: T[]; links: { url: string | null; label: string; active: boolean }[]; from: number | null; to: number | null; total: number };

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Cobranza', href: route('project-billing.dashboard') },
    { title: 'Cargos', href: route('project-billing.charges.index') },
];

export default function ChargesIndex({ charges, filters, clientes, proyectos, estados }: { charges: Paginated<Charge>; filters: Record<string, string | null>; clientes: ClientOption[]; proyectos: ProjectOption[]; estados: string[] }) {
    const { flash } = usePage<SharedData>().props;
    const permissions = usePage<SharedData>().props.auth.permissions ?? [];
    const canManageCharges = permissions.includes('project-billing.charges.manage');
    const canManagePayments = permissions.includes('project-billing.payments.manage');
    const [chargeAction, setChargeAction] = useState<{ charge: Charge; action: 'cancel' | 'forgive' } | null>(null);
    const actionForm = useForm({ cancellation_reason: '' });

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const [localFilters, setLocalFilters] = useState({
        cliente_id: filters.cliente_id ?? 'todos',
        proyecto_id: filters.proyecto_id ?? 'todos',
        estado: filters.estado ?? 'todos',
    });

    const columns: DataTableColumn<Charge>[] = [
        { key: 'folio', header: 'Folio', cell: (row) => row.folio },
        { key: 'cliente', header: 'Cliente', cell: (row) => row.cliente?.nombre ?? row.cliente?.razon_social ?? '-' },
        { key: 'proyecto', header: 'Proyecto', cell: (row) => row.proyecto ? <Link className="text-primary hover:underline" href={route('proyectos.show', row.proyecto.id)}>{row.proyecto.nombre}</Link> : '-' },
        { key: 'concepto', header: 'Concepto', cell: (row) => row.concepto },
        { key: 'periodo', header: 'Periodo', cell: (row) => row.periodo_inicio ? `${date(row.periodo_inicio)} - ${row.periodo_fin ? date(row.periodo_fin) : '-'}` : '-' },
        { key: 'fecha_vencimiento', header: 'Vence', cell: (row) => date(row.fecha_vencimiento) },
        { key: 'monto', header: 'Monto', cell: (row) => money(row.monto) },
        { key: 'monto_pagado', header: 'Pagado', cell: (row) => money(row.monto_pagado) },
        { key: 'saldo', header: 'Saldo', cell: (row) => money(row.saldo) },
        { key: 'estado', header: 'Estado', cell: (row) => <StatusBadge status={row.estado} /> },
        {
            key: 'actions',
            header: 'Acciones',
            cell: (row) => row.proyecto ? (
                <DropdownMenu>
                    <DropdownMenuTrigger asChild><Button variant="ghost" size="icon" className="size-8"><MoreHorizontal className="size-4" /></Button></DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuItem asChild><Link href={route('proyectos.billing.charges.index', row.proyecto.id)}><Eye className="mr-2 size-4" /> Ver</Link></DropdownMenuItem>
                        {canManageCharges && <DropdownMenuItem asChild><Link href={route('proyectos.billing.charges.index', row.proyecto.id)}><Pencil className="mr-2 size-4" /> Editar</Link></DropdownMenuItem>}
                        {canManagePayments && <DropdownMenuItem asChild><Link href={route('project-billing.payments.create')}><Banknote className="mr-2 size-4" /> Registrar pago</Link></DropdownMenuItem>}
                        <DropdownMenuItem asChild><Link href={route('proyectos.billing.payments.index', row.proyecto.id)}><WalletCards className="mr-2 size-4" /> Pagos aplicados</Link></DropdownMenuItem>
                        {canManageCharges && !['cancelado', 'condonado', 'pagado'].includes(row.estado) && (
                            <>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem onClick={() => setChargeAction({ charge: row, action: 'cancel' })}><XCircle className="mr-2 size-4" /> Cancelar</DropdownMenuItem>
                                <DropdownMenuItem onClick={() => setChargeAction({ charge: row, action: 'forgive' })}><XCircle className="mr-2 size-4" /> Condonar</DropdownMenuItem>
                            </>
                        )}
                    </DropdownMenuContent>
                </DropdownMenu>
            ) : null,
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Cargos" />
            <div className="space-y-4 p-4">
                <div className="rounded-xl border bg-sidebar-accent/20 p-4">
                    <h1 className="text-xl font-semibold">Cargos</h1>
                    <p className="text-sm text-muted-foreground">Cuentas por cobrar de proyectos.</p>
                </div>

                <div className="grid gap-3 md:grid-cols-4">
                    <Filter value={localFilters.cliente_id} onChange={(value) => setLocalFilters({ ...localFilters, cliente_id: value })} options={clientes.map((item) => ({ value: item.id, label: item.nombre ?? item.razon_social ?? item.id }))} placeholder="Cliente" />
                    <Filter value={localFilters.proyecto_id} onChange={(value) => setLocalFilters({ ...localFilters, proyecto_id: value })} options={proyectos.map((item) => ({ value: item.id, label: item.nombre }))} placeholder="Proyecto" />
                    <Filter value={localFilters.estado} onChange={(value) => setLocalFilters({ ...localFilters, estado: value })} options={estados.map((item) => ({ value: item, label: item.replaceAll('_', ' ') }))} placeholder="Estado" />
                    <div className="flex gap-2">
                        <Button onClick={() => router.get(route('project-billing.charges.index'), normalize(localFilters), { preserveState: true })}><Search className="size-4" /> Filtrar</Button>
                        <Button variant="outline" onClick={() => router.get(route('project-billing.charges.index'))}><XCircle className="size-4" /></Button>
                    </div>
                </div>

                <Card className="rounded-lg">
                    <CardHeader><CardTitle>Listado de cargos</CardTitle></CardHeader>
                    <CardContent>
                        <DataTable columns={columns} data={charges.data} showSearch={false} emptyMessage="No hay cargos con los filtros actuales." />
                        <Pagination links={charges.links} from={charges.from} to={charges.to} total={charges.total} />
                    </CardContent>
                </Card>
            </div>

            <CrudFormDialog open={chargeAction !== null} onOpenChange={(open) => !open && setChargeAction(null)} title={chargeAction?.action === 'forgive' ? 'Condonar cargo' : 'Cancelar cargo'} description="Registra el motivo para auditoria." submitLabel={chargeAction?.action === 'forgive' ? 'Condonar' : 'Cancelar'} processing={actionForm.processing} onSubmit={(event: React.FormEvent<HTMLFormElement>) => {
                event.preventDefault();
                if (!chargeAction?.charge.proyecto) return;
                actionForm.patch(route(`proyectos.billing.charges.${chargeAction.action}`, [chargeAction.charge.proyecto.id, chargeAction.charge.id]), { preserveScroll: true, onSuccess: () => { setChargeAction(null); actionForm.reset(); } });
            }}>
                <FormTextareaField label="Motivo" value={actionForm.data.cancellation_reason} onChange={(event) => actionForm.setData('cancellation_reason', event.target.value)} error={actionForm.errors.cancellation_reason} />
            </CrudFormDialog>
        </AppLayout>
    );
}

function Filter({ value, onChange, options, placeholder }: { value: string; onChange: (value: string) => void; options: { value: string; label: string }[]; placeholder: string }) {
    return <Select value={value} onValueChange={onChange}><SelectTrigger><SelectValue placeholder={placeholder} /></SelectTrigger><SelectContent><SelectItem value="todos">Todos</SelectItem>{options.map((option) => <SelectItem key={option.value} value={option.value}>{option.label}</SelectItem>)}</SelectContent></Select>;
}
function Pagination({ links, from, to, total }: { links: Paginated<Charge>['links']; from: number | null; to: number | null; total: number }) {
    return <div className="mt-4 flex flex-wrap items-center justify-between gap-2"><p className="text-sm text-muted-foreground">Mostrando {from ?? 0}-{to ?? 0} de {total}</p><div className="flex flex-wrap gap-1">{links.map((link, index) => <Button key={index} variant={link.active ? 'default' : 'outline'} size="sm" disabled={!link.url} onClick={() => link.url && router.get(link.url)}><span dangerouslySetInnerHTML={{ __html: link.label }} /></Button>)}</div></div>;
}
function StatusBadge({ status }: { status: string }) { return <Badge variant={status === 'vencido' ? 'destructive' : status === 'pagado' ? 'default' : 'outline'}>{status.replaceAll('_', ' ')}</Badge>; }
const normalize = (filters: Record<string, string>) => Object.fromEntries(Object.entries(filters).filter(([, value]) => value !== 'todos' && value !== ''));
const money = (value: string | number) => new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(Number(value ?? 0));
const date = (value: string) => new Date(value).toLocaleDateString('es-MX');
