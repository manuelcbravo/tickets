import { Head, Link, usePage } from '@inertiajs/react';
import { AlertCircle, Bot, CheckCircle2, CircleDollarSign, Clock, Mail, Plug, Plus, ShieldCheck, Timer, Ticket, UserRound } from 'lucide-react';
import { route } from 'ziggy-js';
import { ModuleHeader } from '@/components/module-header';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type TicketDashboardMetrics = {
    openTickets: number;
    newToday: number;
    closedThisWeek: number;
    slaOverdue: number;
    slaAtRisk: number;
    assignedToMe: number;
    unassigned: number;
    timeThisWeek: number;
    pendingTriage: number;
    missingInformation: number;
    prioritized: number;
    criticalIncidents: number;
    reopenedPendingTriage: number;
    knowledgeTotal: number;
    knowledgePublished: number;
    documentedTickets: number;
    closedWithoutDocumentation: number;
    aiTicketsAnalyzed: number;
    aiAnalysesCompleted: number;
    aiAnalysesFailed: number;
    aiSuggestionsApplied: number;
    aiSuggestionsRejected: number;
    aiAverageConfidence: number;
    aiSuggestedReplies: number;
    aiChecklistsGenerated: number;
    ticketsWithCodeChanges: number;
    developmentTasksPending: number;
    developmentTasksInProgress: number;
    developmentTasksInReview: number;
    registeredPullRequests: number;
    ticketsReadyForRelease: number;
    scheduledReleases: number;
    releasedThisMonth: number;
    qaPending: number;
    qaInTesting: number;
    qaApproved: number;
    qaRejected: number;
    qaBlocked: number;
    reopenedTickets: number;
    forcedClosedTickets: number;
    averageTestsPerTicket: number;
    ticketsWithFailedTests: number;
    quotesCreatedThisMonth: number;
    quotesDraft: number;
    quotesPendingInternalApproval: number;
    quotesApprovedClient: number;
    quotesRejected: number;
    quotesConverted: number;
    quotedAmountTotal: number;
    quotedAmountApproved: number;
    ticketsRequiresQuote: number;
    ticketsOutOfScopeDetected: number;
    activeIntegrations: number;
    webhooksReceivedToday: number;
    webhooksFailed: number;
    unlinkedEvents: number;
    notificationsSent: number;
    notificationsFailed: number;
    externalMessagesReceived: number;
    externalMessagesWithoutTicket: number;
    linkedPullRequests: number;
    linkedCommits: number;
};

type SlaRow = {
    id: string;
    estado_sla: string;
    vence_resolucion_at: string | null;
    ticket?: {
        id: string;
        folio: string;
        titulo: string;
        cliente?: { nombre: string | null } | null;
        proyecto?: { nombre: string | null } | null;
        responsable?: { name: string } | null;
    } | null;
    prioridad?: { nombre: string } | null;
};

type ResponsibleRow = {
    responsable: string;
    open_tickets: number;
    overdue_tickets: number;
    time_this_week: number;
};

type PriorityRow = {
    prioridad: string;
    total: number;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Tickets', href: route('tickets.dashboard') },
    { title: 'Dashboard', href: route('tickets.dashboard') },
];

