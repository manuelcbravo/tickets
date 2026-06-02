import { Head, Link, usePage } from '@inertiajs/react';
import { Banknote, Plus, Receipt, WalletCards } from 'lucide-react';
import { useEffect } from 'react';
import { toast } from 'sonner';
import { route } from 'ziggy-js';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { ModuleHeader } from '@/components/module-header';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type Proyecto = { id: string; nombre: string; cliente?: { nombre: string | null; razon_social: string | null } | null };
type BillingPlan = { id: string; tipo_cobro: string; moneda: string; monto_total: string | number | null; monto_mensual: string | number | null; dia_vencimiento: number | null; fecha_inicio: string | null; fecha_fin: string | null; estado: string; activo: boolean };
type BillingCharge = { id: string; folio: string; concepto: string; fecha_vencimiento: string; monto: string | number; monto_pagado: string | number; saldo: string | number; estado: string };
type BillingPayment = { id: string; folio: string; fecha_pago: string; monto: string | number; metodo_pago: string | null; estado: string };
type BillingPayload = {
    plan: BillingPlan | null;
    cargos: BillingCharge[];
    pagos: BillingPayment[];
    summary: { total_cargado: number; total_pagado: number; saldo_pendiente: number; saldo_vencido: number; ultimo_pago_at: string | null; proximo_vencimiento_at: string | null; billing_status: string | null };
};

export default function ProjectBillingIndex({ proyecto, billing }: { proyecto: Proyecto; billing: BillingPayload }) {
    const { flash, auth } = usePage<SharedData>().props;
    const permissions = auth.permissions ?? [];
    const canManageBilling = permissions.includes('project-billing.manage');
    const canManagePayments = permissions.includes('project-billing.payments.manage');

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Proyectos', href: route('proyectos.index') },
        { title: proyecto.nombre, href: route('proyectos.show', proyecto.id) },
        { title: 'Cobranza', href: route('proyectos.billing.index', proyecto.id) },
    ];

    const chargeColumns: DataTableColumn<BillingCharge>[] = [
        { key: 'folio', header: 'Folio', cell: (row) => row.folio },
        { key: 'concepto', header: 'Concepto', cell: (row) => row.concepto },
        { key: 'fecha', header: 'Vence', cell: (row) => date(row.fecha_vencimiento) },
        { key: 'monto', header: 'Monto', cell: (row) => money(row.monto) },
        { key: 'saldo', header: 'Saldo', cell: (row) => money(row.saldo) },
        { key: 'estado', header: 'Estado', cell: (row) => <StatusBadge status={row.estado} /> },
    ];

    const paymentColumns: DataTableColumn<BillingPayment>[] = [
        { key: 'folio', header: 'Folio', cell: (row) => <Link className="font-medium text-primary hover:underline" href={route('project-billing.payments.show', row.id)}>{row.folio}</Link> },
        { key: 'fecha', header: 'Fecha', cell: (row) => date(row.fecha_pago) },
        { key: 'monto', header: 'Monto', cell: (row) => money(row.monto) },
        { key: 'metodo', header: 'Metodo', cell: (row) => row.metodo_pago ?? '-' },
        { key: 'estado', header: 'Estado', cell: (row) => <StatusBadge status={row.estado} /> },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Cobranza - ${proyecto.nombre}`} />
            <div className="space-y-4 p-4">
                <ModuleHeader title="Cobranza del proyecto" description="Plan de cobro, saldos, cargos y pagos del proyecto.">
                    <Button asChild variant="outline"><Link href={route('proyectos.show', proyecto.id)}>Volver al resumen</Link></Button>
                    {canManageBilling && <Button asChild><Link href={route('project-billing.profiles.create')}><Banknote className="size-4" /> Configurar plan</Link></Button>}
                    {canManagePayments && <Button asChild variant="outline"><Link href={route('project-billing.payments.create')}><Plus className="size-4" /> Registrar pago</Link></Button>}
                </ModuleHeader>

                <div className="grid gap-3 md:grid-cols-4">
                    <Metric title="Total cargado" value={money(billing.summary.total_cargado)} />
                    <Metric title="Total pagado" value={money(billing.summary.total_pagado)} />
                    <Metric title="Saldo pendiente" value={money(billing.summary.saldo_pendiente)} />
                    <Metric title="Saldo vencido" value={money(billing.summary.saldo_vencido)} danger={billing.summary.saldo_vencido > 0} />
                </div>

                <Card className="rounded-lg">
                    <CardHeader><CardTitle>Plan de cobro</CardTitle><CardDescription>Configuracion vigente para generar cargos y vencimientos.</CardDescription></CardHeader>
                    <CardContent className="grid gap-3 md:grid-cols-3">
                        {billing.plan ? (
                            <>
                                <Info label="Tipo" value={billing.plan.tipo_cobro} />
                                <Info label="Estado" value={billing.plan.estado} />
                                <Info label="Monto total" value={billing.plan.monto_total ? money(billing.plan.monto_total) : '-'} />
                                <Info label="Monto mensual" value={billing.plan.monto_mensual ? money(billing.plan.monto_mensual) : '-'} />
                                <Info label="Fecha inicio" value={date(billing.plan.fecha_inicio)} />
                                <Info label="Fecha fin" value={date(billing.plan.fecha_fin)} />
                            </>
                        ) : (
                            <p className="text-sm text-muted-foreground md:col-span-3">Este proyecto aun no tiene plan de cobro configurado.</p>
                        )}
                    </CardContent>
                </Card>

                <Card className="rounded-lg">
                    <CardHeader className="flex flex-row items-center justify-between"><CardTitle className="flex items-center gap-2"><Receipt className="size-5" /> Cargos recientes</CardTitle><Button asChild variant="outline"><Link href={route('proyectos.billing.charges.index', proyecto.id)}>Ver cargos</Link></Button></CardHeader>
                    <CardContent><DataTable columns={chargeColumns} data={billing.cargos} showSearch={false} emptyMessage="Este proyecto aun no tiene cargos." /></CardContent>
                </Card>

                <Card className="rounded-lg">
                    <CardHeader className="flex flex-row items-center justify-between"><CardTitle className="flex items-center gap-2"><WalletCards className="size-5" /> Pagos recientes</CardTitle><Button asChild variant="outline"><Link href={route('proyectos.billing.payments.index', proyecto.id)}>Ver pagos</Link></Button></CardHeader>
                    <CardContent><DataTable columns={paymentColumns} data={billing.pagos} showSearch={false} emptyMessage="Este proyecto aun no tiene pagos." /></CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}

function Metric({ title, value, danger = false }: { title: string; value: string; danger?: boolean }) {
    return <Card className="rounded-lg"><CardContent className="p-4"><p className="text-xs text-muted-foreground">{title}</p><p className={danger ? 'font-semibold text-destructive' : 'font-semibold'}>{value}</p></CardContent></Card>;
}

function Info({ label, value }: { label: string; value?: string | null }) {
    return <div className="rounded-md border p-3"><p className="text-xs text-muted-foreground">{label}</p><p className="text-sm font-medium">{value || '-'}</p></div>;
}

function StatusBadge({ status }: { status: string }) {
    return <Badge variant={status === 'vencido' || status === 'cancelado' ? 'destructive' : status === 'pagado' || status === 'confirmado' ? 'default' : 'outline'}>{status.replaceAll('_', ' ')}</Badge>;
}

const money = (value: string | number) => new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(Number(value ?? 0));

function date(value?: string | null) {
    if (!value) return '-';
    return new Intl.DateTimeFormat('es-MX', { day: '2-digit', month: '2-digit', year: 'numeric' }).format(new Date(value));
}
