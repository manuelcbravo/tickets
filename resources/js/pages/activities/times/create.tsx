import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { ArrowLeft, Clock } from 'lucide-react';
import type React from 'react';
import { useEffect } from 'react';
import { toast } from 'sonner';
import { route } from 'ziggy-js';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { LoadingSubmitButton } from '@/components/loading-submit-button';
import { ModuleHeader } from '@/components/module-header';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type Proyecto = { id: string; nombre: string };

type Activity = {
    id: string;
    titulo: string;
    descripcion: string | null;
    estado: string;
    prioridad: string;
    minutos_reales: number;
    proyecto: Proyecto;
    responsable?: { id: number; name: string } | null;
};

type TimeForm = {
    descripcion: string;
    minutos: string;
    fecha: string;
    iniciado_at: string;
    terminado_at: string;
};

function label(value: string): string {
    return value.replaceAll('_', ' ');
}

export default function CreateActivityTime({
    proyecto,
    activity,
}: {
    proyecto: Proyecto;
    activity: Activity;
}) {
    const { flash } = usePage<SharedData>().props;

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash]);

    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Proyectos', href: route('proyectos.index') },
        { title: proyecto.nombre, href: route('proyectos.show', proyecto.id) },
        {
            title: 'Actividades',
            href: route('proyectos.activities.index', proyecto.id),
        },
        {
            title: 'Registrar tiempo',
            href: route('proyectos.activities.times.create', [
                proyecto.id,
                activity.id,
            ]),
        },
    ];

    const form = useForm<TimeForm>({
        descripcion: '',
        minutos: '',
        fecha: new Date().toISOString().slice(0, 10),
        iniciado_at: '',
        terminado_at: '',
    });

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        form.post(
            route('proyectos.activities.times.store', [
                proyecto.id,
                activity.id,
            ]),
            {
                preserveScroll: true,
                onSuccess: () =>
                    form.setData({
                        descripcion: '',
                        minutos: '',
                        fecha: new Date().toISOString().slice(0, 10),
                        iniciado_at: '',
                        terminado_at: '',
                    }),
            },
        );
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Registrar tiempo - ${activity.titulo}`} />

            <div className="space-y-4 p-4">
                <ModuleHeader
                    title="Registrar tiempo"
                    description={activity.titulo}
                >
                    <Button asChild variant="outline">
                        <Link
                            href={route('proyectos.activities.show', [
                                proyecto.id,
                                activity.id,
                            ])}
                        >
                            <ArrowLeft className="size-4" /> Volver
                        </Link>
                    </Button>
                </ModuleHeader>

                <div className="grid gap-6 lg:grid-cols-[minmax(0,1fr)_340px]">
                    <Card className="rounded-lg">
                        <CardContent className="pt-6">
                            <form className="space-y-5" onSubmit={submit}>
                                <FormTextareaField
                                    id="time-description"
                                    label="Descripcion"
                                    value={form.data.descripcion}
                                    error={form.errors.descripcion}
                                    onChange={(event) =>
                                        form.setData(
                                            'descripcion',
                                            event.target.value,
                                        )
                                    }
                                />
                                <div className="grid gap-4 md:grid-cols-2">
                                    <FormInputField
                                        id="time-minutes"
                                        label="Minutos"
                                        type="number"
                                        min="1"
                                        value={form.data.minutos}
                                        error={form.errors.minutos}
                                        onChange={(event) =>
                                            form.setData(
                                                'minutos',
                                                event.target.value,
                                            )
                                        }
                                    />
                                    <FormInputField
                                        id="time-date"
                                        label="Fecha"
                                        type="date"
                                        value={form.data.fecha}
                                        error={form.errors.fecha}
                                        onChange={(event) =>
                                            form.setData(
                                                'fecha',
                                                event.target.value,
                                            )
                                        }
                                    />
                                    <FormInputField
                                        id="time-started"
                                        label="Inicio"
                                        type="datetime-local"
                                        value={form.data.iniciado_at}
                                        error={form.errors.iniciado_at}
                                        onChange={(event) =>
                                            form.setData(
                                                'iniciado_at',
                                                event.target.value,
                                            )
                                        }
                                    />
                                    <FormInputField
                                        id="time-ended"
                                        label="Fin"
                                        type="datetime-local"
                                        value={form.data.terminado_at}
                                        error={form.errors.terminado_at}
                                        onChange={(event) =>
                                            form.setData(
                                                'terminado_at',
                                                event.target.value,
                                            )
                                        }
                                    />
                                </div>
                                <LoadingSubmitButton
                                    label="Guardar tiempo"
                                    processing={form.processing}
                                />
                            </form>
                        </CardContent>
                    </Card>

                    <Card className="rounded-lg">
                        <CardContent className="space-y-4 pt-6 text-sm">
                            <div className="flex items-center gap-2">
                                <Clock className="size-4 text-primary" />
                                <span className="font-medium">
                                    Datos de actividad
                                </span>
                            </div>
                            <Detail label="Proyecto" value={proyecto.nombre} />
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
                                value={activity.responsable?.name ?? '-'}
                            />
                            <div className="flex gap-2">
                                <Badge variant="outline">
                                    {activity.minutos_reales} min registrados
                                </Badge>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppLayout>
    );
}

function Detail({ label, value }: { label: string; value: string }) {
    return (
        <div className="grid grid-cols-[110px_minmax(0,1fr)] gap-3">
            <span className="text-muted-foreground">{label}</span>
            <span className="font-medium">{value}</span>
        </div>
    );
}