const metricCards = [
    { title: 'Tickets abiertos', description: 'Tickets activos sin cierre.', icon: Ticket, key: 'openTickets' },
    { title: 'Tickets nuevos hoy', description: 'Entradas creadas durante el dia.', icon: Clock, key: 'newToday' },
    { title: 'Cerrados esta semana', description: 'Resoluciones registradas esta semana.', icon: CheckCircle2, key: 'closedThisWeek' },
    { title: 'Vencidos por SLA', description: 'Tickets abiertos fuera de tiempo.', icon: AlertCircle, key: 'slaOverdue' },
    { title: 'En riesgo de vencer', description: 'Menos del 20% de tiempo restante.', icon: AlertCircle, key: 'slaAtRisk' },
    { title: 'Mis tickets asignados', description: 'Tickets abiertos a tu cargo.', icon: UserRound, key: 'assignedToMe' },
    { title: 'Sin responsable', description: 'Tickets abiertos sin asignacion.', icon: Ticket, key: 'unassigned' },
    { title: 'Tiempo esta semana', description: 'Tiempo registrado en tickets.', icon: Timer, key: 'timeThisWeek', format: 'time' },
    { title: 'Articulos knowledge', description: 'Total de articulos documentados.', icon: CheckCircle2, key: 'knowledgeTotal' },
    { title: 'Knowledge publicado', description: 'Articulos disponibles para consulta.', icon: CheckCircle2, key: 'knowledgePublished' },
    { title: 'Tickets documentados', description: 'Tickets con articulo relacionado.', icon: Ticket, key: 'documentedTickets' },
    { title: 'Cerrados sin doc.', description: 'Tickets cerrados sin documentacion.', icon: AlertCircle, key: 'closedWithoutDocumentation' },
    { title: 'Tickets analizados IA', description: 'Tickets con al menos un analisis.', icon: Bot, key: 'aiTicketsAnalyzed' },
    { title: 'Analisis IA completos', description: 'Analisis completados correctamente.', icon: Bot, key: 'aiAnalysesCompleted' },
    { title: 'Analisis IA fallidos', description: 'Ejecuciones con error controlado.', icon: AlertCircle, key: 'aiAnalysesFailed' },
    { title: 'Sugerencias aplicadas', description: 'Aplicadas por usuario humano.', icon: CheckCircle2, key: 'aiSuggestionsApplied' },
    { title: 'Sugerencias rechazadas', description: 'Rechazos auditados.', icon: AlertCircle, key: 'aiSuggestionsRejected' },
    { title: 'Confianza promedio', description: 'Promedio de confianza IA.', icon: Bot, key: 'aiAverageConfidence', format: 'percent' },
    { title: 'Respuestas sugeridas', description: 'Borradores generados por IA.', icon: Bot, key: 'aiSuggestedReplies' },
    { title: 'Checklists IA', description: 'Checklists sugeridos por IA.', icon: Bot, key: 'aiChecklistsGenerated' },
    { title: 'Con cambios de codigo', description: 'Tickets con trabajo tecnico ligado.', icon: Ticket, key: 'ticketsWithCodeChanges' },
    { title: 'Tareas pendientes', description: 'Tareas tecnicas aun sin iniciar.', icon: Clock, key: 'developmentTasksPending' },
    { title: 'En desarrollo', description: 'Tareas tecnicas en curso.', icon: Clock, key: 'developmentTasksInProgress' },
    { title: 'En revision', description: 'PRs o tareas pendientes de revisar.', icon: AlertCircle, key: 'developmentTasksInReview' },
    { title: 'PRs registrados', description: 'Pull requests capturados manualmente.', icon: CheckCircle2, key: 'registeredPullRequests' },
    { title: 'Listos para release', description: 'Tickets con estado tecnico listo.', icon: Ticket, key: 'ticketsReadyForRelease' },
    { title: 'Releases programados', description: 'Liberaciones pendientes.', icon: Clock, key: 'scheduledReleases' },
    { title: 'Liberados este mes', description: 'Releases marcados como liberados.', icon: CheckCircle2, key: 'releasedThisMonth' },
    { title: 'Pendientes QA', description: 'Tickets esperando pruebas.', icon: ShieldCheck, key: 'qaPending' },
    { title: 'En pruebas', description: 'Tickets en ciclo de QA.', icon: ShieldCheck, key: 'qaInTesting' },
    { title: 'QA aprobados', description: 'Tickets con QA aprobado.', icon: CheckCircle2, key: 'qaApproved' },
    { title: 'QA rechazados', description: 'Tickets rechazados por QA.', icon: AlertCircle, key: 'qaRejected' },
    { title: 'QA bloqueados', description: 'Tickets bloqueados por QA.', icon: AlertCircle, key: 'qaBlocked' },
    { title: 'Tickets reabiertos', description: 'Tickets con reaperturas registradas.', icon: ShieldCheck, key: 'reopenedTickets' },
    { title: 'Cierres forzados', description: 'Cierres con justificacion QA.', icon: AlertCircle, key: 'forcedClosedTickets' },
    { title: 'Pruebas promedio', description: 'Promedio de pruebas por ticket.', icon: ShieldCheck, key: 'averageTestsPerTicket' },
    { title: 'Con pruebas fallidas', description: 'Tickets con fallas de prueba.', icon: AlertCircle, key: 'ticketsWithFailedTests' },
    { title: 'Cotizaciones del mes', description: 'Propuestas comerciales creadas.', icon: CircleDollarSign, key: 'quotesCreatedThisMonth' },
    { title: 'Cotizaciones borrador', description: 'Propuestas aun sin aprobar.', icon: CircleDollarSign, key: 'quotesDraft' },
    { title: 'Revision interna', description: 'Cotizaciones pendientes de visto bueno.', icon: Clock, key: 'quotesPendingInternalApproval' },
    { title: 'Aprobadas cliente', description: 'Cotizaciones con aprobacion cliente.', icon: CheckCircle2, key: 'quotesApprovedClient' },
    { title: 'Rechazadas', description: 'Cotizaciones rechazadas por cliente.', icon: AlertCircle, key: 'quotesRejected' },
    { title: 'Convertidas', description: 'Cotizaciones convertidas en tickets.', icon: CheckCircle2, key: 'quotesConverted' },
    { title: 'Monto cotizado', description: 'Total historico cotizado.', icon: CircleDollarSign, key: 'quotedAmountTotal', format: 'money' },
    { title: 'Monto aprobado', description: 'Total aprobado o convertido.', icon: CircleDollarSign, key: 'quotedAmountApproved', format: 'money' },
    { title: 'Tickets requieren cot.', description: 'Tickets marcados fuera de alcance.', icon: Ticket, key: 'ticketsRequiresQuote' },
    { title: 'Alcance pendiente', description: 'Tickets sujetos a cotizacion sin aprobacion.', icon: AlertCircle, key: 'ticketsOutOfScopeDetected' },
    { title: 'Integraciones activas', description: 'Canales externos habilitados.', icon: Plug, key: 'activeIntegrations' },
    { title: 'Webhooks hoy', description: 'Eventos externos recibidos hoy.', icon: Plug, key: 'webhooksReceivedToday' },
    { title: 'Webhooks fallidos', description: 'Eventos con error de procesamiento.', icon: AlertCircle, key: 'webhooksFailed' },
    { title: 'Eventos sin vincular', description: 'Eventos pendientes de ticket.', icon: AlertCircle, key: 'unlinkedEvents' },
    { title: 'Notificaciones enviadas', description: 'Comunicaciones salientes exitosas.', icon: Mail, key: 'notificationsSent' },
    { title: 'Notificaciones fallidas', description: 'Envios con error registrado.', icon: AlertCircle, key: 'notificationsFailed' },
    { title: 'Mensajes recibidos', description: 'Mensajes externos inbound.', icon: Mail, key: 'externalMessagesReceived' },
    { title: 'Mensajes sin ticket', description: 'Mensajes pendientes de vincular.', icon: Mail, key: 'externalMessagesWithoutTicket' },
    { title: 'PR/MR vinculados', description: 'Eventos Git ligados a tickets.', icon: Plug, key: 'linkedPullRequests' },
    { title: 'Commits vinculados', description: 'Commits o pushes ligados a tickets.', icon: Plug, key: 'linkedCommits' },
] satisfies {
    title: string;
    description: string;
    icon: typeof Ticket;
    key: keyof TicketDashboardMetrics;
    format?: 'time' | 'percent' | 'money';
}[];

