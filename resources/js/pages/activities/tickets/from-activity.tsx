import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { ArrowLeft, Plus } from 'lucide-react';
import type React from 'react';
import { useEffect } from 'react';
import { toast } from 'sonner';
import { route } from 'ziggy-js';
import { LoadingSubmitButton } from '@/components/loading-submit-button';
import { ModuleHeader } from '@/components/module-header';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Field, FieldError } from '@/components/ui/field';
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

type Proyecto = { id: string; nombre: string };

type Activity = {
    id: string;
    titulo: string;
    estado: string;
    prioridad: string;
    proyecto: Proyecto;
};

type CatalogOption = { id: number; nombre: string };

type CreateTicketForm = {
    tipo_id: string;
    prioridad_id: string;
    crear_como_borrador: boolean;
};

function label(value: string): string {
    return value.replaceAll('_', ' ');
}

export default function CreateTicketFromActivity({
    proyecto,
    activity,
    ticketTypes,
    ticketPriorities,
}: {
    proyecto: Proyecto;
    activity: Activity;
    ticketTypes: CatalogOption[];
    ticketPriorities: CatalogOption[];
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
            title: 'Crear ticket',
            href: route('proyectos.activities.create-ticket.create', [
                proyecto.id,
                activity.id,
            ]),
        },
    ];

    const form = useForm<CreateTicketForm>({
        tipo_id: ticketTypes[0] ? String(ticketTypes[0].id) : '',
        prioridad_id: ticketPriorities[0] ? String(ticketPriorities[0].id) : '',
        crear_como_borrador: false,
    });

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        form.post(
            route('proyectos.activities.create-ticket', [
                proyecto.id,
                activity.id,
            ]),
            { preserveScroll: true },
        );
    };

    const hasCatalogs = ticketTypes.length > 0 && ticketPriorities.length > 0;

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Crear ticket - ${activity.titulo}`} />

            <div className="space-y-4 p-4">
                <ModuleHeader
                    title="Crear ticket desde actividad"
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
                            {!hasCatalogs ? (
                                <p className="text-sm text-muted-foreground">
                                    Faltan catalogos activos de tipo o prioridad
                                    para crear el ticket.
                                </p>
                            ) : (
                                <form className="space-y-5" onSubmit={submit}>
                                    <Field>
                                        <Label>Tipo</Label>
                                        <Select
                                            value={form.data.tipo_id}
                                            onValueChange={(value) =>
                                                form.setData('tipo_id', value)
                                            }
                                        >
                                            <SelectTrigger>
                                                <SelectValue />
                                            </SelectTrigger>
                                            <SelectContent>
                                                {ticketTypes.map((type) => (
                                                    <SelectItem
                                                        key={type.id}
                                                        value={String(type.id)}
                                                    >
                                                        {type.nombre}
                                                    </SelectItem>
                                                ))}
                                            </SelectContent>
                                        </Select>
                                        {form.errors.tipo_id && (
                                            <FieldError>
                                                {form.errors.tipo_id}
                                            </FieldError>
                                        )}
                                    </Field>
                                    <Field>
                                        <Label>Prioridad</Label>
                                        <Select
                                            value={form.data.prioridad_id}
                                            onValueChange={(value) =>
                                                form.setData(
                                                    'prioridad_id',
                                                    value,
                                                )
                                            }
                                        >
                                            <SelectTrigger>
                                                <SelectValue />
                                            </SelectTrigger>
                                            <SelectContent>
                                                {ticketPriorities.map(
                                                    (priority) => (
                                                        <SelectItem
                                                            key={priority.id}
                                                            value={String(
                                                                priority.id,
                                                            )}
                                                        >
                                                            {priority.nombre}
                                                        </SelectItem>
                                                    ),
                                                )}
                                            </SelectContent>
                                        </Select>
                                        {form.errors.prioridad_id && (
                                            <FieldError>
                                                {form.errors.prioridad_id}
                                            </FieldError>
                                        )}
                                    </Field>
                                    <label className="flex items-center gap-2 text-sm">
                                        <Checkbox
                                            checked={
                                                form.data.crear_como_borrador
                                            }
                                            onCheckedChange={(value) =>
                                                form.setData(
                                                    'crear_como_borrador',
                                                    Boolean(value),
                                                )
                                            }
                                        />
                                        Crear como borrador
                                    </label>
                                    <LoadingSubmitButton
                                        label="Crear ticket"
                                        processing={form.processing}
                                    />
                                </form>
                            )}
                        </CardContent>
                    </Card>

                    <Card className="rounded-lg">
                        <CardContent className="space-y-4 pt-6 text-sm">
                            <div className="flex items-center gap-2">
                                <Plus className="size-4 text-primary" />
                                <span className="font-medium">Actividad</span>
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
