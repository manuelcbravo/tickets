import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import {
    CheckCircle2,
    ClipboardList,
    Clock,
    Eye,
    ExternalLink,
    FileText,
    KanbanSquare,
    MoreHorizontal,
    Pencil,
    Plus,
    Ticket,
    Trash2,
    XCircle,
} from 'lucide-react';
import type React from 'react';
import { useEffect, useMemo, useState } from 'react';
import { route } from 'ziggy-js';
import { ConfirmDeleteDialog } from '@/components/confirm-delete-dialog';
import { CrudFormDialog } from '@/components/crud-form-dialog';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { FilePickerDialog } from '@/components/file-picker-dialog';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { ModuleHeader } from '@/components/module-header';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
    ContextMenu,
    ContextMenuContent,
    ContextMenuItem,
    ContextMenuSeparator,
    ContextMenuTrigger,
} from '@/components/ui/context-menu';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Field, FieldError } from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type Activity = {
    id: string;
    titulo: string;
    descripcion: string | null;
    tipo: string;
    estado: string;
    prioridad: string;
    responsable_id: number | null;
    fecha_inicio: string | null;
    fecha_limite: string | null;
    minutos_estimados: number | null;
    minutos_reales: number;
    kanban_column: string;
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
    ticket?: { id: string; folio: string | null; titulo: string } | null;
    files?: StoredFile[];
};

type StoredFile = {
    id: string;
    original_name: string;
    path: string;
    url: string;
    mime_type: string | null;
    size: number;
};

type Project = {
    id: string;
    nombre: string;
    cliente?: {
        id: string;
        nombre: string | null;
        razon_social: string | null;
    } | null;
};

type UserOption = { id: number; name: string };

type Metrics = {
    total: number;
    mine: number;
    completed: number;
    in_progress: number;
    overdue: number;
    estimated_minutes: number;
    real_minutes: number;
};

type ActivityForm = {
    proyecto_id: string;
    titulo: string;
    descripcion: string;
    tipo: string;
    estado: string;
    prioridad: string;
    responsable_id: string;
    fecha_inicio: string;
    fecha_limite: string;
    minutos_estimados: string;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Tickets', href: route('tickets.dashboard') },
    { title: 'Actividades', href: route('activities.index') },
];

function formatMinutes(minutes: number | null): string {
    if (!minutes) return '-';
    const hours = Math.floor(minutes / 60);
    const remaining = minutes % 60;
    if (hours === 0) return `${remaining} min`;
    return remaining > 0 ? `${hours} h ${remaining} min` : `${hours} h`;
}

function statusVariant(
    status: string,
): 'default' | 'destructive' | 'outline' | 'secondary' {
    if (status === 'terminada') return 'default';
    if (status === 'bloqueada' || status === 'cancelada') return 'destructive';
    if (status === 'pendiente' || status === 'por_hacer') return 'outline';
    return 'secondary';
}

function priorityVariant(
    priority: string,
): 'default' | 'destructive' | 'outline' | 'secondary' {
    if (priority === 'critica') return 'destructive';
    if (priority === 'alta') return 'default';
    if (priority === 'baja') return 'outline';
    return 'secondary';
}

function label(value: string): string {
    return value.replaceAll('_', ' ');
}

