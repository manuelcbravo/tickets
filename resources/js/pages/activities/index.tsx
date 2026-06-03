import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import Gantt, { type GanttTask } from 'frappe-gantt';
import { toast } from 'sonner';
import {
    CalendarDays,
    CheckCircle2,
    ClipboardList,
    Clock,
    Eye,
    ExternalLink,
    FileText,
    KanbanSquare,
    MessageSquare,
    MoreHorizontal,
    Paperclip,
    Pencil,
    Plus,
    Ticket,
    Trash2,
    XCircle,
} from 'lucide-react';
import type React from 'react';
import { useEffect, useMemo, useRef, useState } from 'react';
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
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
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
    reportado_por_id?: number | null;
    ticket_id?: string | null;
    parent_id?: string | null;
    fecha_inicio: string | null;
    fecha_limite: string | null;
    fecha_finalizacion?: string | null;
    minutos_estimados: number | null;
    minutos_reales: number;
    kanban_column: string;
    tags?: string[] | null;
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

type RelatedActivity = {
    id: string;
    titulo: string;
    estado: string;
    prioridad?: string | null;
    kanban_column?: string | null;
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

type ModuleView = 'dashboard' | 'list' | 'kanban' | 'schedule' | 'done';
type GanttViewMode = 'Day' | 'Week' | 'Month' | 'Year';

const ganttViewOptions: { value: GanttViewMode; label: string }[] = [
    { value: 'Day', label: 'Día' },
    { value: 'Week', label: 'Semana' },
    { value: 'Month', label: 'Mes' },
    { value: 'Year', label: 'Año' },
];

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

function parseDate(value: string | null): Date | null {
    if (!value) return null;

    const date = new Date(`${value.slice(0, 10)}T00:00:00`);

    return Number.isNaN(date.getTime()) ? null : date;
}

function addDays(date: Date, days: number): Date {
    const next = new Date(date);
    next.setDate(next.getDate() + days);

    return next;
}

function toDateString(date: Date): string {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');

    return `${year}-${month}-${day}`;
}

function isOverdue(activity: Activity): boolean {
    const dueDate = parseDate(activity.fecha_limite);
    if (!dueDate || ['terminada', 'cancelada'].includes(activity.estado)) {
        return false;
    }

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    return dueDate < today;
}

function activityProgress(activity: Activity): number {
    if (activity.estado === 'terminada') return 100;
    if (!activity.minutos_estimados) return 0;

    return Math.min(
        100,
        Math.round((activity.minutos_reales / activity.minutos_estimados) * 100),
    );
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
    currentProject,
}: {
    activities: Activity[];
    currentProject?: Project | null;
    projects: Project[];
    users: UserOption[];
    estadoOptions: string[];
    prioridadOptions: string[];
    tipoOptions: string[];
    kanbanColumns: string[];
    initialView: ModuleView;
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

    const [view, setView] = useState<ModuleView>(initialView);
    const [search, setSearch] = useState('');
    const [projectFilter, setProjectFilter] = useState('todos');
    const [responsibleFilter, setResponsibleFilter] = useState('todos');
    const [estadoFilter, setEstadoFilter] = useState('todos');
    const [priorityFilter, setPriorityFilter] = useState('todos');
    const [activityMode, setActivityMode] = useState<'create' | 'edit' | null>(
        null,
    );
    const [activeActivity, setActiveActivity] = useState<Activity | null>(null);
    const [detailActivity, setDetailActivity] = useState<Activity | null>(null);
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

    useEffect(() => {
        if (!detailActivity) return;
        const updated = activities.find((a) => a.id === detailActivity.id);
        if (updated) setDetailActivity(updated);
    }, [activities]);

    const openDetailDialog = (activity: Activity) => {
        setDetailActivity(activity);
        const url = new URL(window.location.href);
        url.searchParams.set('detail', activity.id);
        window.history.pushState({ detail: activity.id }, '', url.toString());
    };

    const closeDetailDialog = () => {
        setDetailActivity(null);
        const url = new URL(window.location.href);
        url.searchParams.delete('detail');
        window.history.replaceState({}, '', url.toString());
    };

    useEffect(() => {
        const params = new URLSearchParams(window.location.search);
        const detailId = params.get('detail');
        if (detailId) {
            const found = activities.find((a) => a.id === detailId);
            if (found) setDetailActivity(found);
        }
    }, []);

    useEffect(() => {
        const handlePopState = () => {
            const params = new URLSearchParams(window.location.search);
            const detailId = params.get('detail');
            if (detailId) {
                const found = activities.find((a) => a.id === detailId);
                if (found) setDetailActivity(found);
            } else {
                setDetailActivity(null);
            }
        };
        window.addEventListener('popstate', handlePopState);
        return () => window.removeEventListener('popstate', handlePopState);
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
    const datedScheduleActivities = filteredActivities.filter(
        (activity) => activity.fecha_inicio || activity.fecha_limite,
    );
    const unscheduledActivities = filteredActivities.filter(
        (activity) => !activity.fecha_inicio && !activity.fecha_limite,
    );
    const projectActivityRoute = (name: string, activity: Activity) =>
        route(name, [activity.proyecto.id, activity.id]);

    const moduleBreadcrumbs: BreadcrumbItem[] = currentProject
        ? [
              { title: 'Proyectos', href: route('proyectos.index') },
              {
                  title: currentProject.nombre,
                  href: route('proyectos.show', currentProject.id),
              },
              {
                  title: 'Actividades',
                  href: route('proyectos.activities.index', currentProject.id),
              },
          ]
        : breadcrumbs;

    const changeView = (nextView: Extract<ModuleView, 'list' | 'kanban' | 'schedule'>) => {
        setView(nextView);

        const url = new URL(window.location.href);
        url.searchParams.set('view', nextView);
        window.history.replaceState({}, '', `${url.pathname}${url.search}`);
    };

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
                    <button
                        type="button"
                        className="text-left font-medium hover:text-primary hover:underline"
                        onClick={() => openDetailDialog(activity)}
                    >
                        {activity.titulo}
                    </button>
                    <div className="text-xs text-muted-foreground">
                        {label(activity.kanban_column)}
                    </div>
                </div>
            ),
        },
        {
            key: 'tipo',
            header: 'Tipo',
            accessor: (activity) => activity.tipo,
            cell: (activity) => <Badge variant="outline">{label(activity.tipo)}</Badge>,
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
            key: 'fecha_inicio',
            header: 'Fecha inicio',
            cell: (activity) => formatDate(activity.fecha_inicio),
        },
        {
            key: 'fecha_limite',
            header: 'Fecha limite',
            cell: (activity) => formatDate(activity.fecha_limite),
        },
        {
            key: 'tiempo_estimado',
            header: 'Tiempo estimado',
            cell: (activity) => formatMinutes(activity.minutos_estimados),
        },
        {
            key: 'tiempo_real',
            header: 'Tiempo real',
            cell: (activity) => formatMinutes(activity.minutos_reales),
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
                        <DropdownMenuItem onClick={() => openDetailDialog(activity)}>
                                <Eye className="mr-2 size-4" /> Ver resumen
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
                                    <Link
                                        href={projectActivityRoute(
                                            'proyectos.activities.times.create',
                                            activity,
                                        )}
                                    >
                                        <Clock className="mr-2 size-4" />{' '}
                                        Registrar tiempo
                                    </Link>
                                </DropdownMenuItem>
                                <DropdownMenuItem asChild>
                                    <Link
                                        href={projectActivityRoute(
                                            'proyectos.activities.tickets.create',
                                            activity,
                                        )}
                                    >
                                        <Ticket className="mr-2 size-4" />{' '}
                                        Relacionar ticket
                                    </Link>
                                </DropdownMenuItem>
                                <DropdownMenuItem asChild>
                                    <Link
                                        href={projectActivityRoute(
                                            'proyectos.activities.create-ticket.create',
                                            activity,
                                        )}
                                    >
                                        <Plus className="mr-2 size-4" /> Crear
                                        ticket
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
        <AppLayout breadcrumbs={moduleBreadcrumbs}>
            <Head title="Actividades" />

            <div className="space-y-4 rounded-xl p-4">
                <ModuleHeader
                    title={currentProject ? `Actividades - ${currentProject.nombre}` : 'Actividades'}
                    description="Gestiona el trabajo interno desde una sola pantalla con lista, kanban y cronograma."
                >
                    {canManage && (
                        <Button onClick={openCreate}>
                            <Plus className="size-4" /> Nueva actividad
                        </Button>
                    )}
                </ModuleHeader>

                {(view === 'list' || view === 'kanban' || view === 'schedule') && (
                    <div className="inline-flex rounded-md border bg-muted/30 p-1">
                        <Button
                            type="button"
                            variant={view === 'list' ? 'default' : 'ghost'}
                            size="sm"
                            onClick={() => changeView('list')}
                        >
                            <ClipboardList className="size-4" /> Lista
                        </Button>
                        <Button
                            type="button"
                            variant={view === 'kanban' ? 'default' : 'ghost'}
                            size="sm"
                            onClick={() => changeView('kanban')}
                        >
                            <KanbanSquare className="size-4" /> Kanban
                        </Button>
                        <Button
                            type="button"
                            variant={view === 'schedule' ? 'default' : 'ghost'}
                            size="sm"
                            onClick={() => changeView('schedule')}
                        >
                            <CalendarDays className="size-4" /> Cronograma
                        </Button>
                    </div>
                )}

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
                                                        onClick={() => openDetailDialog(activity)}
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
                                                        className={`gap-3 rounded-lg py-4 shadow-none ${canMoveKanban ? 'cursor-grab active:cursor-grabbing' : 'cursor-pointer'} ${draggingActivityId === activity.id ? 'opacity-60' : ''}`}
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
                                                    <ContextMenuItem
                                                        onSelect={() =>
                                                            openDetailDialog(
                                                                activity,
                                                            )
                                                        }
                                                    >
                                                            <Eye className="size-4" />{' '}
                                                            Gestionar
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
                                                            {canMoveKanban &&
                                                                visibleKanbanColumns
                                                                    .filter(
                                                                        (targetColumn) =>
                                                                            targetColumn !==
                                                                            activity.kanban_column,
                                                                    )
                                                                    .map((targetColumn) => (
                                                                        <ContextMenuItem
                                                                            key={targetColumn}
                                                                            onSelect={() =>
                                                                                moveActivity(
                                                                                    activity,
                                                                                    targetColumn,
                                                                                )
                                                                            }
                                                                        >
                                                                            <KanbanSquare className="size-4" />{' '}
                                                                            Mover a {label(targetColumn)}
                                                                        </ContextMenuItem>
                                                                    ))}
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

                {view === 'schedule' && (
                    <GanttSchedule
                        activities={datedScheduleActivities}
                        unscheduledActivities={unscheduledActivities}
                        onSelectActivity={openDetailDialog}
                    />
                )}
            </div>

            <ActivityDetailDialog
                activity={detailActivity}
                open={detailActivity !== null}
                onOpenChange={(open) => !open && closeDetailDialog()}
                users={users}
                estadoOptions={estadoOptions}
                prioridadOptions={prioridadOptions}
                tipoOptions={tipoOptions}
                canManage={canManage}
                canRegisterTime={permissions.includes('project-planning.activities.time')}
                canMoveKanban={canMoveKanban}
                canCreateTicket={permissions.includes('tickets.create')}
                canViewTickets={permissions.includes('tickets.view') || permissions.includes('tickets.manage')}
                onFiles={() => {
                    if (!detailActivity) return;
                    setFilesActivity(detailActivity);
                }}
                onComplete={(activity) =>
                    router.patch(
                        route('activities.complete', activity.id),
                        {},
                        { preserveScroll: true },
                    )
                }
                onCancel={(activity) =>
                    router.patch(
                        route('activities.cancel', activity.id),
                        {},
                        { preserveScroll: true },
                    )
                }
            />

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
                                    ? {
                                          ...current,
                                          files:
                                              current.files?.filter(
                                                  (f) => f.id !== fileId,
                                              ) ?? [],
                                      }
                                    : null,
                            );
                        },
                        onError: () =>
                            toast.error('No se pudo eliminar el archivo.'),
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

function GanttSchedule({
    activities,
    unscheduledActivities,
    onSelectActivity,
}: {
    activities: Activity[];
    unscheduledActivities: Activity[];
    onSelectActivity: (activity: Activity) => void;
}) {
    const containerRef = useRef<HTMLDivElement | null>(null);
    const [ganttViewMode, setGanttViewMode] =
        useState<GanttViewMode>('Week');
    const tasks = useMemo(
        () =>
            activities
                .map((activity): GanttTask | null => {
                    const fallbackDate = parseDate(
                        activity.fecha_inicio ?? activity.fecha_limite,
                    );
                    if (!fallbackDate) return null;

                    const startDate =
                        parseDate(activity.fecha_inicio) ?? fallbackDate;
                    let endDate = parseDate(activity.fecha_limite) ?? startDate;

                    if (endDate.getTime() <= startDate.getTime()) {
                        endDate = addDays(startDate, 1);
                    }

                    return {
                        id: activity.id,
                        activityId: activity.id,
                        name: activity.titulo,
                        start: toDateString(startDate),
                        end: toDateString(endDate),
                        progress: activityProgress(activity),
                        custom_class: `activity-priority-${activity.prioridad}`,
                        description: activity.descripcion ?? '',
                        status: activity.estado,
                        priority: activity.prioridad,
                        responsible:
                            activity.responsable?.name ?? 'Sin responsable',
                    };
                })
                .filter((task): task is GanttTask => task !== null),
        [activities],
    );

    useEffect(() => {
        const container = containerRef.current;
        if (!container || tasks.length === 0) return;

        container.replaceChildren();

        const chart = new Gantt(container, tasks, {
            view_mode: ganttViewMode,
            view_mode_select: false,
            language: 'es',
            readonly: true,
            readonly_dates: true,
            readonly_progress: true,
            today_button: false,
            popup_on: 'click',
            scroll_to: 'start',
            bar_height: 26,
            padding: 18,
            container_height: 'auto',
            on_click: (task) => {
                const activity = activities.find(
                    (item) => item.id === task.activityId,
                );
                if (activity) onSelectActivity(activity);
            },
            popup: ({ task, set_title, set_subtitle, set_details }) => {
                set_title(escapeHtml(task.name));
                set_subtitle(
                    `${escapeHtml(label(task.status ?? 'pendiente'))} · ${escapeHtml(task.priority ?? 'media')}`,
                );
                set_details(
                    `${escapeHtml(task.responsible ?? 'Sin responsable')}<br>${formatDate(task.start)} - ${formatDate(task.end)}`,
                );
            },
        });

        chart.change_view_mode(ganttViewMode, true);

        return () => {
            container.replaceChildren();
        };
    }, [activities, ganttViewMode, onSelectActivity, tasks]);

    return (
        <div className="space-y-4">
            {tasks.length === 0 ? (
                <div className="rounded-lg border p-8 text-center text-sm text-muted-foreground">
                    No hay actividades con fechas para graficar.
                </div>
            ) : (
                <div className="rounded-lg border bg-card p-3">
                    <div className="mb-3 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h2 className="font-semibold">Gantt de actividades</h2>
                            <p className="text-sm text-muted-foreground">
                                {tasks.length} actividades con fecha de inicio o limite.
                            </p>
                        </div>
                        <div className="inline-flex rounded-md border bg-muted/30 p-1">
                            {ganttViewOptions.map((option) => (
                                <Button
                                    key={option.value}
                                    type="button"
                                    size="sm"
                                    variant={
                                        ganttViewMode === option.value
                                            ? 'default'
                                            : 'ghost'
                                    }
                                    onClick={() =>
                                        setGanttViewMode(option.value)
                                    }
                                >
                                    {option.label}
                                </Button>
                            ))}
                        </div>
                    </div>
                    <div className="overflow-x-auto">
                        <div ref={containerRef} className="min-w-[820px]" />
                    </div>
                </div>
            )}

            {unscheduledActivities.length > 0 && (
                <section className="space-y-3 rounded-lg border p-4">
                    <div className="flex items-center justify-between gap-3">
                        <h2 className="font-semibold">Sin fecha</h2>
                        <Badge variant="secondary">
                            {unscheduledActivities.length}
                        </Badge>
                    </div>
                    <div className="grid gap-2 md:grid-cols-2">
                        {unscheduledActivities.map((activity) => (
                            <button
                                key={activity.id}
                                type="button"
                                className="rounded-md border p-3 text-left transition-colors hover:border-primary/60 hover:bg-muted/40"
                                onClick={() => onSelectActivity(activity)}
                            >
                                <div className="font-medium">{activity.titulo}</div>
                                <div className="mt-2 flex flex-wrap gap-2">
                                    <Badge variant={statusVariant(activity.estado)}>
                                        {label(activity.estado)}
                                    </Badge>
                                    <Badge variant={priorityVariant(activity.prioridad)}>
                                        {activity.prioridad}
                                    </Badge>
                                </div>
                            </button>
                        ))}
                    </div>
                </section>
            )}
        </div>
    );
}

function escapeHtml(value: string): string {
    return value
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

type ActivityDetailDialogProps = {
    activity: Activity | null;
    open: boolean;
    onOpenChange: (open: boolean) => void;
    users: UserOption[];
    estadoOptions: string[];
    prioridadOptions: string[];
    tipoOptions: string[];
    canManage: boolean;
    canRegisterTime: boolean;
    canMoveKanban: boolean;
    canCreateTicket: boolean;
    canViewTickets: boolean;
    onFiles: () => void;
    onComplete: (activity: Activity) => void;
    onCancel: (activity: Activity) => void;
};

function ActivityDetailDialog({
    activity,
    open,
    onOpenChange,
    users,
    estadoOptions,
    prioridadOptions,
    tipoOptions,
    canManage,
    canRegisterTime,
    canMoveKanban,
    canCreateTicket,
    canViewTickets,
    onFiles,
    onComplete,
    onCancel,
}: ActivityDetailDialogProps) {
    const form = useForm<ActivityForm>({
        proyecto_id: '',
        titulo: '',
        descripcion: '',
        tipo: tipoOptions[0] ?? 'tarea',
        estado: 'pendiente',
        prioridad: 'media',
        responsable_id: '',
        fecha_inicio: '',
        fecha_limite: '',
        minutos_estimados: '',
    });
    const subtaskForm = useForm({ titulo: '', tipo: tipoOptions[0] ?? 'tarea', prioridad: 'media' });
    const timeForm = useForm({ descripcion: '', minutos: '', fecha: new Date().toISOString().slice(0, 10) });
    const commentForm = useForm({ descripcion: '' });
    const [subtaskFormOpen, setSubtaskFormOpen] = useState(false);
    const [timeFormOpen, setTimeFormOpen] = useState(false);
    const [commentFormOpen, setCommentFormOpen] = useState(false);

    useEffect(() => {
        if (!activity) return;

        form.setData({
            proyecto_id: activity.proyecto.id,
            titulo: activity.titulo,
            descripcion: activity.descripcion ?? '',
            tipo: activity.tipo,
            estado: activity.estado,
            prioridad: activity.prioridad,
            responsable_id: activity.responsable_id
                ? String(activity.responsable_id)
                : '',
            fecha_inicio: activity.fecha_inicio?.slice(0, 10) ?? '',
            fecha_limite: activity.fecha_limite?.slice(0, 10) ?? '',
            minutos_estimados: activity.minutos_estimados
                ? String(activity.minutos_estimados)
                : '',
        });
        form.clearErrors();
        setSubtaskFormOpen(false);
        setTimeFormOpen(false);
        setCommentFormOpen(false);
    }, [activity?.id]);

    if (!activity) return null;

    const projectId = activity.proyecto.id;

    const submitSubtask = (e: React.FormEvent) => {
        e.preventDefault();
        subtaskForm.transform((d) => ({ ...d, parent_id: activity.id, proyecto_id: projectId }));
        subtaskForm.post(route('proyectos.activities.store', projectId), {
            preserveScroll: true,
            onSuccess: () => { setSubtaskFormOpen(false); subtaskForm.reset(); },
        });
    };

    const submitTime = (e: React.FormEvent) => {
        e.preventDefault();
        timeForm.post(route('proyectos.activities.times.store', [projectId, activity.id]), {
            preserveScroll: true,
            onSuccess: () => { setTimeFormOpen(false); timeForm.setData({ descripcion: '', minutos: '', fecha: new Date().toISOString().slice(0, 10) }); },
        });
    };

    const submitComment = (e: React.FormEvent) => {
        e.preventDefault();
        commentForm.transform((d) => ({ ...d, fecha: new Date().toISOString().slice(0, 10) }));
        commentForm.post(route('proyectos.activities.times.store', [projectId, activity.id]), {
            preserveScroll: true,
            onSuccess: () => { setCommentFormOpen(false); commentForm.reset(); },
        });
    };
    const relatedTickets = [
        activity.ticket ? { id: 'main', tipo_relacion: 'principal', ticket: activity.ticket } : null,
        ...(activity.ticket_links ?? []),
    ].filter((item): item is ActivityTicketLink => Boolean(item?.ticket));

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        form.patch(route('activities.update', activity.id), {
            preserveScroll: true,
        });
    };

    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent className="max-h-[92vh] overflow-y-auto sm:max-w-6xl">
                <DialogHeader>
                    <DialogDescription>
                        {activity.proyecto.nombre} / ACT-{activity.id.slice(0, 8)}
                    </DialogDescription>
                    <DialogTitle className="text-xl leading-tight">
                        {activity.titulo}
                    </DialogTitle>
                </DialogHeader>

                <div className="grid gap-6 lg:grid-cols-[minmax(0,1fr)_340px]">
                    <section className="space-y-5">
                        <form className="space-y-5" onSubmit={submit}>
                            <FormInputField
                                id="detail-title"
                                label="Titulo"
                                value={form.data.titulo}
                                error={form.errors.titulo}
                                disabled={!canManage}
                                onChange={(event) =>
                                    form.setData('titulo', event.target.value)
                                }
                            />

                            <FormTextareaField
                                id="detail-description"
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

                            <div className="grid gap-4 md:grid-cols-2">
                                <Field>
                                    <Label>Estado</Label>
                                    <Select
                                        value={form.data.estado}
                                        onValueChange={(value) =>
                                            form.setData('estado', value)
                                        }
                                        disabled={!canManage}
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
                                    {form.errors.estado && (
                                        <FieldError>{form.errors.estado}</FieldError>
                                    )}
                                </Field>
                                <Field>
                                    <Label>Prioridad</Label>
                                    <Select
                                        value={form.data.prioridad}
                                        onValueChange={(value) =>
                                            form.setData('prioridad', value)
                                        }
                                        disabled={!canManage}
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
                                    {form.errors.prioridad && (
                                        <FieldError>{form.errors.prioridad}</FieldError>
                                    )}
                                </Field>
                            </div>

                            <div className="grid gap-4 md:grid-cols-3">
                                <FormInputField
                                    id="detail-start"
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
                                    id="detail-due"
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
                                    id="detail-estimated"
                                    label="Minutos estimados"
                                    type="number"
                                    min="0"
                                    value={form.data.minutos_estimados}
                                    error={form.errors.minutos_estimados}
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
                                <Button type="submit" disabled={form.processing}>
                                    Guardar cambios
                                </Button>
                            )}
                        </form>

                        <DialogSection
                            title="Subtareas"
                            empty={(activity.children ?? []).length === 0 && !subtaskFormOpen}
                            emptyMessage="Sin subtareas registradas."
                            action={canManage && !subtaskFormOpen ? (
                                <Button size="sm" variant="outline" onClick={() => setSubtaskFormOpen(true)}>
                                    <Plus className="size-4" /> Agregar subtarea
                                </Button>
                            ) : undefined}
                        >
                            {subtaskFormOpen && (
                                <form onSubmit={submitSubtask} className="space-y-3 rounded-md border p-3">
                                    <FormInputField id="subtask-title" label="Titulo" value={subtaskForm.data.titulo} error={subtaskForm.errors.titulo} onChange={(e) => subtaskForm.setData('titulo', e.target.value)} />
                                    <div className="grid gap-3 sm:grid-cols-2">
                                        <div className="space-y-1">
                                            <Label className="text-xs text-muted-foreground">Tipo</Label>
                                            <Select value={subtaskForm.data.tipo} onValueChange={(v) => subtaskForm.setData('tipo', v)}>
                                                <SelectTrigger><SelectValue /></SelectTrigger>
                                                <SelectContent>{tipoOptions.map((o) => <SelectItem key={o} value={o}>{label(o)}</SelectItem>)}</SelectContent>
                                            </Select>
                                        </div>
                                        <div className="space-y-1">
                                            <Label className="text-xs text-muted-foreground">Prioridad</Label>
                                            <Select value={subtaskForm.data.prioridad} onValueChange={(v) => subtaskForm.setData('prioridad', v)}>
                                                <SelectTrigger><SelectValue /></SelectTrigger>
                                                <SelectContent>{prioridadOptions.map((o) => <SelectItem key={o} value={o}>{o}</SelectItem>)}</SelectContent>
                                            </Select>
                                        </div>
                                    </div>
                                    <div className="flex justify-end gap-2">
                                        <Button type="button" size="sm" variant="outline" onClick={() => { setSubtaskFormOpen(false); subtaskForm.reset(); }}>Cancelar</Button>
                                        <Button type="submit" size="sm" disabled={subtaskForm.processing}>Guardar subtarea</Button>
                                    </div>
                                </form>
                            )}
                            {activity.children?.map((child) => (
                                <RelatedActivityRow key={child.id} activity={child} />
                            ))}
                        </DialogSection>

                        <DialogSection
                            title="Actividades vinculadas / tickets vinculados"
                            empty={relatedTickets.length === 0}
                            emptyMessage="Sin tickets relacionados."
                        >
                            {relatedTickets.map((link) =>
                                link.ticket ? (
                                    <div
                                        key={link.id}
                                        className="flex items-start justify-between gap-3 rounded-md border p-3"
                                    >
                                        <div className="min-w-0">
                                            <div className="font-medium">
                                                {link.ticket.folio ?? 'Ticket'}
                                            </div>
                                            <div className="text-sm text-muted-foreground">
                                                {link.ticket.titulo}
                                            </div>
                                        </div>
                                        {canViewTickets ? (
                                            <Button asChild size="sm" variant="outline">
                                                <Link href={route('tickets.show', link.ticket.id)}>
                                                    Abrir
                                                </Link>
                                            </Button>
                                        ) : (
                                            <Badge variant="outline">
                                                {label(link.tipo_relacion)}
                                            </Badge>
                                        )}
                                    </div>
                                ) : null,
                            )}
                        </DialogSection>

                        <DialogSection
                            title="Tiempos"
                            empty={(activity.tiempos ?? []).filter((t) => t.minutos && t.minutos > 0).length === 0 && !timeFormOpen}
                            emptyMessage="Sin tiempos registrados."
                            action={canRegisterTime && !timeFormOpen ? (
                                <Button size="sm" variant="outline" onClick={() => setTimeFormOpen(true)}>
                                    <Clock className="size-4" /> Registrar tiempo
                                </Button>
                            ) : undefined}
                        >
                            {timeFormOpen && (
                                <form onSubmit={submitTime} className="space-y-3 rounded-md border p-3">
                                    <FormTextareaField id="time-desc" label="Descripcion" value={timeForm.data.descripcion} error={timeForm.errors.descripcion} rows={2} onChange={(e) => timeForm.setData('descripcion', e.target.value)} />
                                    <div className="grid gap-3 sm:grid-cols-2">
                                        <FormInputField id="time-min" label="Minutos" type="number" min="1" value={timeForm.data.minutos} error={timeForm.errors.minutos} onChange={(e) => timeForm.setData('minutos', e.target.value)} />
                                        <FormInputField id="time-date" label="Fecha" type="date" value={timeForm.data.fecha} error={timeForm.errors.fecha} onChange={(e) => timeForm.setData('fecha', e.target.value)} />
                                    </div>
                                    <div className="flex justify-end gap-2">
                                        <Button type="button" size="sm" variant="outline" onClick={() => { setTimeFormOpen(false); timeForm.reset(); }}>Cancelar</Button>
                                        <Button type="submit" size="sm" disabled={timeForm.processing}>Guardar tiempo</Button>
                                    </div>
                                </form>
                            )}
                            {(activity.tiempos ?? []).filter((t) => t.minutos && t.minutos > 0).map((time) => (
                                <div key={time.id} className="flex gap-3 rounded-md border p-3">
                                    <div className="flex size-8 shrink-0 items-center justify-center rounded-full bg-primary text-xs font-semibold text-primary-foreground">
                                        {initials(time.usuario?.name)}
                                    </div>
                                    <div className="min-w-0 flex-1 space-y-1">
                                        <div className="flex flex-wrap items-center gap-2 text-sm">
                                            <span className="font-medium">{time.usuario?.name ?? 'Sistema'}</span>
                                            <Badge variant="outline">{formatMinutes(time.minutos)}</Badge>
                                            <span className="text-xs text-muted-foreground">{formatDate(time.created_at ?? time.fecha)}</span>
                                        </div>
                                        <p className="text-sm whitespace-pre-line text-muted-foreground">{time.descripcion}</p>
                                    </div>
                                </div>
                            ))}
                        </DialogSection>

                        <DialogSection
                            title="Comentarios"
                            empty={(activity.tiempos ?? []).filter((t) => !t.minutos || t.minutos === 0).length === 0 && !commentFormOpen}
                            emptyMessage="Sin comentarios registrados."
                            action={canRegisterTime && !commentFormOpen ? (
                                <Button size="sm" variant="outline" onClick={() => setCommentFormOpen(true)}>
                                    <MessageSquare className="size-4" /> Agregar comentario
                                </Button>
                            ) : undefined}
                        >
                            {commentFormOpen && (
                                <form onSubmit={submitComment} className="space-y-3 rounded-md border p-3">
                                    <FormTextareaField id="comment-desc" label="Comentario" value={commentForm.data.descripcion} error={commentForm.errors.descripcion} rows={3} onChange={(e) => commentForm.setData('descripcion', e.target.value)} />
                                    <div className="flex justify-end gap-2">
                                        <Button type="button" size="sm" variant="outline" onClick={() => { setCommentFormOpen(false); commentForm.reset(); }}>Cancelar</Button>
                                        <Button type="submit" size="sm" disabled={commentForm.processing}>Guardar comentario</Button>
                                    </div>
                                </form>
                            )}
                            {(activity.tiempos ?? []).filter((t) => !t.minutos || t.minutos === 0).map((time) => (
                                <div key={time.id} className="flex gap-3 rounded-md border p-3">
                                    <div className="flex size-8 shrink-0 items-center justify-center rounded-full bg-muted text-xs font-semibold text-muted-foreground">
                                        {initials(time.usuario?.name)}
                                    </div>
                                    <div className="min-w-0 flex-1 space-y-1">
                                        <div className="flex flex-wrap items-center gap-2 text-sm">
                                            <span className="font-medium">{time.usuario?.name ?? 'Sistema'}</span>
                                            <span className="text-xs text-muted-foreground">{formatDate(time.created_at ?? time.fecha)}</span>
                                        </div>
                                        <p className="text-sm whitespace-pre-line text-muted-foreground">{time.descripcion}</p>
                                    </div>
                                </div>
                            ))}
                        </DialogSection>
                    </section>

                    <aside className="space-y-4">
                        <div className="rounded-lg border p-4">
                            <div className="mb-3 flex flex-wrap gap-2">
                                <Badge variant={statusVariant(activity.estado)}>
                                    {label(activity.estado)}
                                </Badge>
                                <Badge variant={priorityVariant(activity.prioridad)}>
                                    {activity.prioridad}
                                </Badge>
                                {isOverdue(activity) && (
                                    <Badge variant="destructive">Vencida</Badge>
                                )}
                            </div>
                            <div className="space-y-3 text-sm">
                                <DetailRow label="Responsable">
                                    <Select
                                        value={form.data.responsable_id || 'sin_responsable'}
                                        onValueChange={(value) =>
                                            form.setData(
                                                'responsable_id',
                                                value === 'sin_responsable' ? '' : value,
                                            )
                                        }
                                        disabled={!canManage}
                                    >
                                        <SelectTrigger>
                                            <SelectValue />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="sin_responsable">
                                                Sin responsable
                                            </SelectItem>
                                            {users.map((user) => (
                                                <SelectItem key={user.id} value={String(user.id)}>
                                                    {user.name}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                </DetailRow>
                                <DetailRow label="Tipo">
                                    <Select
                                        value={form.data.tipo}
                                        onValueChange={(value) =>
                                            form.setData('tipo', value)
                                        }
                                        disabled={!canManage}
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
                                </DetailRow>
                                <DetailRow label="Actividad padre">
                                    {activity.parent?.titulo ?? '-'}
                                </DetailRow>
                                <DetailRow label="Fecha inicio">
                                    {formatDate(activity.fecha_inicio)}
                                </DetailRow>
                                <DetailRow label="Fecha limite">
                                    {formatDate(activity.fecha_limite)}
                                </DetailRow>
                                <DetailRow label="Informador">
                                    {activity.reportado_por?.name ?? activity.created_by?.name ?? '-'}
                                </DetailRow>
                                <DetailRow label="Tiempo estimado">
                                    {formatMinutes(activity.minutos_estimados)}
                                </DetailRow>
                                <DetailRow label="Tiempo real">
                                    {formatMinutes(activity.minutos_reales)}
                                </DetailRow>
                                <DetailRow label="Etiquetas">
                                    {activity.tags?.length ? activity.tags.join(', ') : '-'}
                                </DetailRow>
                            </div>
                        </div>

                        <div className="space-y-2 rounded-lg border p-4">
                            {canRegisterTime && (
                                <Button asChild variant="outline" className="w-full justify-start">
                                    <Link
                                        href={route('proyectos.activities.times.create', [
                                            projectId,
                                            activity.id,
                                        ])}
                                    >
                                        <Clock className="size-4" />
                                        Registrar tiempo
                                    </Link>
                                </Button>
                            )}
                            {canManage && (
                                <Button asChild variant="outline" className="w-full justify-start">
                                    <Link
                                        href={route('proyectos.activities.tickets.create', [
                                            projectId,
                                            activity.id,
                                        ])}
                                    >
                                        <Ticket className="size-4" />
                                        Relacionar ticket
                                    </Link>
                                </Button>
                            )}
                            {canCreateTicket && (
                                <Button asChild variant="outline" className="w-full justify-start">
                                    <Link
                                        href={route(
                                            'proyectos.activities.create-ticket.create',
                                            [projectId, activity.id],
                                        )}
                                    >
                                        <Plus className="size-4" />
                                        Crear ticket
                                    </Link>
                                </Button>
                            )}
                            {canManage && (
                                <Button
                                    type="button"
                                    variant="outline"
                                    className="w-full justify-start"
                                    onClick={onFiles}
                                >
                                    <Paperclip className="size-4" />
                                    Archivos
                                </Button>
                            )}
                            {canManage && activity.estado !== 'terminada' && (
                                <Button
                                    type="button"
                                    variant="outline"
                                    className="w-full justify-start"
                                    onClick={() => onComplete(activity)}
                                >
                                    <CheckCircle2 className="size-4" />
                                    Marcar terminada
                                </Button>
                            )}
                            {canManage && activity.estado !== 'cancelada' && activity.estado !== 'terminada' && (
                                <Button
                                    type="button"
                                    variant="destructive"
                                    className="w-full justify-start"
                                    onClick={() => onCancel(activity)}
                                >
                                    <XCircle className="size-4" />
                                    Cancelar actividad
                                </Button>
                            )}
                        </div>
                    </aside>
                </div>
            </DialogContent>
        </Dialog>
    );
}

function DialogSection({
    title,
    empty,
    emptyMessage,
    action,
    children,
}: {
    title: string;
    empty: boolean;
    emptyMessage: string;
    action?: React.ReactNode;
    children: React.ReactNode;
}) {
    return (
        <section className="space-y-3 rounded-lg border p-4">
            <div className="flex flex-wrap items-center justify-between gap-3">
                <h3 className="font-semibold">{title}</h3>
                {action}
            </div>
            {empty ? (
                <p className="text-sm text-muted-foreground">{emptyMessage}</p>
            ) : (
                <div className="space-y-3">{children}</div>
            )}
        </section>
    );
}

function DetailRow({
    label,
    children,
}: {
    label: string;
    children: React.ReactNode;
}) {
    return (
        <div className="grid gap-2">
            <span className="text-xs text-muted-foreground">{label}</span>
            <div className="min-w-0 font-medium">{children}</div>
        </div>
    );
}

function RelatedActivityRow({ activity }: { activity: RelatedActivity }) {
    return (
        <div className="flex items-start justify-between gap-3 rounded-md border p-3">
            <div className="min-w-0">
                <div className="truncate text-sm font-medium">
                    {activity.titulo}
                </div>
                <div className="text-xs text-muted-foreground">
                    {label(activity.kanban_column ?? activity.estado)}
                </div>
            </div>
            <Badge variant={statusVariant(activity.estado)}>
                {label(activity.estado)}
            </Badge>
        </div>
    );
}
