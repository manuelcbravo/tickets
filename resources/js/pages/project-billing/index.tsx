import { Head, Link, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import { AlertTriangle, Banknote, CalendarClock, CircleDollarSign, Plus, WalletCards } from 'lucide-react';
import type React from 'react';
import { useEffect } from 'react';
import { route } from 'ziggy-js';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { ModuleHeader } from '@/components/module-header';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type Charge = {
    id: string;
    folio: string;
    concepto: string;
    fecha_vencimiento: string;
    monto: string | number;
    monto_pagado: string | number;
    saldo: string | number;
    estado: string;
    cliente?: { nombre?: string | null; razon_social?: string | null } | null;
    proyecto?: { nombre?: string | null } | null;
};

type Payment = {
    id: string;
    folio: string;
    fecha_pago: string;
    monto: string | number;
    metodo_pago: string | null;
    estado: string;
    cliente?: { nombre?: string | null; razon_social?: string | null } | null;
    proyecto?: { nombre?: string | null } | null;
};

type DebtProject = {
    id: string;
    nombre: string;
    saldo_pendiente: string | number;
    saldo_vencido: string | number;
    proximo_vencimiento_at: string | null;
    billing_status: string | null;
    cliente?: { nombre?: string | null; razon_social?: string | null } | null;
};

type ProjectWithoutPlan = {
    id: string;
    nombre: string;
    estado: string;
    criticidad: string;
    cliente?: { nombre?: string | null; razon_social?: string | null } | null;
};

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Cobranza', href: route('project-billing.dashboard') }];

export default function ProjectBillingDashboard({
    metrics,
    overdueCharges,
    recentPayments,
    debtProjects,
    projectsWithoutPlan,
}: {
    metrics: Record<string, number>;
    overdueCharges: Charge[];
    recentPayments: Payment[];
    debtProjects: DebtProject[];
    projectsWithoutPlan: ProjectWithoutPlan[];
}) {
    const { flash } = usePage<SharedData>().props;

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const chargeColumns: DataTableColumn<Charge>[] = [
        { key: 'folio', header: 'Folio', cell: (row) => <span className="font-medium">{row.folio}</span> },
        { key: 'cliente', header: 'Cliente', cell: (row) => row.cliente?.nombre ?? row.cliente?.razon_social ?? '-' },
        { key: 'proyecto', header: 'Proyecto', cell: (row) => row.proyecto?.nombre ?? '-' },
        { key: 'concepto', header: 'Concepto', cell: (row) => row.concepto },
        { key: 'fecha_vencimiento', header: 'Vencimiento', cell: (row) => date(row.fecha_vencimiento) },
        { key: 'monto', header: 'Monto', cell: (row) => money(row.monto) },
        { key: 'saldo', header: 'Saldo', cell: (row) => money(row.saldo) },
        { key: 'estado', header: 'Estado', cell: (row) => <StatusBadge status={row.estado} /> },
    ];

    const paymentColumns: DataTableColumn<Payment>[] = [
        { key: 'folio', header: 'Folio', cell: (row) => <Link className="font-medium text-primary hover:underline" href={route('project-billing.payments.show', row.id)}>{row.folio}</Link> },
        { key: 'cliente', header: 'Cliente', cell: (row) => row.cliente?.nombre ?? row.cliente?.razon_social ?? '-' },
        { key: 'proyecto', header: 'Proyecto', cell: (row) => row.proyecto?.nombre ?? '-' },
        { key: 'fecha_pago', header: 'Fecha pago', cell: (row) => date(row.fecha_pago) },
        { key: 'monto', header: 'Monto', cell: (row) => money(row.monto) },
        { key: 'metodo_pago', header: 'Metodo', cell: (row) => row.metodo_pago ?? '-' },
        { key: 'estado', header: 'Estado', cell: (row) => <StatusBadge status={row.estado} /> },
    ];

    const debtColumns: DataTableColumn<DebtProject>[] = [
        { key: 'cliente', header: 'Cliente', cell: (row) => row.cliente?.nombre ?? row.cliente?.razon_social ?? '-' },
        { key: 'nombre', header: 'Proyecto', cell: (row) => <Link className="font-medium text-primary hover:underline" href={route('proyectos.show', row.id)}>{row.nombre}</Link> },
        { key: 'saldo_pendiente', header: 'Pendiente', cell: (row) => money(row.saldo_pendiente) },
        { key: 'saldo_vencido', header: 'Vencido', cell: (row) => money(row.saldo_vencido) },
        { key: 'proximo_vencimiento_at', header: 'Proximo vencimiento', cell: (row) => row.proximo_vencimiento_at ? date(row.proximo_vencimiento_at) : '-' },
        { key: 'billing_status', header: 'Estado', cell: (row) => <StatusBadge status={row.billing_status ?? 'sin_configurar'} /> },
    ];
    const withoutPlanColumns: DataTableColumn<ProjectWithoutPlan>[] = [
        { key: 'cliente', header: 'Cliente', cell: (row) => row.cliente?.nombre ?? row.cliente?.razon_social ?? '-' },
        { key: 'nombre', header: 'Proyecto', cell: (row) => <Link className="font-medium text-primary hover:underline" href={route('proyectos.show', row.id)}>{row.nombre}</Link> },
        { key: 'estado', header: 'Estado', cell: (row) => <StatusBadge status={row.estado} /> },
        { key: 'criticidad', header: 'Criticidad', cell: (row) => <Badge variant="outline">{row.criticidad}</Badge> },
        { key: 'actions', header: 'Acciones', cell: () => <Button asChild size="sm" variant="outline"><Link href={route('project-billing.profiles.create')}>Configurar</Link></Button> },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Cobranza" />
            <div className="space-y-4 p-4">
                <ModuleHeader title="Cobranza de proyectos" description="Controla planes de cobro, cargos, pagos y saldos por proyecto. Puedes configurar proyectos de pago unico o mensualidad tipo SaaS, registrar pagos y revisar saldos vencidos.">
                    <Button asChild><Link href={route('project-billing.profiles.create')}><Plus className="size-4" /> Configurar cobranza de proyecto</Link></Button>
                    <Button asChild variant="outline"><Link href={route('project-billing.payments.create')}><Banknote className="size-4" /> Registrar pago</Link></Button>
                    <Button asChild variant="outline"><Link href={route('project-billing.charges.index')}>Ver cargos</Link></Button>
                    <Button asChild variant="outline"><Link href={route('project-billing.payments.index')}>Ver pagos</Link></Button>
                </ModuleHeader>

                <div className="grid gap-3 md:grid-cols-3 xl:grid-cols-6">
                    <Metric icon={CircleDollarSign} label="Pendiente" value={money(metrics.totalPending)} />
                    <Metric icon={AlertTriangle} label="Vencido" value={money(metrics.totalOverdue)} tone="danger" />
                    <Metric icon={Banknote} label="Pagos del mes" value={money(metrics.paymentsThisMonth)} />
                    <Metric icon={WalletCards} label="Por confirmar" value={metrics.paymentsPendingConfirmation} />
                    <Metric icon={AlertTriangle} label="Proyectos con deuda" value={metrics.projectsWithDebt} />
                    <Metric icon={CircleDollarSign} label="Sin plan" value={metrics.projectsWithoutPlan} />
                    <Metric icon={CalendarClock} label="Por vencer 7 dias" value={metrics.upcomingCharges} />
                </div>

                <Card className="rounded-lg">
                    <CardHeader><CardTitle>Proyectos sin plan de cobro</CardTitle><CardDescription>Proyectos que aun necesitan definir si se cobran como pago unico, mensualidad o parcialidades.</CardDescription></CardHeader>
                    <CardContent><DataTable columns={withoutPlanColumns} data={projectsWithoutPlan} showSearch={false} emptyMessage="Todos los proyectos recientes tienen plan de cobro." /></CardContent>
                </Card>

                <Card className="rounded-lg">
                    <CardHeader><CardTitle>Cargos vencidos</CardTitle><CardDescription>Cuentas por cobrar con saldo vencido.</CardDescription></CardHeader>
                    <CardContent><DataTable columns={chargeColumns} data={overdueCharges} showSearch={false} emptyMessage="No hay cargos vencidos." /></CardContent>
                </Card>

                <Card className="rounded-lg">
                    <CardHeader><CardTitle>Pagos recientes</CardTitle><CardDescription>Ultimos pagos registrados.</CardDescription></CardHeader>
                    <CardContent><DataTable columns={paymentColumns} data={recentPayments} showSearch={false} emptyMessage="No hay pagos recientes." /></CardContent>
                </Card>

                <Card className="rounded-lg">
                    <CardHeader><CardTitle>Proyectos con mayor saldo</CardTitle><CardDescription>Proyectos que requieren seguimiento de cobranza.</CardDescription></CardHeader>
                    <CardContent><DataTable columns={debtColumns} data={debtProjects} showSearch={false} emptyMessage="No hay proyectos con deuda." /></CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}

function Metric({ icon: Icon, label, value, tone = 'default' }: { icon: React.ComponentType<{ className?: string }>; label: string; value: string | number; tone?: 'default' | 'danger' }) {
    return (
        <Card className="rounded-lg">
            <CardContent className="flex items-center gap-3 p-4">
                <Icon className={tone === 'danger' ? 'size-5 text-destructive' : 'size-5 text-primary'} />
                <div>
                    <p className="text-xs text-muted-foreground">{label}</p>
                    <p className="font-semibold">{value}</p>
                </div>
            </CardContent>
        </Card>
    );
}

function StatusBadge({ status }: { status: string }) {
    const variant = ['vencido', 'cancelado', 'rechazado'].includes(status) ? 'destructive' : ['pagado', 'confirmado', 'al_corriente'].includes(status) ? 'default' : 'outline';
    return <Badge variant={variant}>{status.replaceAll('_', ' ')}</Badge>;
}

const money = (value: string | number) => new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(Number(value ?? 0));
const date = (value: string) => new Date(value).toLocaleDateString('es-MX');
