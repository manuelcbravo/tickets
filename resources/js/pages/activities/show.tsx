import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import { ArrowLeft, CheckSquare2, ExternalLink } from 'lucide-react';
import type React from 'react';
import { route } from 'ziggy-js';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { LoadingSubmitButton } from '@/components/loading-submit-button';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
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

type Activity = {
    id: string;
    titulo: string;
    descripcion: string | null;
    tipo: string;
    estado: string;
    prioridad: string;
    responsable_id: number | null;
    reportado_por_id: number | null;
    ticket_id: string | null;
    parent_id: string | null;
    fecha_inicio: string | null;
    fecha_limite: string | null;
    minutos_estimados: number | null;
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
    tiempos?: ActivityTime[];
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

function label(value: string): string {
    return value.replaceAll('_', ' ');
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

export default function ActivityShow({
    activity,
}: {
    activity: Activity;
    estadoOptions: string[];
}) {
    const permissions = usePage<SharedData>().props.auth.permissions ?? [];
    const canManage = permissions.includes(
        'project-planning.activities.manage',
    );
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Tickets', href: route('tickets.dashboard') },
        { title: 'Actividades', href: route('activities.index') },
        { title: activity.titulo, href: route('activities.show', activity.id) },
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

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Actividad - ${activity.titulo}`} />

            <div className="space-y-4 p-4">
                <div className="flex items-center justify-between gap-3">
                    <Button variant="ghost" asChild>
                        <Link href={route('activities.index')}>
                            <ArrowLeft className="size-4" /> Volver
                        </Link>
                    </Button>
                    {activity.ticket && (
                        <Button variant="outline" asChild>
                            <Link
                                href={route('tickets.show', activity.ticket.id)}
                            >
                                <ExternalLink className="size-4" /> Ticket
                            </Link>
                        </Button>
                    )}
                </div>

                <div className="grid gap-6 lg:grid-cols-[minmax(0,1fr)_360px]">
                    <section className="space-y-6">
                        <div className="flex items-center gap-2 text-sm text-muted-foreground">
                            <CheckSquare2 className="size-4 text-primary" />
                            <span>{activity.proyecto.nombre}</span>
                            <span>/</span>
                            <Badge variant="outline">
                                {label(activity.estado)}
                            </Badge>
                        </div>

                        <form className="space-y-5" onSubmit={submit}>
                            <FormInputField
                                id="activity-title"
                                label="Titulo"
                                value={form.data.titulo}
                                error={form.errors.titulo}
                                disabled={!canManage}
                                onChange={(event) =>
                                    form.setData('titulo', event.target.value)
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

                            {canManage && (
                                <LoadingSubmitButton
                                    label="Guardar cambios"
                                    processing={form.processing}
                                />
                            )}
                        </form>

                        <Card className="rounded-lg">
                            <CardHeader>
                                <CardTitle>Comentarios</CardTitle>
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
                                            <div className="min-w-0 space-y-1">
                                                <div className="flex flex-wrap items-center gap-2 text-sm">
                                                    <span className="font-medium">
                                                        {time.usuario?.name ??
                                                            'Sistema'}
                                                    </span>
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
                    </section>

                    <aside className="space-y-4">
                        <Card className="rounded-lg">
                            <CardHeader>
                                <CardTitle>Detalles</CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-4 text-sm">
                                <Detail
                                    label="Estado"
                                    value={label(activity.estado)}
                                />
                                <Detail
                                    label="Prioridad"
                                    value={activity.prioridad}
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
                                    label="Cliente"
                                    value={
                                        activity.proyecto.cliente?.nombre ??
                                        activity.proyecto.cliente
                                            ?.razon_social ??
                                        '-'
                                    }
                                />
                            </CardContent>
                        </Card>
                    </aside>
                </div>
            </div>
        </AppLayout>
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
