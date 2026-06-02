import { Head, useForm } from '@inertiajs/react';
import type React from 'react';
import { route } from 'ziggy-js';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { LoadingSubmitButton } from '@/components/loading-submit-button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, CatalogOption } from '@/types';

type SlaPolicyPriority = {
    id: string;
    prioridad_id: number;
    tiempo_primera_respuesta_min: number;
    tiempo_resolucion_min: number;
    tiempo_alerta_min: number | null;
};

type SlaPolicy = {
    id: string;
    nombre: string;
    descripcion: string | null;
    activo: boolean;
    es_default: boolean;
    prioridades: SlaPolicyPriority[];
} | null;

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Tickets', href: route('tickets.dashboard') },
    { title: 'SLA', href: route('tickets.sla.index') },
    { title: 'Configuracion', href: route('tickets.sla.settings') },
];

export default function TicketsSlaSettings({ policy, prioridades }: { policy: SlaPolicy; prioridades: CatalogOption[] }) {
    const form = useForm({
        nombre: policy?.nombre ?? '',
        descripcion: policy?.descripcion ?? '',
        activo: policy?.activo ?? true,
        es_default: policy?.es_default ?? true,
        prioridades: prioridades.map((prioridad) => {
            const current = policy?.prioridades.find((item) => item.prioridad_id === prioridad.id);
            return {
                prioridad_id: prioridad.id,
                nombre: prioridad.nombre,
                tiempo_primera_respuesta_min: String(current?.tiempo_primera_respuesta_min ?? ''),
                tiempo_resolucion_min: String(current?.tiempo_resolucion_min ?? ''),
                tiempo_alerta_min: current?.tiempo_alerta_min ? String(current.tiempo_alerta_min) : '',
            };
        }),
    });

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        if (!policy) return;

        form.patch(route('tickets.sla.policies.update', policy.id), { preserveScroll: true });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Tickets - Configuracion SLA" />
            <form className="space-y-4 rounded-xl p-4" onSubmit={submit}>
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
                    <h1 className="text-xl font-semibold">Configuracion SLA</h1>
                    <p className="text-sm text-muted-foreground">Politica default y tiempos por prioridad.</p>
                </div>

                {!policy ? (
                    <Card className="rounded-lg">
                        <CardHeader><CardTitle>Sin politica SLA</CardTitle><CardDescription>Ejecuta el seeder especifico de SLA para crear la politica default.</CardDescription></CardHeader>
                    </Card>
                ) : (
                    <>
                        <Card className="rounded-lg">
                            <CardHeader><CardTitle>Politica</CardTitle></CardHeader>
                            <CardContent className="space-y-4">
                                <FormInputField id="sla-name" label="Nombre" value={form.data.nombre} error={form.errors.nombre} onChange={(event) => form.setData('nombre', event.target.value)} />
                                <FormTextareaField id="sla-description" label="Descripcion" value={form.data.descripcion} error={form.errors.descripcion} onChange={(event) => form.setData('descripcion', event.target.value)} />
                                <div className="flex flex-wrap gap-4">
                                    <Label className="flex items-center gap-2"><Checkbox checked={form.data.activo} onCheckedChange={(value) => form.setData('activo', Boolean(value))} /> Activa</Label>
                                    <Label className="flex items-center gap-2"><Checkbox checked={form.data.es_default} onCheckedChange={(value) => form.setData('es_default', Boolean(value))} /> Default</Label>
                                </div>
                            </CardContent>
                        </Card>

                        <Card className="rounded-lg">
                            <CardHeader><CardTitle>Tiempos por prioridad</CardTitle></CardHeader>
                            <CardContent className="space-y-4">
                                {form.data.prioridades.map((priority, index) => (
                                    <div key={priority.prioridad_id} className="grid gap-3 rounded-md border p-3 md:grid-cols-4">
                                        <div>
                                            <p className="text-sm font-medium">{priority.nombre}</p>
                                            <p className="text-xs text-muted-foreground">Minutos</p>
                                        </div>
                                        <FormInputField id={`first-${priority.prioridad_id}`} label="Primera respuesta" type="number" min="1" value={priority.tiempo_primera_respuesta_min} error={form.errors[`prioridades.${index}.tiempo_primera_respuesta_min`]} onChange={(event) => updatePriority(index, 'tiempo_primera_respuesta_min', event.target.value)} />
                                        <FormInputField id={`resolution-${priority.prioridad_id}`} label="Resolucion" type="number" min="1" value={priority.tiempo_resolucion_min} error={form.errors[`prioridades.${index}.tiempo_resolucion_min`]} onChange={(event) => updatePriority(index, 'tiempo_resolucion_min', event.target.value)} />
                                        <FormInputField id={`alert-${priority.prioridad_id}`} label="Alerta" type="number" min="1" value={priority.tiempo_alerta_min} error={form.errors[`prioridades.${index}.tiempo_alerta_min`]} onChange={(event) => updatePriority(index, 'tiempo_alerta_min', event.target.value)} />
                                    </div>
                                ))}
                            </CardContent>
                        </Card>

                        <LoadingSubmitButton label="Guardar politica SLA" processing={form.processing} />
                    </>
                )}
            </form>
        </AppLayout>
    );

    function updatePriority(index: number, field: 'tiempo_primera_respuesta_min' | 'tiempo_resolucion_min' | 'tiempo_alerta_min', value: string) {
        const next = [...form.data.prioridades];
        next[index] = { ...next[index], [field]: value };
        form.setData('prioridades', next);
    }
}