export default function TicketsDashboard({
    metrics,
    overdueTickets,
    riskTickets,
    loadByResponsible,
    ticketsByPriority,
}: {
    metrics: TicketDashboardMetrics;
    overdueTickets: SlaRow[];
    riskTickets: SlaRow[];
    loadByResponsible: ResponsibleRow[];
    ticketsByPriority: PriorityRow[];
}) {
    const permissions = usePage<SharedData>().props.auth.permissions ?? [];
    const canCreateTicket = permissions.includes('tickets.create');

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Tickets - Dashboard" />

            <div className="space-y-4 rounded-xl p-4">
                <ModuleHeader title="Dashboard de tickets" description="Centraliza indicadores operativos de tickets, carga de trabajo, SLA, tiempos, vencimientos y riesgo para priorizar la atencion diaria.">
                    {canCreateTicket && <Button asChild><Link href={route('tickets.create')}><Plus className="size-4" /> Nuevo ticket</Link></Button>}
                </ModuleHeader>

                <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    {metricCards.map((metric) => (
                        <Card key={metric.title} className="rounded-lg">
                            <CardHeader className="flex flex-row items-start justify-between space-y-0">
                                <div className="space-y-1">
                                    <CardTitle>{metric.title}</CardTitle>
                                    <CardDescription>{metric.description}</CardDescription>
                                </div>
                                <metric.icon className="size-5 text-muted-foreground" />
                            </CardHeader>
                            <CardContent>
                                <p className="text-3xl font-semibold">{formatMetric(metrics[metric.key], metric.format)}</p>
                            </CardContent>
                        </Card>
                    ))}
                </div>

                <div className="grid gap-4 xl:grid-cols-2">
                    <SlaTable title="Tickets vencidos" rows={overdueTickets} />
                    <SlaTable title="Tickets en riesgo" rows={riskTickets} />
                </div>

                <div className="grid gap-4 xl:grid-cols-2">
                    <Card className="rounded-lg">
                        <CardHeader><CardTitle>Carga por responsable</CardTitle></CardHeader>
                        <CardContent>
                            <Table>
                                <TableHeader><TableRow><TableHead>Responsable</TableHead><TableHead>Abiertos</TableHead><TableHead>Vencidos</TableHead><TableHead>Tiempo semana</TableHead></TableRow></TableHeader>
                                <TableBody>
                                    {loadByResponsible.map((row) => (
                                        <TableRow key={row.responsable}>
                                            <TableCell>{row.responsable}</TableCell>
                                            <TableCell>{row.open_tickets}</TableCell>
                                            <TableCell>{row.overdue_tickets}</TableCell>
                                            <TableCell>{formatMinutes(row.time_this_week)}</TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </CardContent>
                    </Card>

                    <Card className="rounded-lg">
                        <CardHeader><CardTitle>Tickets por prioridad</CardTitle></CardHeader>
                        <CardContent className="space-y-2">
                            {ticketsByPriority.map((row) => (
                                <div key={row.prioridad} className="flex items-center justify-between rounded-md border p-3 text-sm">
                                    <Badge variant={row.prioridad.startsWith('P0') ? 'destructive' : 'secondary'}>{row.prioridad}</Badge>
                                    <span className="font-medium">{row.total}</span>
                                </div>
                            ))}
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppLayout>
    );
}

function SlaTable({ title, rows }: { title: string; rows: SlaRow[] }) {
    return (
        <Card className="rounded-lg">
            <CardHeader><CardTitle>{title}</CardTitle></CardHeader>
            <CardContent>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Folio</TableHead>
                            <TableHead>Cliente</TableHead>
                            <TableHead>Prioridad</TableHead>
                            <TableHead>Responsable</TableHead>
                            <TableHead>Vence resolucion</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        {rows.length === 0 ? (
                            <TableRow><TableCell colSpan={5} className="text-muted-foreground">Sin tickets.</TableCell></TableRow>
                        ) : rows.map((row) => (
                            <TableRow key={row.id}>
                                <TableCell><Link className="font-medium text-primary hover:underline" href={route('tickets.show', row.ticket?.id)}>{row.ticket?.folio}</Link></TableCell>
                                <TableCell>{row.ticket?.cliente?.nombre ?? '-'}</TableCell>
                                <TableCell><Badge variant={row.prioridad?.nombre?.startsWith('P0') ? 'destructive' : 'secondary'}>{row.prioridad?.nombre ?? '-'}</Badge></TableCell>
                                <TableCell>{row.ticket?.responsable?.name ?? '-'}</TableCell>
                                <TableCell>{row.vence_resolucion_at ? new Date(row.vence_resolucion_at).toLocaleString('es-MX') : '-'}</TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </CardContent>
        </Card>
    );
}

function formatMinutes(minutes: number) {
    if (minutes < 60) return `${minutes} min`;
    const hours = Math.floor(minutes / 60);
    const rest = minutes % 60;
    return rest > 0 ? `${hours} h ${rest} min` : `${hours} h`;
}

function formatMetric(value: number, format?: 'time' | 'percent' | 'money') {
    if (format === 'time') return formatMinutes(value);
    if (format === 'percent') return `${value}%`;
    if (format === 'money') return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value);
    return value;
}
