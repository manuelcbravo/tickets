import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import type React from 'react';
import { CheckCircle2, Eye, Link2, MoreHorizontal, Pencil, Plus, Search, Upload, XCircle } from 'lucide-react';
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

type Payment = {
    id: string;
    folio: string;
    fecha_pago: string;
    monto: string | number;
    metodo_pago: string | null;
    referencia: string | null;
    estado: string;
    documentos_count: number;
    cliente?: { nombre?: string | null; razon_social?: string | null } | null;
    proyecto?: { nombre?: string | null } | null;
};
type Paginated<T> = { data: T[]; links: { url: string | null; label: string; active: boolean }[]; from: number | null; to: number | null; total: number };

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Cobranza', href: route('project-billing.dashboard') },
    { title: 'Pagos', href: route('project-billing.payments.index') },
];

export default function PaymentsIndex({ payments, filters, clientes, proyectos, metodos, estados }: { payments: Paginated<Payment>; filters: Record<string, string | null>; clientes: ClientOption[]; proyectos: ProjectOption[]; metodos: string[]; estados: string[] }) {
    const { flash } = usePage<SharedData>().props;
    const permissions = usePage<SharedData>().props.auth.permissions ?? [];
    const canManage = permissions.includes('project-billing.payments.manage');
    const canConfirm = permissions.includes('project-billing.payments.confirm');
    const canDocs = permissions.includes('project-billing.documents.manage');
    const [statusAction, setStatusAction] = useState<{ payment: Payment; action: 'reject' | 'cancel' } | null>(null);
    const statusForm = useForm({ cancellation_reason: '' });

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const [localFilters, setLocalFilters] = useState({
        cliente_id: filters.cliente_id ?? 'todos',
        proyecto_id: filters.proyecto_id ?? 'todos',
        estado: filters.estado ?? 'todos',
        metodo_pago: filters.metodo_pago ?? 'todos',
    });

    const columns: DataTableColumn<Payment>[] = [
        { key: 'folio', header: 'Folio', cell: (row) => <Link className="font-medium text-primary hover:underline" href={route('project-billing.payments.show', row.id)}>{row.folio}</Link> },
        { key: 'cliente', header: 'Cliente', cell: (row) => row.cliente?.nombre ?? row.cliente?.razon_social ?? '-' },
        { key: 'proyecto', header: 'Proyecto', cell: (row) => row.proyecto?.nombre ?? '-' },
        { key: 'fecha_pago', header: 'Fecha', cell: (row) => date(row.fecha_pago) },
        { key: 'monto', header: 'Monto', cell: (row) => money(row.monto) },
        { key: 'metodo_pago', header: 'Metodo', cell: (row) => row.metodo_pago ?? '-' },
        { key: 'referencia', header: 'Referencia', cell: (row) => row.referencia ?? '-' },
        { key: 'estado', header: 'Estado', cell: (row) => <StatusBadge status={row.estado} /> },
        { key: 'documentos', header: 'Comprobantes', cell: (row) => row.documentos_count },
        {
            key: 'actions',
            header: 'Acciones',
            cell: (row) => (
                <DropdownMenu>
                    <DropdownMenuTrigger asChild><Button variant="ghost" size="icon" className="size-8"><MoreHorizontal className="size-4" /></Button></DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuItem asChild><Link href={route('project-billing.payments.show', row.id)}><Eye className="mr-2 size-4" /> Ver</Link></DropdownMenuItem>
                        {canManage && <DropdownMenuItem asChild><Link href={route('project-billing.payments.edit', row.id)}><Pencil className="mr-2 size-4" /> Editar</Link></DropdownMenuItem>}
                        {canDocs && <DropdownMenuItem asChild><Link href={route('project-billing.payments.show', row.id)}><Upload className="mr-2 size-4" /> Comprobantes</Link></DropdownMenuItem>}
                        {canManage && <DropdownMenuItem asChild><Link href={route('project-billing.payments.show', row.id)}><Link2 className="mr-2 size-4" /> Aplicaciones</Link></DropdownMenuItem>}
                        {(canConfirm || canManage) && <DropdownMenuSeparator />}
                        {canConfirm && row.estado === 'registrado' && <DropdownMenuItem onClick={() => router.patch(route('project-billing.payments.confirm', row.id), {}, { preserveScroll: true })}><CheckCircle2 className="mr-2 size-4" /> Confirmar</DropdownMenuItem>}
                        {canManage && !['rechazado', 'cancelado', 'confirmado'].includes(row.estado) && <DropdownMenuItem onClick={() => setStatusAction({ payment: row, action: 'reject' })}><XCircle className="mr-2 size-4" /> Rechazar</DropdownMenuItem>}
                        {canManage && !['cancelado'].includes(row.estado) && <DropdownMenuItem variant="destructive" onClick={() => setStatusAction({ payment: row, action: 'cancel' })}><XCircle className="mr-2 size-4" /> Cancelar</DropdownMenuItem>}
                    </DropdownMenuContent>
                </DropdownMenu>
            ),
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Pagos" />
            <div className="space-y-4 p-4">
                <div className="flex flex-col gap-3 rounded-xl border bg-sidebar-accent/20 p-4 sm:flex-row sm:items-center sm:justify-between">
                    <div><h1 className="text-xl font-semibold">Pagos</h1><p className="text-sm text-muted-foreground">Pagos recibidos y aplicaciones a cargos.</p></div>
                    {canManage && <Button asChild><Link href={route('project-billing.payments.create')}><Plus className="size-4" /> Registrar pago</Link></Button>}
                </div>
                <div className="grid gap-3 md:grid-cols-5">
                    <Filter value={localFilters.cliente_id} onChange={(value) => setLocalFilters({ ...localFilters, cliente_id: value })} options={clientes.map((item) => ({ value: item.id, label: item.nombre ?? item.razon_social ?? item.id }))} placeholder="Cliente" />
                    <Filter value={localFilters.proyecto_id} onChange={(value) => setLocalFilters({ ...localFilters, proyecto_id: value })} options={proyectos.map((item) => ({ value: item.id, label: item.nombre }))} placeholder="Proyecto" />
                    <Filter value={localFilters.estado} onChange={(value) => setLocalFilters({ ...localFilters, estado: value })} options={estados.map((item) => ({ value: item, label: item }))} placeholder="Estado" />
                    <Filter value={localFilters.metodo_pago} onChange={(value) => setLocalFilters({ ...localFilters, metodo_pago: value })} options={metodos.map((item) => ({ value: item, label: item }))} placeholder="Metodo" />
                    <div className="flex gap-2"><Button onClick={() => router.get(route('project-billing.payments.index'), normalize(localFilters), { preserveState: true })}><Search className="size-4" /> Filtrar</Button><Button variant="outline" onClick={() => router.get(route('project-billing.payments.index'))}><XCircle className="size-4" /></Button></div>
                </div>
                <Card className="rounded-lg"><CardHeader><CardTitle>Listado de pagos</CardTitle></CardHeader><CardContent><DataTable columns={columns} data={payments.data} showSearch={false} emptyMessage="No hay pagos." /><Pagination links={payments.links} from={payments.from} to={payments.to} total={payments.total} /></CardContent></Card>
            </div>

            <CrudFormDialog open={statusAction !== null} onOpenChange={(open) => !open && setStatusAction(null)} title={statusAction?.action === 'reject' ? 'Rechazar pago' : 'Cancelar pago'} description="Registra el motivo para auditoria." submitLabel={statusAction?.action === 'reject' ? 'Rechazar' : 'Cancelar'} processing={statusForm.processing} onSubmit={(event: React.FormEvent<HTMLFormElement>) => {
                event.preventDefault();
                if (!statusAction) return;
                statusForm.patch(route(`project-billing.payments.${statusAction.action}`, statusAction.payment.id), { preserveScroll: true, onSuccess: () => { setStatusAction(null); statusForm.reset(); } });
            }}>
                <FormTextareaField label="Motivo" value={statusForm.data.cancellation_reason} onChange={(event) => statusForm.setData('cancellation_reason', event.target.value)} error={statusForm.errors.cancellation_reason} />
            </CrudFormDialog>
        </AppLayout>
    );
}
function Filter({ value, onChange, options, placeholder }: { value: string; onChange: (value: string) => void; options: { value: string; label: string }[]; placeholder: string }) { return <Select value={value} onValueChange={onChange}><SelectTrigger><SelectValue placeholder={placeholder} /></SelectTrigger><SelectContent><SelectItem value="todos">Todos</SelectItem>{options.map((option) => <SelectItem key={option.value} value={option.value}>{option.label}</SelectItem>)}</SelectContent></Select>; }
function Pagination({ links, from, to, total }: { links: Paginated<Payment>['links']; from: number | null; to: number | null; total: number }) { return <div className="mt-4 flex flex-wrap items-center justify-between gap-2"><p className="text-sm text-muted-foreground">Mostrando {from ?? 0}-{to ?? 0} de {total}</p><div className="flex flex-wrap gap-1">{links.map((link, index) => <Button key={index} variant={link.active ? 'default' : 'outline'} size="sm" disabled={!link.url} onClick={() => link.url && router.get(link.url)}><span dangerouslySetInnerHTML={{ __html: link.label }} /></Button>)}</div></div>; }
function StatusBadge({ status }: { status: string }) { return <Badge variant={status === 'confirmado' ? 'default' : ['rechazado', 'cancelado'].includes(status) ? 'destructive' : 'outline'}>{status}</Badge>; }
const normalize = (filters: Record<string, string>) => Object.fromEntries(Object.entries(filters).filter(([, value]) => value !== 'todos' && value !== ''));
const money = (value: string | number) => new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(Number(value ?? 0));
const date = (value: string) => new Date(value).toLocaleDateString('es-MX');
