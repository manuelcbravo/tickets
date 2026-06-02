import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { ArrowLeft, Link2 } from 'lucide-react';
import type React from 'react';
import { useEffect } from 'react';
import { toast } from 'sonner';
import { route } from 'ziggy-js';
import { LoadingSubmitButton } from '@/components/loading-submit-button';
import { ModuleHeader } from '@/components/module-header';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
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
    ticket?: { id: string; folio: string | null; titulo: string } | null;
};

type TicketOption = {
    id: string;
    folio: string | null;
    titulo: string;
};

type LinkForm = {
    ticket_id: string;
    tipo_relacion: string;
};

function label(value: string): string {
    return value.replaceAll('_', ' ');
}

export default function LinkActivityTicket({
    proyecto,
    activity,
    tickets,
    ticketRelationTypes,
}: {
    proyecto: Proyecto;
    activity: Activity;
    tickets: TicketOption[];
    ticketRelationTypes: string[];
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
            title: 'Relacionar ticket',
            href: route('proyectos.activities.tickets.create', [
                proyecto.id,
                activity.id,
            ]),
        },
    ];

    const form = useForm<LinkForm>({
        ticket_id: activity.ticket?.id ?? tickets[0]?.id ?? '',
        tipo_relacion: ticketRelationTypes[0] ?? 'relacionado',
    });

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        form.post(
            route('proyectos.activities.tickets.store', [
                proyecto.id,
                activity.id,
            ]),
            { preserveScroll: true },
        );
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Relacionar ticket - ${activity.titulo}`} />

            <div className="space-y-4 p-4">
                <ModuleHeader
                    title="Relacionar ticket"
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
                            {tickets.length === 0 ? (
                                <div className="space-y-4">
                                    <p className="text-sm text-muted-foreground">
                                        No hay tickets disponibles para este
                                        proyecto.
                                    </p>
                                    <Button asChild>
                                        <Link href={route('tickets.create')}>
                                            Crear ticket
                                        </Link>
                                    </Button>
                                </div>
                            ) : (
                                <form className="space-y-5" onSubmit={submit}>
                                    <Field>
                                        <Label>Ticket</Label>
                                        <Select
                                            value={form.data.ticket_id}
                                            onValueChange={(value) =>
                                                form.setData('ticket_id', value)
                                            }
                                        >
                                            <SelectTrigger>
                                                <SelectValue />
                                            </SelectTrigger>
                                            <SelectContent>
                                                {tickets.map((ticket) => (
                                                    <SelectItem
                                                        key={ticket.id}
                                                        value={ticket.id}
                                                    >
                                                        {ticket.folio ??
                                                            'Sin folio'}{' '}
                                                        - {ticket.titulo}
                                                    </SelectItem>
                                                ))}
                                            </SelectContent>
                                        </Select>
                                        {form.errors.ticket_id && (
                                            <FieldError>
                                                {form.errors.ticket_id}
                                            </FieldError>
                                        )}
                                    </Field>
                                    <Field>
                                        <Label>Relacion</Label>
                                        <Select
                                            value={form.data.tipo_relacion}
                                            onValueChange={(value) =>
                                                form.setData(
                                                    'tipo_relacion',
                                                    value,
                                                )
                                            }
                                        >
                                            <SelectTrigger>
                                                <SelectValue />
                                            </SelectTrigger>
                                            <SelectContent>
                                                {ticketRelationTypes.map(
                                                    (type) => (
                                                        <SelectItem
                                                            key={type}
                                                            value={type}
                                                        >
                                                            {label(type)}
                                                        </SelectItem>
                                                    ),
                                                )}
                                            </SelectContent>
                                        </Select>
                                        {form.errors.tipo_relacion && (
                                            <FieldError>
                                                {form.errors.tipo_relacion}
                                            </FieldError>
                                        )}
                                    </Field>
                                    <LoadingSubmitButton
                                        label="Relacionar ticket"
                                        processing={form.processing}
                                    />
                                </form>
                            )}
                        </CardContent>
                    </Card>

                    <Card className="rounded-lg">
                        <CardContent className="space-y-4 pt-6 text-sm">
                            <div className="flex items-center gap-2">
                                <Link2 className="size-4 text-primary" />
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
                            <Detail
                                label="Ticket actual"
                                value={
                                    activity.ticket
                                        ? `${activity.ticket.folio ?? 'Ticket'} - ${activity.ticket.titulo}`
                                        : '-'
                                }
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
