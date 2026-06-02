import { Head, Link, usePage } from '@inertiajs/react';
import { Banknote, Boxes, Cloud, FileText, KanbanSquare, ListChecks, Pencil, Receipt, Ticket, WalletCards } from 'lucide-react';
import type React from 'react';
import { route } from 'ziggy-js';
import { ModuleHeader } from '@/components/module-header';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type Proyecto = {
    id: string;
    nombre: string;
    descripcion: string | null;
    url_produccion: string | null;
    url_staging: string | null;
    repositorio_url: string | null;
    documentacion_url: string | null;
    tecnologia: string | null;
    estado: string;
    criticidad: string;
    estado_planeacion: string | null;
    prioridad_planeacion: string | null;
    avance_porcentaje: number | null;
    fecha_inicio: string | null;
    fecha_objetivo: string | null;
    billing_status: string | null;
    proximo_vencimiento_at: string | null;
    cliente?: { id: string; nombre: string | null; razon_social: string | null; estatus?: string | null } | null;
    responsable_tecnico?: { id: number; name: string } | null;
    responsable_planeacion?: { id: number; name: string } | null;
    plan_cobro?: { id: string; tipo_cobro: string; estado: string; activo: boolean; monto_total: string | number | null; monto_mensual: string | number | null; fecha_inicio: string | null; fecha_fin: string | null } | null;
};

type Summary = {
    total_documentos: number;
    total_actividades: number;
    actividades_pendientes: number;
    actividades_vencidas: number;
    avance_calculado: number;
    tiempo_estimado: number;
    tiempo_real: number;
    total_tickets: number;
    tickets_abiertos: number;
    saldo_pendiente: number;
    saldo_vencido: number;
    total_cargos: number;
    total_pagos: number;
    total_ambientes: number;
    total_modulos: number;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Proyectos', href: route('proyectos.index') },
];

