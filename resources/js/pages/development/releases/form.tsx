import { Link, useForm } from '@inertiajs/react';
import type React from 'react';
import { route } from 'ziggy-js';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { LoadingSubmitButton } from '@/components/loading-submit-button';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Field, FieldError } from '@/components/ui/field';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

type ProjectOption = { id: string; nombre: string };
type EnvironmentOption = { id: string; project_id: string; nombre: string };
type ReleaseFormModel = {
    id?: string;
    proyecto_id: string;
    ambiente_id: string | null;
    nombre: string;
    version: string | null;
    descripcion: string | null;
    estado: string;
    release_notes: string | null;
    scheduled_at: string | null;
};

export function ReleaseForm({
    release,
    projects,
    environments,
    statusOptions,
}: {
    release?: ReleaseFormModel;
    projects: ProjectOption[];
    environments: EnvironmentOption[];
    statusOptions: string[];
}) {
    const form = useForm({
        proyecto_id: release?.proyecto_id ?? '',
        ambiente_id: release?.ambiente_id ?? '',
        nombre: release?.nombre ?? '',
        version: release?.version ?? '',
        descripcion: release?.descripcion ?? '',
        estado: release?.estado ?? 'borrador',
        release_notes: release?.release_notes ?? '',
        scheduled_at: release?.scheduled_at ? release.scheduled_at.slice(0, 16) : '',
    });

    const filteredEnvironments = environments.filter((environment) => !form.data.proyecto_id || environment.project_id === form.data.proyecto_id);

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        if (release?.id) {
            form.patch(route('development.releases.update', release.id));
            return;
        }

        form.post(route('development.releases.store'));
    };

    return (
        <form onSubmit={submit}>
            <Card className="rounded-lg">
                <CardHeader>
                    <CardTitle>{release ? 'Editar release' : 'Nuevo release'}</CardTitle>
                    <CardDescription>Solo registra trazabilidad de liberacion; no ejecuta deploys.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-4">
                    <div className="grid gap-4 md:grid-cols-2">
                        <Field>
                            <Label>Proyecto</Label>
                            <Select value={form.data.proyecto_id} onValueChange={(value) => form.setData('proyecto_id', value)}>
                                <SelectTrigger className="w-full"><SelectValue placeholder="Selecciona proyecto" /></SelectTrigger>
                                <SelectContent>{projects.map((project) => <SelectItem key={project.id} value={project.id}>{project.nombre}</SelectItem>)}</SelectContent>
                            </Select>
                            {form.errors.proyecto_id && <FieldError>{form.errors.proyecto_id}</FieldError>}
                        </Field>
                        <Field>
                            <Label>Ambiente</Label>
                            <Select value={form.data.ambiente_id || 'none'} onValueChange={(value) => form.setData('ambiente_id', value === 'none' ? '' : value)}>
                                <SelectTrigger className="w-full"><SelectValue placeholder="Sin ambiente" /></SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="none">Sin ambiente</SelectItem>
                                    {filteredEnvironments.map((environment) => <SelectItem key={environment.id} value={environment.id}>{environment.nombre}</SelectItem>)}
                                </SelectContent>
                            </Select>
                            {form.errors.ambiente_id && <FieldError>{form.errors.ambiente_id}</FieldError>}
                        </Field>
                        <FormInputField id="release-name" label="Nombre" value={form.data.nombre} error={form.errors.nombre} onChange={(event) => form.setData('nombre', event.target.value)} />
                        <FormInputField id="release-version" label="Version" value={form.data.version} error={form.errors.version} onChange={(event) => form.setData('version', event.target.value)} />
                        <Field>
                            <Label>Estado</Label>
                            <Select value={form.data.estado} onValueChange={(value) => form.setData('estado', value)}>
                                <SelectTrigger className="w-full"><SelectValue /></SelectTrigger>
                                <SelectContent>{statusOptions.map((status) => <SelectItem key={status} value={status}>{status}</SelectItem>)}</SelectContent>
                            </Select>
                            {form.errors.estado && <FieldError>{form.errors.estado}</FieldError>}
                        </Field>
                        <FormInputField id="release-scheduled" label="Fecha programada" type="datetime-local" value={form.data.scheduled_at} error={form.errors.scheduled_at} onChange={(event) => form.setData('scheduled_at', event.target.value)} />
                    </div>
                    <FormTextareaField id="release-description" label="Descripcion" value={form.data.descripcion} error={form.errors.descripcion} onChange={(event) => form.setData('descripcion', event.target.value)} />
                    <FormTextareaField id="release-notes" label="Release notes" value={form.data.release_notes} error={form.errors.release_notes} onChange={(event) => form.setData('release_notes', event.target.value)} />
                    <div className="flex justify-end gap-2">
                        <Button asChild variant="outline"><Link href={route('development.releases.index')}>Cancelar</Link></Button>
                        <LoadingSubmitButton processing={form.processing} label={release ? 'Guardar cambios' : 'Crear release'} />
                    </div>
                </CardContent>
            </Card>
        </form>
    );
}
