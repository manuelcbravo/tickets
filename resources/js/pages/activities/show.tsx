import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import {
    ArrowLeft,
    Ban,
    CheckSquare2,
    Clock,
    FolderOpen,
    ExternalLink,
    FileText,
    KanbanSquare,
    Link2,
    MessageSquare,
    Paperclip,
    Pencil,
    Plus,
    Ticket,
} from 'lucide-react';
import type React from 'react';
import { useEffect, useState } from 'react';
import { toast } from 'sonner';
import { route } from 'ziggy-js';
import { FilePickerDialog } from '@/components/file-picker-dialog';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { LoadingSubmitButton } from '@/components/loading-submit-button';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type ActivityTime = {
    id: string;
    descripcion: string;
    minutos: number;
    fecha: string;
    created_at?: string | null;
    usuario?: { id: number; name: string } | null;
};

type ActivityTicketLink = {
    id: string;
    tipo_relacion: string;
    ticket?: { id: string; folio: string | null; titulo: string } | null;
};

type StoredFile = {
    id: string;
    original_name: string;
    path: string;
    url: string;
    mime_type: string | null;
    size: number;
};

type RelatedActivity = {
    id: string;
    titulo: string;
    estado: string;
    prioridad?: string | null;
    kanban_column?: string | null;
};

type Activity = {
    id: string;
    titulo: string;
    descripcion: string | null;
    tipo: string;
    estado: string;
    prioridad: string;
    kanban_column: string;
    responsable_id: number | null;
    reportado_por_id: number | null;
    ticket_id: string | null;
    parent_id: string | null;
    fecha_inicio: string | null;
    fecha_limite: string | null;
    minutos_estimados: number | null;
    minutos_reales: number;
    tags: string[] | null;
    proyecto: {
        id: string;
        nombre: string;
        cliente?: {
            id: string;
            nombre: string | null;
            razon_social: string | null;
        } | null;
    };
    responsable?: { id: number; name: string } | null;
    reportado_por?: { id: number; name: string } | null;
    created_by?: { id: number; name: string } | null;
    updated_by?: { id: number; name: string } | null;
    ticket?: { id: string; folio: string | null; titulo: string } | null;
    parent?: RelatedActivity | null;
    children?: RelatedActivity[];
    ticket_links?: ActivityTicketLink[];
    tiempos?: ActivityTime[];
    files?: StoredFile[];
};

type ActivityForm = {
    titulo: string;
    descripcion: string;
    tipo: string;
    estado: string;
    prioridad: string;
    responsable_id: string;
    ticket_id: string;
    parent_id: string;
    fecha_inicio: string;
    fecha_limite: string;
    minutos_estimados: string;
    tags: string[];
};

type ActivityOption = {
    title: string;
    description: string;
    action: string;
    value: string;
    icon: React.ComponentType<{ className?: string }>;
    href?: string;
    onClick?: () => void;
    variant?: 'default' | 'outline' | 'secondary' | 'destructive';
};

function label(value: string): string {
    return value.replaceAll('_', ' ');
}

function formatMinutes(minutes: number | null | undefined): string {
    if (!minutes) return '0 min';
    const hours = Math.floor(minutes / 60);
    const remaining = minutes % 60;
    if (hours === 0) return `${remaining} min`;
    return remaining > 0 ? `${hours} h ${remaining} min` : `${hours} h`;
}

function formatDate(value: string | null | undefined): string {
    if (!value) return '-';

    const hasTime = /T|\d{2}:\d{2}/.test(value);
    const normalized = hasTime ? value : `${value.slice(0, 10)}T00:00:00`;
    const date = new Date(normalized);

    if (Number.isNaN(date.getTime())) return '-';

    return new Intl.DateTimeFormat('es-MX', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        ...(hasTime
            ? { hour: '2-digit', minute: '2-digit', hour12: true }
            : {}),
    }).format(date);
}

function initials(name?: string | null): string {
    return (name ?? 'S')
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part[0])
        .join('')
        .toUpperCase();
}

