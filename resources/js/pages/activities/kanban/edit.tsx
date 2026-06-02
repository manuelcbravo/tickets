import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { ArrowLeft, KanbanSquare } from 'lucide-react';
import type React from 'react';
import { useEffect } from 'react';
import { toast } from 'sonner';
import { route } from 'ziggy-js';
import { FormInputField } from '@/components/form-input-field';
import { LoadingSubmitButton } from '@/components/loading-submit-button';
import { ModuleHeader } from '@/components/module-header';
import { Badge } from '@/components/ui/badge';
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
    kanban_column: string;
    proyecto: Proyecto;
    responsable?: { id: number; name: string } | null;
};

type KanbanForm = {
    kanban_column: string;
    orden: string;
};

function label(value: string): string {
    return value.replaceAll('_', ' ');
}

export default function EditActivityKanban({
    proyecto,
    activity,
    kanbanColumns,
}: {
    proyecto: Proyecto;
    activity: Activity;
    kanbanColumns: string[];
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
            title: 'Kanban',
            href: route('proyectos.activities.kanban.index', proyecto.id),
        },
        {
            title: 'Mover estado',
            href: route('proyectos.activities.kanban.edit', [
                proyecto.id,
                activity.id,
            ]),
        },
    ];

    const form = useForm<KanbanForm>({
        kanban_column: activity.kanban_column,
        orden: '',
    });

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        form.patch(
            route('proyectos.activities.kanban', [proyecto.id, activity.id]),
            { preserveScroll: true },
        );
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Mover estado - ${activity.titulo}`} />

            <div className="space-y-4 p-4">
                <ModuleHeader
                    title="Mover estado"
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
                                <Field>
                                    <Label>Columna</Label>
                                    <Select
                                        value={form.data.kanban_column}
                                        onValueChange={(value) =>
                                            form.setData('kanban_column', value)
                                        }
                                    >
                                        <SelectTrigger>
                                            <SelectValue />
                                        </SelectTrigger>
                                        <SelectContent>
                                            {kanbanColumns.map((column) => (
                                                <SelectItem
                                                    key={column}
                                                    value={column}
                                                >
                                                    {label(column)}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                    {form.errors.kanban_column && (
                                        <FieldError>
                                            {form.errors.kanban_column}
                                        </FieldError>
                                    )}
                                </Field>
                                <FormInputField
                                    id="kanban-order"
                                    label="Orden"
                                    type="number"
                                    value={form.data.orden}
                                    error={form.errors.orden}
                                    onChange={(event) =>
                                        form.setData(
                                            'orden',
                                            event.target.value,
                                        )
                                    }
                                />
                                <LoadingSubmitButton
                                    label="Mover actividad"
                                    processing={form.processing}
                                />
                            </form>
                        </CardContent>
                    </Card>

                    <Card className="rounded-lg">
                        <CardContent className="space-y-4 pt-6 text-sm">
                            <div className="flex items-center gap-2">
                                <KanbanSquare className="size-4 text-primary" />
                                <span className="font-medium">
                                    Estado actual
                                </span>
                            </div>
                            <Detail label="Proyecto" value={proyecto.nombre} />
                            <Detail
                                label="Columna"
                                value={label(activity.kanban_column)}
                            />
                            <Detail
                                label="Estado"
                                value={label(activity.estado)}
                            />
                            <Detail
                                label="Responsable"
                                value={activity.responsable?.name ?? '-'}
                            />
                            <Badge variant="outline">
                                {activity.prioridad}
                            </Badge>
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