function formatDate(value: string | null): string {
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

export default function ActivitiesIndex({
    activities,
    projects,
    users,
    estadoOptions,
    prioridadOptions,
    tipoOptions,
    kanbanColumns,
    initialView,
    metrics,
}: {
    activities: Activity[];
    projects: Project[];
    users: UserOption[];
    estadoOptions: string[];
    prioridadOptions: string[];
    tipoOptions: string[];
    kanbanColumns: string[];
    initialView: 'dashboard' | 'list' | 'kanban' | 'done';
    metrics: Metrics;
}) {
    const permissions = usePage<SharedData>().props.auth.permissions ?? [];
    const authUser = usePage<SharedData>().props.auth.user;
    const canManage = permissions.includes(
        'project-planning.activities.manage',
    );
    const canMoveKanban = permissions.includes(
        'project-planning.kanban.manage',
    );
    const { flash } = usePage<SharedData>().props;

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash]);

    const [view] = useState<'dashboard' | 'list' | 'kanban' | 'done'>(
        initialView,
    );
    const [search, setSearch] = useState('');
    const [projectFilter, setProjectFilter] = useState('todos');
    const [responsibleFilter, setResponsibleFilter] = useState('todos');
    const [estadoFilter, setEstadoFilter] = useState('todos');
    const [priorityFilter, setPriorityFilter] = useState('todos');
    const [activityMode, setActivityMode] = useState<'create' | 'edit' | null>(
        null,
    );
    const [activeActivity, setActiveActivity] = useState<Activity | null>(null);
    const [deleteTarget, setDeleteTarget] = useState<Activity | null>(null);
    const [filesActivity, setFilesActivity] = useState<Activity | null>(null);
    const [draggingActivityId, setDraggingActivityId] = useState<string | null>(
        null,
    );
    const [dragOverColumn, setDragOverColumn] = useState<string | null>(null);

    useEffect(() => {
        if (!filesActivity) return;
        const updated = activities.find((a) => a.id === filesActivity.id);
        if (updated) setFilesActivity(updated);
    }, [activities]);

    const defaultActivity: ActivityForm = {
        proyecto_id: projects[0]?.id ?? '',
        titulo: '',
        descripcion: '',
        tipo: tipoOptions[0] ?? 'tarea',
        estado: 'pendiente',
        prioridad: 'media',
        responsable_id: '',
        fecha_inicio: '',
        fecha_limite: '',
        minutos_estimados: '',
    };

    const activityForm = useForm<ActivityForm>(defaultActivity);

    const filteredActivities = useMemo(() => {
        const term = search.trim().toLowerCase();

        return activities.filter((activity) => {
            const client =
                activity.proyecto.cliente?.nombre ??
                activity.proyecto.cliente?.razon_social ??
                '';
            const matchesSearch =
                term.length === 0 ||
                [
                    activity.titulo,
                    activity.proyecto.nombre,
                    client,
                    activity.responsable?.name ?? '',
                    activity.ticket?.folio ?? '',
                    activity.ticket?.titulo ?? '',
                ].some((value) => value.toLowerCase().includes(term));
            const matchesProject =
                projectFilter === 'todos' ||
                activity.proyecto.id === projectFilter;
            const matchesResponsible =
                responsibleFilter === 'todos' ||
                (responsibleFilter === 'sin_responsable' &&
                    !activity.responsable_id) ||
                String(activity.responsable_id) === responsibleFilter;
            const matchesStatus =
                estadoFilter === 'todos' || activity.estado === estadoFilter;
            const matchesPriority =
                priorityFilter === 'todos' ||
                activity.prioridad === priorityFilter;

            return (
                matchesSearch &&
                matchesProject &&
                matchesResponsible &&
                matchesStatus &&
                matchesPriority
            );
        });
    }, [
        activities,
        estadoFilter,
        priorityFilter,
        projectFilter,
        responsibleFilter,
        search,
    ]);

    const completedActivities = filteredActivities.filter(
        (activity) => activity.estado === 'terminada',
    );
    const myActivities = activities.filter(
        (activity) =>
            activity.responsable_id === authUser?.id &&
            activity.estado !== 'terminada' &&
            activity.estado !== 'cancelada',
    );
    const kanbanActivities = filteredActivities.filter(
        (activity) =>
            activity.estado !== 'terminada' &&
            activity.estado !== 'cancelada' &&
            activity.kanban_column !== 'terminado',
    );
    const visibleKanbanColumns = kanbanColumns.filter(
        (column) => column !== 'terminado',
    );
    const activityHref = (activity: Activity) => projects.length === 1
        ? route('proyectos.activities.show', [activity.proyecto.id, activity.id])
        : route('activities.show', activity.id);

    const openCreate = () => {
        setActiveActivity(null);
        activityForm.setData(defaultActivity);
        activityForm.clearErrors();
        setActivityMode('create');
    };

    const openEdit = (activity: Activity) => {
        setActiveActivity(activity);
        activityForm.setData({
            proyecto_id: activity.proyecto.id,
            titulo: activity.titulo,
            descripcion: activity.descripcion ?? '',
            tipo: activity.tipo,
            estado: activity.estado,
            prioridad: activity.prioridad,
            responsable_id: activity.responsable_id
                ? String(activity.responsable_id)
                : '',
            fecha_inicio: activity.fecha_inicio ?? '',
            fecha_limite: activity.fecha_limite ?? '',
            minutos_estimados: activity.minutos_estimados
                ? String(activity.minutos_estimados)
                : '',
        });
        activityForm.clearErrors();
        setActivityMode('edit');
    };

    const submitActivity = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        if (activityMode === 'edit' && activeActivity) {
            activityForm.patch(route('activities.update', activeActivity.id), {
                preserveScroll: true,
                onSuccess: () => setActivityMode(null),
            });
            return;
        }

        activityForm.post(route('activities.store'), {
            preserveScroll: true,
            onSuccess: () => setActivityMode(null),
        });
    };

    const moveActivity = (activity: Activity, column: string) => {
        router.patch(
            route('activities.kanban.update', activity.id),
            { kanban_column: column },
            {
                preserveScroll: true,
                onError: () => toast.error('No se pudo mover la actividad.'),
            },
        );
    };

    const dropActivity = (column: string) => {
        if (!canMoveKanban || !draggingActivityId) return;

        const activity = activities.find(
            (item) => item.id === draggingActivityId,
        );
        if (activity && activity.kanban_column !== column) {
            moveActivity(activity, column);
        }

        setDraggingActivityId(null);
        setDragOverColumn(null);
    };

    const columns: DataTableColumn<Activity>[] = [
        {
            key: 'titulo',
            header: 'Actividad',
            accessor: (activity) => activity.titulo,
            cell: (activity) => (
                <div className="space-y-1">
                    <div className="font-medium">{activity.titulo}</div>
                    <div className="text-xs text-muted-foreground">
                        {label(activity.kanban_column)}
                    </div>
                </div>
            ),
        },
        {
            key: 'proyecto',
            header: 'Proyecto',
            accessor: (activity) => activity.proyecto.nombre,
            cell: (activity) => (
                <Link
                    className="text-primary hover:underline"
                    href={route('proyectos.show', activity.proyecto.id)}
                >
                    {activity.proyecto.nombre}
                </Link>
            ),
        },
        {
            key: 'estado',
            header: 'Estado',
            accessor: (activity) => activity.estado,
            cell: (activity) => (
                <Badge variant={statusVariant(activity.estado)}>
                    {label(activity.estado)}
                </Badge>
            ),
        },
        {
            key: 'prioridad',
            header: 'Prioridad',
            accessor: (activity) => activity.prioridad,
            cell: (activity) => (
                <Badge variant={priorityVariant(activity.prioridad)}>
                    {activity.prioridad}
                </Badge>
            ),
        },
        {
            key: 'responsable',
            header: 'Responsable',
            cell: (activity) => activity.responsable?.name ?? '-',
        },
        {
            key: 'fecha_limite',
            header: 'Fecha limite',
            cell: (activity) => formatDate(activity.fecha_limite),
        },
        {
            key: 'tiempo',
            header: 'Tiempo',
            cell: (activity) =>
                `${formatMinutes(activity.minutos_reales)} / ${formatMinutes(activity.minutos_estimados)}`,
        },
        {
            key: 'ticket',
            header: 'Ticket',
            cell: (activity) =>
                activity.ticket ? (
                    <Link
                        className="text-primary hover:underline"
                        href={route('tickets.show', activity.ticket.id)}
                    >
                        {activity.ticket.folio ?? activity.ticket.titulo}
                    </Link>
                ) : (
                    '-'
                ),
        },
        {
            key: 'actions',
            header: 'Acciones',
            className: 'w-24',
            cell: (activity) => (
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <Button variant="ghost" size="icon" className="size-8">
                            <MoreHorizontal className="size-4" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuItem asChild>
                            <Link href={activityHref(activity)}>
                                <Eye className="mr-2 size-4" /> Ver detalle
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem asChild>
                            <Link
                                href={route(
                                    'proyectos.show',
                                    activity.proyecto.id,
                                )}
                            >
                                <ExternalLink className="mr-2 size-4" /> Abrir
                                proyecto
                            </Link>
                        </DropdownMenuItem>
                        {canManage && (
                            <>
                                <DropdownMenuItem
                                    onClick={() => openEdit(activity)}
                                >
                                    <Pencil className="mr-2 size-4" /> Editar
                                </DropdownMenuItem>
                                <DropdownMenuItem asChild>
                                    <Link href={activityHref(activity)}>
                                        <Clock className="mr-2 size-4" /> Registrar tiempo
                                    </Link>
                                </DropdownMenuItem>
                                {canMoveKanban && (
                                    <DropdownMenuItem asChild>
                                        <Link href={activityHref(activity)}>
                                            <KanbanSquare className="mr-2 size-4" /> Mover estado
                                        </Link>
                                    </DropdownMenuItem>
                                )}
                                <DropdownMenuItem asChild>
                                    <Link href={activityHref(activity)}>
                                        <Ticket className="mr-2 size-4" /> Relacionar ticket
                                    </Link>
                                </DropdownMenuItem>
                                <DropdownMenuItem asChild>
                                    <Link href={activityHref(activity)}>
                                        <Plus className="mr-2 size-4" /> Crear ticket
                                    </Link>
                                </DropdownMenuItem>
                                <DropdownMenuItem
                                    onClick={() => setFilesActivity(activity)}
                                >
                                    <FileText className="mr-2 size-4" />{' '}
                                    Archivos
                                </DropdownMenuItem>
                                <DropdownMenuItem
                                    onClick={() =>
                                        router.patch(
                                            route(
                                                'activities.complete',
                                                activity.id,
                                            ),
                                            {},
                                            { preserveScroll: true },
                                        )
                                    }
                                >
                                    <CheckCircle2 className="mr-2 size-4" />{' '}
                                    Marcar terminada
                                </DropdownMenuItem>
                                <DropdownMenuItem
                                    onClick={() =>
                                        router.patch(
                                            route(
                                                'activities.cancel',
                                                activity.id,
                                            ),
                                            {},
                                            { preserveScroll: true },
                                        )
                                    }
                                >
                                    <XCircle className="mr-2 size-4" /> Cancelar
                                </DropdownMenuItem>
                                <DropdownMenuSeparator />
                                <DropdownMenuItem
                                    variant="destructive"
                                    onClick={() => setDeleteTarget(activity)}
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
            <Head title="Actividades" />

            <div className="space-y-4 rounded-xl p-4">
                <ModuleHeader
                    title="Actividades"
                    description="Gestiona el trabajo interno de los proyectos desde un solo lugar. Puedes crear actividades, filtrar por responsable o proyecto, revisar kanban y consultar lo realizado."
                >
                    {canManage && (
                        <Button onClick={openCreate}>
                            <Plus className="size-4" /> Nueva actividad
                        </Button>
                    )}
                </ModuleHeader>

                <div className="grid gap-3 md:grid-cols-[minmax(0,1fr)_180px_180px_180px_180px]">
                    <Input
                        value={search}
                        onChange={(event) => setSearch(event.target.value)}
                        placeholder="Buscar actividad, proyecto, responsable o ticket..."
                    />
                    <Select
                        value={projectFilter}
                        onValueChange={setProjectFilter}
                    >
                        <SelectTrigger>
                            <SelectValue placeholder="Proyecto" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="todos">
                                Todos los proyectos
                            </SelectItem>
                            {projects.map((project) => (
                                <SelectItem key={project.id} value={project.id}>
                                    {project.nombre}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    <Select
                        value={responsibleFilter}
                        onValueChange={setResponsibleFilter}
                    >
                        <SelectTrigger>
                            <SelectValue placeholder="Responsable" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="todos">Todos</SelectItem>
                            <SelectItem value="sin_responsable">
                                Sin responsable
                            </SelectItem>
                            {users.map((user) => (
                                <SelectItem
                                    key={user.id}
                                    value={String(user.id)}
                                >
                                    {user.name}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    <Select
                        value={estadoFilter}
                        onValueChange={setEstadoFilter}
                    >
                        <SelectTrigger>
                            <SelectValue placeholder="Estado" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="todos">Todos</SelectItem>
                            {estadoOptions.map((option) => (
                                <SelectItem key={option} value={option}>
                                    {label(option)}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    <Select
                        value={priorityFilter}
                        onValueChange={setPriorityFilter}
                    >
                        <SelectTrigger>
                            <SelectValue placeholder="Prioridad" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="todos">Todas</SelectItem>
                            {prioridadOptions.map((option) => (
                                <SelectItem key={option} value={option}>
                                    {option}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                </div>

                {view === 'dashboard' && (
                    <div className="space-y-4">
                        <div className="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                            <MetricCard
                                title="Total"
                                value={metrics.total}
                                icon={<ClipboardList className="size-4" />}
                            />
                            <MetricCard
                                title="Mis pendientes"
                                value={metrics.mine}
                                icon={<Clock className="size-4" />}
                            />
                            <MetricCard
                                title="En proceso"
                                value={metrics.in_progress}
                                icon={<KanbanSquare className="size-4" />}
                            />
                            <MetricCard
                                title="Vencidas"
                                value={metrics.overdue}
                                icon={<XCircle className="size-4" />}
                            />
                            <MetricCard
                                title="Terminadas"
                                value={metrics.completed}
                                icon={<CheckCircle2 className="size-4" />}
                            />
                            <MetricCard
                                title="Estimado"
                                value={formatMinutes(metrics.estimated_minutes)}
                                icon={<Clock className="size-4" />}
                            />
                            <MetricCard
                                title="Real"
                                value={formatMinutes(metrics.real_minutes)}
                                icon={<Clock className="size-4" />}
                            />
                            <MetricCard
                                title="Filtradas"
                                value={filteredActivities.length}
                                icon={<ClipboardList className="size-4" />}
                            />
                        </div>
                        <Card>
                            <CardHeader>
                                <CardTitle>Mis actividades activas</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <DataTable
                                    columns={columns}
                                    data={myActivities}
                                    showSearch={false}
                                    emptyMessage="No tienes actividades activas asignadas."
                                />
                            </CardContent>
                        </Card>
                    </div>
                )}

                {view === 'list' && (
                    <DataTable
                        columns={columns}
                        data={filteredActivities}
                        showSearch={false}
                        emptyMessage="No hay actividades con los filtros actuales."
                    />
                )}
                {view === 'done' && (
                    <DataTable
                        columns={columns}
                        data={completedActivities}
                        showSearch={false}
                        emptyMessage="No hay actividades terminadas con los filtros actuales."
                    />
                )}

                {view === 'kanban' && (
                    <div className="grid gap-3 xl:grid-cols-5">
                        {visibleKanbanColumns.map((column) => {
                            const columnActivities = kanbanActivities.filter(
                                (activity) => activity.kanban_column === column,
                            );

                            return (
                                <section
                                    key={column}
                                    className={`rounded-lg border p-3 transition-colors ${dragOverColumn === column ? 'border-primary bg-primary/10' : 'bg-muted/20'}`}
                                    onDragOver={(event) => {
                                        if (
                                            !canMoveKanban ||
                                            !draggingActivityId
                                        )
                                            return;
                                        event.preventDefault();
                                        setDragOverColumn(column);
                                    }}
                                    onDragLeave={() => setDragOverColumn(null)}
                                    onDrop={(event) => {
                                        event.preventDefault();
                                        dropActivity(column);
                                    }}
                                >
                                    <div className="mb-3 flex items-center justify-between gap-2">
                                        <h2 className="text-sm font-semibold">
                                            {label(column)}
                                        </h2>
                                        <Badge variant="secondary">
                                            {columnActivities.length}
                                        </Badge>
                                    </div>
                                    <div className="space-y-3">
                                        {columnActivities.map((activity) => (
                                            <ContextMenu key={activity.id}>
                                                <ContextMenuTrigger asChild>
                                                    <Card
                                                        draggable={
                                                            canMoveKanban
                                                        }
                                                        onDragStart={(
                                                            event,
                                                        ) => {
                                                            if (!canMoveKanban)
                                                                return;
                                                            event.dataTransfer.effectAllowed =
                                                                'move';
                                                            event.dataTransfer.setData(
                                                                'text/plain',
                                                                activity.id,
                                                            );
                                                            setDraggingActivityId(
                                                                activity.id,
                                                            );
                                                        }}
                                                        onDragEnd={() => {
                                                            setDraggingActivityId(
                                                                null,
                                                            );
                                                            setDragOverColumn(
                                                                null,
                                                            );
                                                        }}
                                                        className={`gap-3 rounded-lg py-4 shadow-none ${canMoveKanban ? 'cursor-grab active:cursor-grabbing' : ''} ${draggingActivityId === activity.id ? 'opacity-60' : ''}`}
                                                    >
                                                        <CardHeader className="px-4">
                                                            <CardTitle className="text-sm leading-snug">
                                                                {
                                                                    activity.titulo
                                                                }
                                                            </CardTitle>
                                                        </CardHeader>
                                                        <CardContent className="space-y-3 px-4 text-sm">
                                                            <div className="flex flex-wrap gap-2">
                                                                <Badge variant="outline">
                                                                    {
                                                                        activity.tipo
                                                                    }
                                                                </Badge>
                                                                <Badge
                                                                    variant={priorityVariant(
                                                                        activity.prioridad,
                                                                    )}
                                                                >
                                                                    {
                                                                        activity.prioridad
                                                                    }
                                                                </Badge>
                                                            </div>
                                                            <div className="text-muted-foreground">
                                                                {
                                                                    activity
                                                                        .proyecto
                                                                        .nombre
                                                                }
                                                            </div>
                                                            <div>
                                                                {activity
                                                                    .responsable
                                                                    ?.name ??
                                                                    'Sin responsable'}
                                                            </div>
                                                            <div className="text-xs text-muted-foreground">
                                                                Limite:{' '}
                                                                {formatDate(
                                                                    activity.fecha_limite,
                                                                )}{' '}
                                                                · Tiempo:{' '}
                                                                {formatMinutes(
                                                                    activity.minutos_reales,
                                                                )}{' '}
                                                                /{' '}
                                                                {formatMinutes(
                                                                    activity.minutos_estimados,
                                                                )}
                                                            </div>
                                                        </CardContent>
                                                    </Card>
                                                </ContextMenuTrigger>
                                                <ContextMenuContent
                                                    alignOffset={-4}
                                                    className="w-52"
                                                >
                                                    <ContextMenuItem asChild>
                                                        <Link href={activityHref(activity)}>
                                                            <Eye className="size-4" />{' '}
                                                            Gestionar
                                                        </Link>
                                                    </ContextMenuItem>
                                                    <ContextMenuItem asChild>
                                                        <Link
                                                            href={route(
                                                                'proyectos.show',
                                                                activity
                                                                    .proyecto
                                                                    .id,
                                                            )}
                                                        >
                                                            <ExternalLink className="size-4" />{' '}
                                                            Abrir proyecto
                                                        </Link>
                                                    </ContextMenuItem>
                                                    {canManage && (
                                                        <>
                                                            <ContextMenuItem
                                                                onSelect={() =>
                                                                    openEdit(
                                                                        activity,
                                                                    )
                                                                }
                                                            >
                                                                <Pencil className="size-4" />{' '}
                                                                Editar
                                                            </ContextMenuItem>
                                                            <ContextMenuItem
                                                                onSelect={() =>
                                                                    setFilesActivity(
                                                                        activity,
                                                                    )
                                                                }
                                                            >
                                                                <FileText className="size-4" />{' '}
                                                                Archivos
                                                            </ContextMenuItem>
                                                            <ContextMenuItem
                                                                onSelect={() =>
                                                                    router.patch(
                                                                        route(
                                                                            'activities.complete',
                                                                            activity.id,
                                                                        ),
                                                                        {},
                                                                        {
                                                                            preserveScroll: true,
                                                                        },
                                                                    )
                                                                }
                                                            >
                                                                <CheckCircle2 className="size-4" />{' '}
                                                                Marcar terminada
                                                            </ContextMenuItem>
                                                            <ContextMenuItem
                                                                onSelect={() =>
                                                                    router.patch(
                                                                        route(
                                                                            'activities.cancel',
                                                                            activity.id,
                                                                        ),
                                                                        {},
                                                                        {
                                                                            preserveScroll: true,
                                                                        },
                                                                    )
                                                                }
                                                            >
                                                                <XCircle className="size-4" />{' '}
                                                                Cancelar
                                                            </ContextMenuItem>
                                                            <ContextMenuSeparator />
                                                            <ContextMenuItem
                                                                variant="destructive"
                                                                onSelect={() =>
                                                                    setDeleteTarget(
                                                                        activity,
                                                                    )
                                                                }
                                                            >
                                                                <Trash2 className="size-4" />{' '}
                                                                Eliminar
                                                            </ContextMenuItem>
                                                        </>
                                                    )}
                                                </ContextMenuContent>
                                            </ContextMenu>
                                        ))}
                                    </div>
                                </section>
                            );
                        })}
                    </div>
                )}
            </div>

            <CrudFormDialog
                open={activityMode !== null}
                onOpenChange={(open) => !open && setActivityMode(null)}
                title={
                    activityMode === 'edit'
                        ? 'Editar actividad'
                        : 'Nueva actividad'
                }
                description="Las actividades siempre pertenecen a un proyecto y pueden asignarse a un responsable."
                submitLabel="Guardar actividad"
                processing={activityForm.processing}
                onSubmit={submitActivity}
                size="lg"
            >
                <div className="grid gap-4 md:grid-cols-2">
                    <Field>
                        <Label>Proyecto</Label>
                        <Select
                            value={activityForm.data.proyecto_id}
                            onValueChange={(value) =>
                                activityForm.setData('proyecto_id', value)
                            }
                            disabled={activityMode === 'edit'}
                        >
                            <SelectTrigger>
                                <SelectValue placeholder="Selecciona proyecto" />
                            </SelectTrigger>
                            <SelectContent>
                                {projects.map((project) => (
                                    <SelectItem
                                        key={project.id}
                                        value={project.id}
                                    >
                                        {project.nombre}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        {activityForm.errors.proyecto_id && (
                            <FieldError>
                                {activityForm.errors.proyecto_id}
                            </FieldError>
                        )}
                    </Field>
                    <FormInputField
                        id="activity-title"
                        label="Titulo"
                        value={activityForm.data.titulo}
                        error={activityForm.errors.titulo}
                        onChange={(event) =>
                            activityForm.setData('titulo', event.target.value)
                        }
                    />
                    <Field>
                        <Label>Tipo</Label>
                        <Select
                            value={activityForm.data.tipo}
                            onValueChange={(value) =>
                                activityForm.setData('tipo', value)
                            }
                        >
                            <SelectTrigger>
                                <SelectValue />
                            </SelectTrigger>
                            <SelectContent>
                                {tipoOptions.map((option) => (
                                    <SelectItem key={option} value={option}>
                                        {label(option)}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        {activityForm.errors.tipo && (
                            <FieldError>{activityForm.errors.tipo}</FieldError>
                        )}
                    </Field>
                    <Field>
                        <Label>Estado</Label>
                        <Select
                            value={activityForm.data.estado}
                            onValueChange={(value) =>
                                activityForm.setData('estado', value)
                            }
                        >
                            <SelectTrigger>
                                <SelectValue />
                            </SelectTrigger>
                            <SelectContent>
                                {estadoOptions.map((option) => (
                                    <SelectItem key={option} value={option}>
                                        {label(option)}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        {activityForm.errors.estado && (
                            <FieldError>
                                {activityForm.errors.estado}
                            </FieldError>
                        )}
                    </Field>
                    <Field>
                        <Label>Prioridad</Label>
                        <Select
                            value={activityForm.data.prioridad}
                            onValueChange={(value) =>
                                activityForm.setData('prioridad', value)
                            }
                        >
                            <SelectTrigger>
                                <SelectValue />
                            </SelectTrigger>
                            <SelectContent>
                                {prioridadOptions.map((option) => (
                                    <SelectItem key={option} value={option}>
                                        {option}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        {activityForm.errors.prioridad && (
                            <FieldError>
                                {activityForm.errors.prioridad}
                            </FieldError>
                        )}
                    </Field>
                    <Field>
                        <Label>Responsable</Label>
                        <Select
                            value={
                                activityForm.data.responsable_id ||
                                'sin_responsable'
                            }
                            onValueChange={(value) =>
                                activityForm.setData(
                                    'responsable_id',
                                    value === 'sin_responsable' ? '' : value,
                                )
                            }
                        >
                            <SelectTrigger>
                                <SelectValue />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="sin_responsable">
                                    Sin responsable
                                </SelectItem>
                                {users.map((user) => (
                                    <SelectItem
                                        key={user.id}
                                        value={String(user.id)}
                                    >
                                        {user.name}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        {activityForm.errors.responsable_id && (
                            <FieldError>
                                {activityForm.errors.responsable_id}
                            </FieldError>
                        )}
                    </Field>
                    <FormInputField
                        id="activity-start"
                        label="Fecha inicio"
                        type="date"
                        value={activityForm.data.fecha_inicio}
                        error={activityForm.errors.fecha_inicio}
                        onChange={(event) =>
                            activityForm.setData(
                                'fecha_inicio',
                                event.target.value,
                            )
                        }
                    />
                    <FormInputField
                        id="activity-due"
                        label="Fecha limite"
                        type="date"
                        value={activityForm.data.fecha_limite}
                        error={activityForm.errors.fecha_limite}
                        onChange={(event) =>
                            activityForm.setData(
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
                        value={activityForm.data.minutos_estimados}
                        error={activityForm.errors.minutos_estimados}
                        onChange={(event) =>
                            activityForm.setData(
                                'minutos_estimados',
                                event.target.value,
                            )
                        }
                    />
                    <div className="md:col-span-2">
                        <FormTextareaField
                            id="activity-description"
                            label="Descripcion"
                            value={activityForm.data.descripcion}
                            error={activityForm.errors.descripcion}
                            onChange={(event) =>
                                activityForm.setData(
                                    'descripcion',
                                    event.target.value,
                                )
                            }
                        />
                    </div>
                </div>
            </CrudFormDialog>

            <ConfirmDeleteDialog
                open={deleteTarget !== null}
                onOpenChange={(open) => !open && setDeleteTarget(null)}
                title="Eliminar actividad"
                entityLabel="la actividad"
                itemName={deleteTarget?.titulo}
                onConfirm={() => {
                    if (!deleteTarget) return;
                    router.delete(
                        route('activities.destroy', deleteTarget.id),
                        {
                            preserveScroll: true,
                            onSuccess: () => setDeleteTarget(null),
                        },
                    );
                }}
            />

            <FilePickerDialog
                open={filesActivity !== null}
                onOpenChange={(open) => !open && setFilesActivity(null)}
                title="Archivos de actividad"
                description={
                    filesActivity
                        ? filesActivity.titulo
                        : 'Carga archivos relacionados con la actividad.'
                }
                storedFiles={filesActivity?.files ?? []}
                tableId="proyecto_actividades"
                relatedUuid={filesActivity?.id ?? null}
                accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx,.xls,.xlsx,.txt,.csv,.zip"
                maxSizeHint="Maximo 10MB"
                onDownloadStoredFile={(file) =>
                    window.open(file.url, '_blank', 'noopener,noreferrer')
                }
                onDeleteStoredFile={(fileId) => {
                    if (!filesActivity) return;
                    router.delete(route('files.destroy', fileId), {
                        data: {
                            related_table: 'proyecto_actividades',
                            related_uuid: filesActivity.id,
                        },
                        preserveScroll: true,
                        onSuccess: () => {
                            setFilesActivity((current) =>
                                current
                                    ? { ...current, files: current.files?.filter((f) => f.id !== fileId) ?? [] }
                                    : null,
                            );
                        },
                        onError: () => toast.error('No se pudo eliminar el archivo.'),
                    });
                }}
            />
        </AppLayout>
    );
}

function MetricCard({
    title,
    value,
    icon,
}: {
    title: string;
    value: number | string;
    icon: React.ReactNode;
}) {
    return (
        <Card className="rounded-lg py-4">
            <CardContent className="flex items-center justify-between gap-3 px-4">
                <div>
                    <div className="text-sm text-muted-foreground">{title}</div>
                    <div className="text-2xl font-semibold">{value}</div>
                </div>
                <div className="rounded-md bg-muted p-2 text-muted-foreground">
                    {icon}
                </div>
            </CardContent>
        </Card>
    );
}