export default function ActivityShow({ activity }: { activity: Activity }) {
    const page = usePage<SharedData>();
    const permissions = page.props.auth.permissions ?? [];
    const { flash } = page.props;
    const [filesOpen, setFilesOpen] = useState(false);
    const canManage = permissions.includes(
        'project-planning.activities.manage',
    );
    const canRegisterTime = permissions.includes(
        'project-planning.activities.time',
    );
    const canMoveKanban = permissions.includes(
        'project-planning.kanban.manage',
    );
    const canCreateTicket = permissions.includes('tickets.create');
    const canViewTickets =
        permissions.includes('tickets.view') ||
        permissions.includes('tickets.manage');
    const canViewProject = permissions.includes('proyectos.view');
    const projectId = activity.proyecto.id;
    const commentsCount = activity.tiempos?.length ?? 0;
    const filesCount = activity.files?.length ?? 0;
    const relatedTicketsCount =
        (activity.ticket ? 1 : 0) + (activity.ticket_links?.length ?? 0);
    const childrenCount = activity.children?.length ?? 0;

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash]);

    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Tickets', href: route('tickets.dashboard') },
        { title: 'Actividades', href: route('activities.index') },
        {
            title: 'Resumen',
            href: route('activities.show', activity.id),
        },
    ];

    const form = useForm<ActivityForm>({
        titulo: activity.titulo,
        descripcion: activity.descripcion ?? '',
        tipo: activity.tipo,
        estado: activity.estado,
        prioridad: activity.prioridad,
        responsable_id: activity.responsable_id
            ? String(activity.responsable_id)
            : '',
        ticket_id: activity.ticket_id ?? '',
        parent_id: activity.parent_id ?? '',
        fecha_inicio: activity.fecha_inicio?.slice(0, 10) ?? '',
        fecha_limite: activity.fecha_limite?.slice(0, 10) ?? '',
        minutos_estimados: activity.minutos_estimados
            ? String(activity.minutos_estimados)
            : '',
        tags: activity.tags ?? [],
    });

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        form.patch(route('activities.update', activity.id), {
            preserveScroll: true,
        });
    };

    const completeActivity = () => {
        router.patch(
            route('proyectos.activities.complete', [projectId, activity.id]),
            {},
            {
                preserveScroll: true,
                onError: () =>
                    toast.error('No se pudo finalizar la actividad.'),
            },
        );
    };

    const cancelActivity = () => {
        router.patch(
            route('proyectos.activities.cancel', [projectId, activity.id]),
            {},
            {
                preserveScroll: true,
                onError: () => toast.error('No se pudo cancelar la actividad.'),
            },
        );
    };

    const options = [
        {
            title: 'Comentarios y tiempo',
            description:
                'Agrega comentario, evidencia de avance y minutos trabajados.',
            action: 'Agregar comentario',
            value: `${commentsCount} registros`,
            icon: MessageSquare,
            href: canRegisterTime
                ? route('proyectos.activities.times.create', [
                      projectId,
                      activity.id,
                  ])
                : undefined,
        },
        {
            title: 'Kanban',
            description:
                'Mueve la actividad entre columnas y actualiza su flujo.',
            action: 'Mover estado',
            value: label(activity.kanban_column),
            icon: KanbanSquare,
            href: canMoveKanban
                ? route('proyectos.activities.kanban.edit', [
                      projectId,
                      activity.id,
                  ])
                : undefined,
        },
        {
            title: 'Tickets relacionados',
            description:
                'Consulta o vincula tickets existentes con esta actividad.',
            action: 'Relacionar ticket',
            value: `${relatedTicketsCount} vinculados`,
            icon: Link2,
            href: canManage
                ? route('proyectos.activities.tickets.create', [
                      projectId,
                      activity.id,
                  ])
                : undefined,
        },
        {
            title: 'Crear ticket',
            description:
                'Genera un ticket nuevo tomando como base esta actividad.',
            action: 'Crear ticket',
            value: activity.ticket ? 'Con principal' : 'Disponible',
            icon: Ticket,
            href: canCreateTicket
                ? route('proyectos.activities.create-ticket.create', [
                      projectId,
                      activity.id,
                  ])
                : undefined,
        },
        {
            title: 'Archivos',
            description:
                'Adjunta, descarga o elimina documentos de la actividad.',
            action: 'Administrar archivos',
            value: `${filesCount} adjuntos`,
            icon: Paperclip,
            onClick: canManage ? () => setFilesOpen(true) : undefined,
        },
        {
            title: 'Editar datos',
            description: 'Actualiza titulo, descripcion, fechas y estimacion.',
            action: 'Editar resumen',
            value: canManage ? 'Editable' : 'Solo lectura',
            icon: Pencil,
            href: canManage ? '#activity-summary-form' : undefined,
        },
        canViewProject && {
            title: 'Proyecto',
            description: 'Abre el proyecto al que pertenece esta actividad.',
            action: 'Abrir proyecto',
            value: activity.proyecto.nombre,
            icon: FolderOpen,
            href: route('proyectos.show', projectId),
        },
        activity.ticket &&
            canViewTickets && {
                title: 'Ticket principal',
                description:
                    'Consulta el ticket ligado directamente a esta actividad.',
                action: 'Abrir ticket',
                value: activity.ticket.folio ?? 'Ticket',
                icon: ExternalLink,
                href: route('tickets.show', activity.ticket.id),
            },
        canManage &&
            activity.estado !== 'terminada' &&
            activity.estado !== 'cancelada' && {
                title: 'Finalizar',
                description:
                    'Marca la actividad como terminada cuando ya no tenga pendientes.',
                action: 'Finalizar actividad',
                value: 'Pendiente',
                icon: CheckSquare2,
                onClick: completeActivity,
            },
        canManage &&
            activity.estado !== 'cancelada' &&
            activity.estado !== 'terminada' && {
                title: 'Cancelar',
                description: 'Cancela la actividad si ya no debe continuar.',
                action: 'Cancelar actividad',
                value: 'Activa',
                icon: Ban,
                onClick: cancelActivity,
                variant: 'destructive',
            },
    ].filter(Boolean) as ActivityOption[];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Resumen - ${activity.titulo}`} />

            <div className="space-y-4 p-4">
                <div className="flex flex-wrap items-center justify-between gap-3">
                    <Button variant="ghost" asChild>
                        <Link href={route('activities.index')}>
                            <ArrowLeft className="size-4" /> Volver
                        </Link>
                    </Button>
                    <div className="flex flex-wrap gap-2">
                        {activity.ticket && (
                            <Button variant="outline" asChild>
                                <Link
                                    href={route(
                                        'tickets.show',
                                        activity.ticket.id,
                                    )}
                                >
                                    <ExternalLink className="size-4" /> Ticket
                                </Link>
                            </Button>
                        )}
                    </div>
                </div>

                <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <Metric
                        title="Estado"
                        value={label(activity.estado)}
                        detail={label(activity.kanban_column)}
                    />
                    <Metric
                        title="Prioridad"
                        value={activity.prioridad}
                        detail={label(activity.tipo)}
                    />
                    <Metric
                        title="Tiempo real"
                        value={formatMinutes(activity.minutos_reales)}
                        detail={`Estimado ${formatMinutes(activity.minutos_estimados)}`}
                    />
                    <Metric
                        title="Comentarios"
                        value={activity.tiempos?.length ?? 0}
                        detail={`${activity.files?.length ?? 0} archivos`}
                    />
                </div>

                <div className="grid gap-6 lg:grid-cols-[minmax(0,1fr)_380px]">
                    <section className="space-y-6">
                        <div className="flex flex-wrap items-center gap-2 text-sm text-muted-foreground">
                            <CheckSquare2 className="size-4 text-primary" />
                            <span>{activity.proyecto.nombre}</span>
                            <span>/</span>
                            <Badge variant="outline">
                                {label(activity.estado)}
                            </Badge>
                            <Badge variant="secondary">
                                {activity.prioridad}
                            </Badge>
                        </div>

                        <Card className="rounded-lg" id="activity-summary-form">
                            <CardHeader>
                                <CardTitle>Resumen de actividad</CardTitle>
                                <CardDescription>
                                    Datos principales de esta actividad. Las
                                    opciones operativas estan arriba.
                                </CardDescription>
                            </CardHeader>
                            <CardContent>
                                <form className="space-y-5" onSubmit={submit}>
                                    <FormInputField
                                        id="activity-title"
                                        label="Titulo"
                                        value={form.data.titulo}
                                        error={form.errors.titulo}
                                        disabled={!canManage}
                                        onChange={(event) =>
                                            form.setData(
                                                'titulo',
                                                event.target.value,
                                            )
                                        }
                                    />

                                    <FormTextareaField
                                        id="activity-description"
                                        label="Descripcion"
                                        value={form.data.descripcion}
                                        error={form.errors.descripcion}
                                        disabled={!canManage}
                                        onChange={(event) =>
                                            form.setData(
                                                'descripcion',
                                                event.target.value,
                                            )
                                        }
                                    />

                                    <div className="grid gap-4 md:grid-cols-3">
                                        <FormInputField
                                            id="activity-start"
                                            label="Fecha inicio"
                                            type="date"
                                            value={form.data.fecha_inicio}
                                            error={form.errors.fecha_inicio}
                                            disabled={!canManage}
                                            onChange={(event) =>
                                                form.setData(
                                                    'fecha_inicio',
                                                    event.target.value,
                                                )
                                            }
                                        />
                                        <FormInputField
                                            id="activity-due"
                                            label="Fecha limite"
                                            type="date"
                                            value={form.data.fecha_limite}
                                            error={form.errors.fecha_limite}
                                            disabled={!canManage}
                                            onChange={(event) =>
                                                form.setData(
                                                    'fecha_limite',
                                                    event.target.value,
                                                )
                                            }
                                        />
                                        <FormInputField
                                            id="activity-estimated"
                                            label="Minutos estimados"
                                            type="number"
                                            min="0"
                                            value={form.data.minutos_estimados}
                                            error={
                                                form.errors.minutos_estimados
                                            }
                                            disabled={!canManage}
                                            onChange={(event) =>
                                                form.setData(
                                                    'minutos_estimados',
                                                    event.target.value,
                                                )
                                            }
                                        />
                                    </div>

                                    {canManage && (
                                        <LoadingSubmitButton
                                            label="Guardar cambios"
                                            processing={form.processing}
                                        />
                                    )}
                                </form>
                            </CardContent>
                        </Card>

                        <Card className="rounded-lg">
                            <CardHeader>
                                <div className="flex flex-wrap items-center justify-between gap-3">
                                    <div>
                                        <CardTitle>
                                            Comentarios y tiempo
                                        </CardTitle>
                                        <CardDescription>
                                            Avances registrados para esta
                                            actividad.
                                        </CardDescription>
                                    </div>
                                    {canRegisterTime && (
                                        <Button asChild variant="outline">
                                            <Link
                                                href={route(
                                                    'proyectos.activities.times.create',
                                                    [projectId, activity.id],
                                                )}
                                            >
                                                <MessageSquare className="size-4" />
                                                Agregar comentario
                                            </Link>
                                        </Button>
                                    )}
                                </div>
                            </CardHeader>
                            <CardContent className="space-y-3">
                                {(activity.tiempos ?? []).length === 0 ? (
                                    <p className="text-sm text-muted-foreground">
                                        Sin comentarios registrados.
                                    </p>
                                ) : (
                                    activity.tiempos?.map((time) => (
                                        <div
                                            key={time.id}
                                            className="flex gap-3 rounded-md border p-3"
                                        >
                                            <div className="flex size-8 shrink-0 items-center justify-center rounded-full bg-primary text-xs font-semibold text-primary-foreground">
                                                {initials(time.usuario?.name)}
                                            </div>
                                            <div className="min-w-0 flex-1 space-y-1">
                                                <div className="flex flex-wrap items-center gap-2 text-sm">
                                                    <span className="font-medium">
                                                        {time.usuario?.name ??
                                                            'Sistema'}
                                                    </span>
                                                    <Badge variant="outline">
                                                        {formatMinutes(
                                                            time.minutos,
                                                        )}
                                                    </Badge>
                                                    <span className="text-xs text-muted-foreground">
                                                        {formatDate(
                                                            time.created_at ??
                                                                time.fecha,
                                                        )}
                                                    </span>
                                                </div>
                                                <p className="text-sm whitespace-pre-line text-muted-foreground">
                                                    {time.descripcion}
                                                </p>
                                            </div>
                                        </div>
                                    ))
                                )}
                            </CardContent>
                        </Card>

                        {(activity.parent || childrenCount > 0) && (
                            <Card className="rounded-lg">
                                <CardHeader>
                                    <CardTitle>Relaciones</CardTitle>
                                    <CardDescription>
                                        Actividad padre y subtareas asociadas.
                                    </CardDescription>
                                </CardHeader>
                                <CardContent className="space-y-3">
                                    {activity.parent && (
                                        <RelatedActivityItem
                                            relationshipLabel="Padre"
                                            activity={activity.parent}
                                        />
                                    )}
                                    {activity.children?.map((child) => (
                                        <RelatedActivityItem
                                            key={child.id}
                                            relationshipLabel="Subtarea"
                                            activity={child}
                                        />
                                    ))}
                                </CardContent>
                            </Card>
                        )}
                    </section>

                    <aside className="space-y-4">
                        <Card className="rounded-lg">
                            <CardHeader>
                                <CardTitle>Datos principales</CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-4 text-sm">
                                <Detail
                                    label="Proyecto"
                                    value={activity.proyecto.nombre}
                                />
                                <Detail
                                    label="Cliente"
                                    value={
                                        activity.proyecto.cliente?.nombre ??
                                        activity.proyecto.cliente
                                            ?.razon_social ??
                                        '-'
                                    }
                                />
                                <Detail
                                    label="Responsable"
                                    value={
                                        activity.responsable?.name ??
                                        'Sin responsable'
                                    }
                                />
                                <Detail
                                    label="Fecha limite"
                                    value={formatDate(activity.fecha_limite)}
                                />
                                <Detail
                                    label="Informador"
                                    value={
                                        activity.reportado_por?.name ??
                                        activity.created_by?.name ??
                                        '-'
                                    }
                                />
                                <Detail
                                    label="Tags"
                                    value={
                                        activity.tags?.length
                                            ? activity.tags.join(', ')
                                            : '-'
                                    }
                                />
                            </CardContent>
                        </Card>

                        <Card className="rounded-lg">
                            <CardHeader>
                                <CardTitle>Tickets relacionados</CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-3">
                                {activity.ticket && (
                                    <TicketItem
                                        label="Principal"
                                        ticket={activity.ticket}
                                    />
                                )}
                                {(activity.ticket_links ?? []).map((link) =>
                                    link.ticket ? (
                                        <TicketItem
                                            key={link.id}
                                            label={label(link.tipo_relacion)}
                                            ticket={link.ticket}
                                        />
                                    ) : null,
                                )}
                                {!activity.ticket &&
                                    (activity.ticket_links ?? []).length ===
                                        0 && (
                                        <p className="text-sm text-muted-foreground">
                                            Sin tickets relacionados.
                                        </p>
                                    )}
                            </CardContent>
                        </Card>

                        <Card className="rounded-lg">
                            <CardHeader>
                                <div className="flex flex-wrap items-center justify-between gap-3">
                                    <CardTitle>Archivos</CardTitle>
                                    {canManage && (
                                        <Button
                                            type="button"
                                            size="sm"
                                            variant="outline"
                                            onClick={() => setFilesOpen(true)}
                                        >
                                            <Paperclip className="size-4" />
                                            Administrar
                                        </Button>
                                    )}
                                </div>
                            </CardHeader>
                            <CardContent className="space-y-3">
                                {(activity.files ?? []).length === 0 ? (
                                    <p className="text-sm text-muted-foreground">
                                        Sin archivos adjuntos.
                                    </p>
                                ) : (
                                    activity.files?.map((file) => (
                                        <div
                                            key={file.id}
                                            className="flex items-center justify-between gap-3 rounded-md border p-3"
                                        >
                                            <div className="min-w-0">
                                                <p className="truncate text-sm font-medium">
                                                    {file.original_name}
                                                </p>
                                                <p className="text-xs text-muted-foreground">
                                                    {file.mime_type ??
                                                        'archivo'}
                                                </p>
                                            </div>
                                            <Button
                                                size="sm"
                                                variant="outline"
                                                onClick={() =>
                                                    window.open(
                                                        file.url,
                                                        '_blank',
                                                        'noopener,noreferrer',
                                                    )
                                                }
                                            >
                                                Abrir
                                            </Button>
                                        </div>
                                    ))
                                )}
                            </CardContent>
                        </Card>
                    </aside>
                </div>
                 <section className="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    {options.map((option) => (
                        <OptionCard key={option.title} option={option} />
                    ))}
                </section>
            </div>

            <FilePickerDialog
                open={filesOpen}
                onOpenChange={setFilesOpen}
                title="Archivos de actividad"
                description={activity.titulo}
                storedFiles={activity.files ?? []}
                tableId="proyecto_actividades"
                relatedUuid={activity.id}
                accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx,.xls,.xlsx,.txt,.csv,.zip"
                maxSizeHint="Maximo 10MB"
                onDownloadStoredFile={(file) =>
                    window.open(file.url, '_blank', 'noopener,noreferrer')
                }
                onDeleteStoredFile={(fileId) => {
                    router.delete(route('files.destroy', fileId), {
                        data: {
                            related_table: 'proyecto_actividades',
                            related_uuid: activity.id,
                        },
                        preserveScroll: true,
                        onError: () =>
                            toast.error('No se pudo eliminar el archivo.'),
                    });
                }}
            />
        </AppLayout>
    );
}

function Metric({
    title,
    value,
    detail,
}: {
    title: string;
    value: string | number;
    detail: string;
}) {
    return (
        <Card className="rounded-lg">
            <CardContent className="p-4">
                <p className="text-xs text-muted-foreground">{title}</p>
                <p className="text-lg font-semibold">{value}</p>
                <p className="text-xs text-muted-foreground">{detail}</p>
            </CardContent>
        </Card>
    );
}

function OptionCard({ option }: { option: ActivityOption }) {
    const Icon = option.icon;
    const button = (
        <Button
            type="button"
            variant={option.variant ?? 'outline'}
            className="w-full"
            disabled={!option.href && !option.onClick}
            onClick={option.onClick}
        >
            {option.action}
        </Button>
    );

    return (
        <Card className="rounded-lg">
            <CardHeader>
                <div className="flex items-start justify-between gap-3">
                    <div>
                        <CardTitle className="flex items-center gap-2 text-base">
                            <Icon className="size-4 text-primary" />
                            {option.title}
                        </CardTitle>
                        <CardDescription className="mt-1">
                            {option.description}
                        </CardDescription>
                    </div>
                    <Badge variant="outline" className="max-w-28 truncate">
                        {option.value}
                    </Badge>
                </div>
            </CardHeader>
            <CardContent>
                {option.href ? (
                    <Button
                        asChild
                        variant={option.variant ?? 'outline'}
                        className="w-full"
                    >
                        <Link href={option.href}>{option.action}</Link>
                    </Button>
                ) : (
                    button
                )}
            </CardContent>
        </Card>
    );
}

function Detail({ label, value }: { label: string; value: string }) {
    return (
        <div className="grid grid-cols-[130px_minmax(0,1fr)] gap-3">
            <span className="text-muted-foreground">{label}</span>
            <span className="font-medium">{value}</span>
        </div>
    );
}

function RelatedActivityItem({
    relationshipLabel,
    activity,
}: {
    relationshipLabel: string;
    activity: RelatedActivity;
}) {
    return (
        <div className="flex items-start justify-between gap-3 rounded-md border p-3">
            <div className="min-w-0">
                <p className="text-xs text-muted-foreground">
                    {relationshipLabel}
                </p>
                <p className="truncate text-sm font-medium">
                    {activity.titulo}
                </p>
            </div>
            <Badge variant="outline">{label(activity.estado)}</Badge>
        </div>
    );
}

function TicketItem({
    label,
    ticket,
}: {
    label: string;
    ticket: { id: string; folio: string | null; titulo: string };
}) {
    return (
        <div className="rounded-md border p-3">
            <div className="flex items-start justify-between gap-3">
                <div className="min-w-0">
                    <p className="font-medium">{ticket.folio ?? 'Ticket'}</p>
                    <p className="text-sm text-muted-foreground">
                        {ticket.titulo}
                    </p>
                </div>
                <Badge variant="outline">{label}</Badge>
            </div>
            <Button asChild size="sm" variant="outline" className="mt-3">
                <Link href={route('tickets.show', ticket.id)}>
                    <Ticket className="size-4" />
                    Abrir ticket
                </Link>
            </Button>
        </div>
    );
}