export default function ProyectoShow({ proyecto, summary }: { proyecto: Proyecto; summary: Summary }) {
    const permissions = usePage<SharedData>().props.auth.permissions ?? [];
    const canManage = permissions.includes('proyectos.manage');
    const cards = [
        canManage && section('Informacion general', 'Actualiza datos base, cliente, responsable tecnico y URLs principales.', 'Editar proyecto', route('proyectos.edit', proyecto.id), Pencil, '-'),
        canManage && section('Ambientes', 'Administra produccion, staging, demos y ambientes tecnicos.', 'Abrir ambientes', route('proyectos.ambientes.index', proyecto.id), Cloud, String(summary.total_ambientes)),
        canManage && section('Modulos', 'Gestiona modulos funcionales usados para clasificar tickets.', 'Abrir modulos', route('proyectos.modulos.index', proyecto.id), Boxes, String(summary.total_modulos)),
        can('project-planning.documents.view', 'project-planning.documents.manage') && section('Documentos', 'Consulta y administra contratos, requerimientos, manuales y documentacion tecnica.', 'Abrir documentos', route('proyectos.documents.index', proyecto.id), FileText, String(summary.total_documentos)),
        can('project-planning.activities.view', 'project-planning.activities.manage') && section('Actividades', 'Gestiona tareas internas, responsables, estados y tiempos.', 'Abrir actividades', route('proyectos.activities.index', proyecto.id), ListChecks, `${summary.actividades_pendientes} pendientes`),
        can('project-planning.kanban.view', 'project-planning.kanban.manage') && section('Kanban', 'Visualiza el flujo de trabajo del proyecto por columnas.', 'Abrir kanban', route('proyectos.activities.kanban.index', proyecto.id), KanbanSquare, `${summary.actividades_vencidas} vencidas`),
        can('tickets.view', 'tickets.manage') && section('Tickets', 'Consulta solicitudes relacionadas al proyecto y su estado.', 'Abrir tickets', route('proyectos.tickets.index', proyecto.id), Ticket, `${summary.tickets_abiertos} abiertos`),
        can('project-billing.view', 'project-billing.reports', 'project-billing.manage') && section('Cobranza', 'Consulta plan de cobro, saldos, cargos y pagos del proyecto.', 'Abrir cobranza', route('proyectos.billing.index', proyecto.id), Banknote, money(summary.saldo_pendiente)),
        can('project-billing.charges.view', 'project-billing.charges.manage') && section('Cargos', 'Revisa cuentas por cobrar, vencimientos y saldos.', 'Abrir cargos', route('proyectos.billing.charges.index', proyecto.id), Receipt, String(summary.total_cargos)),
        can('project-billing.payments.view', 'project-billing.payments.manage') && section('Pagos', 'Consulta pagos registrados y aplicaciones.', 'Abrir pagos', route('proyectos.billing.payments.index', proyecto.id), WalletCards, String(summary.total_pagos)),
    ].filter(Boolean) as SectionCard[];

    function can(...items: string[]) {
        return permissions.some((permission) => items.includes(permission));
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={proyecto.nombre} />
            <div className="space-y-4 p-4">
                <ModuleHeader
                    title={proyecto.nombre}
                    description={proyecto.descripcion ?? 'Resumen del proyecto y accesos a sus secciones operativas.'}
                >
                    <Badge variant="outline">{proyecto.estado}</Badge>
                    <Badge variant={proyecto.criticidad === 'critica' ? 'destructive' : 'secondary'}>{proyecto.criticidad}</Badge>
                </ModuleHeader>

                <div className="grid gap-4 lg:grid-cols-3">
                    <Card className="rounded-lg lg:col-span-2">
                        <CardHeader>
                            <CardTitle>Datos principales</CardTitle>
                            <CardDescription>Informacion compacta del proyecto. Las operaciones viven en pantallas separadas.</CardDescription>
                        </CardHeader>
                        <CardContent className="grid gap-3 md:grid-cols-2">
                            <Info label="Cliente" value={proyecto.cliente?.nombre ?? proyecto.cliente?.razon_social} />
                            <Info label="Responsable tecnico" value={proyecto.responsable_tecnico?.name} />
                            <Info label="Tecnologia" value={proyecto.tecnologia} />
                            <Info label="URL produccion" value={proyecto.url_produccion} />
                            <Info label="URL staging" value={proyecto.url_staging} />
                            <Info label="Documentacion" value={proyecto.documentacion_url} />
                        </CardContent>
                    </Card>

                    <Card className="rounded-lg">
                        <CardHeader>
                            <CardTitle>Estado operativo</CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-3 text-sm">
                            <Info label="Planeacion" value={proyecto.estado_planeacion} />
                            <Info label="Responsable planeacion" value={proyecto.responsable_planeacion?.name} />
                            <Info label="Avance calculado" value={`${summary.avance_calculado}%`} />
                            <Info label="Billing" value={proyecto.billing_status ?? 'sin_configurar'} />
                            <Info label="Proximo vencimiento" value={date(proyecto.proximo_vencimiento_at)} />
                        </CardContent>
                    </Card>
                </div>

                <div className="grid gap-3 md:grid-cols-2 xl:grid-cols-4">
                    <Metric title="Actividades" value={summary.total_actividades} detail={`${summary.actividades_pendientes} pendientes`} />
                    <Metric title="Tickets" value={summary.total_tickets} detail={`${summary.tickets_abiertos} abiertos`} />
                    <Metric title="Saldo pendiente" value={money(summary.saldo_pendiente)} detail={`${money(summary.saldo_vencido)} vencido`} danger={summary.saldo_vencido > 0} />
                    <Metric title="Tiempo real" value={formatMinutes(summary.tiempo_real)} detail={`Estimado ${formatMinutes(summary.tiempo_estimado)}`} />
                </div>

                <section className="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    {cards.map((card) => (
                        <Card key={card.title} className="rounded-lg">
                            <CardHeader>
                                <div className="flex items-start justify-between gap-3">
                                    <div>
                                        <CardTitle className="flex items-center gap-2 text-base">
                                            <card.icon className="size-4 text-primary" />
                                            {card.title}
                                        </CardTitle>
                                        <CardDescription className="mt-1">{card.description}</CardDescription>
                                    </div>
                                    <Badge variant="outline">{card.value}</Badge>
                                </div>
                            </CardHeader>
                            <CardContent>
                                <Button asChild variant="outline" className="w-full">
                                    <Link href={card.href}>{card.action}</Link>
                                </Button>
                            </CardContent>
                        </Card>
                    ))}
                </section>
            </div>
        </AppLayout>
    );
}

type SectionCard = {
    title: string;
    description: string;
    action: string;
    href: string;
    icon: React.ComponentType<{ className?: string }>;
    value: string;
};

function section(title: string, description: string, action: string, href: string, icon: SectionCard['icon'], value: string): SectionCard {
    return { title, description, action, href, icon, value };
}

function Info({ label, value }: { label: string; value?: string | null }) {
    return <div className="rounded-md border p-3"><p className="text-xs text-muted-foreground">{label}</p><p className="text-sm font-medium break-words">{value || '-'}</p></div>;
}

function Metric({ title, value, detail, danger = false }: { title: string; value: string | number; detail: string; danger?: boolean }) {
    return <Card className="rounded-lg"><CardContent className="p-4"><p className="text-xs text-muted-foreground">{title}</p><p className={danger ? 'text-lg font-semibold text-destructive' : 'text-lg font-semibold'}>{value}</p><p className="text-xs text-muted-foreground">{detail}</p></CardContent></Card>;
}

const money = (value: string | number) => new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(Number(value ?? 0));

function date(value?: string | null) {
    if (!value) return '-';
    return new Intl.DateTimeFormat('es-MX', { day: '2-digit', month: '2-digit', year: 'numeric' }).format(new Date(value));
}

function formatMinutes(minutes: number) {
    if (minutes < 60) return `${minutes} min`;
    const hours = Math.floor(minutes / 60);
    const rest = minutes % 60;
    return rest > 0 ? `${hours} h ${rest} min` : `${hours} h`;
}
