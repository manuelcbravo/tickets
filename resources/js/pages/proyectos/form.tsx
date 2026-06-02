import { Link, useForm } from '@inertiajs/react';
import type React from 'react';
import { route } from 'ziggy-js';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { LoadingSubmitButton } from '@/components/loading-submit-button';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Field, FieldError } from '@/components/ui/field';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';

export type ClienteOption = {
    id: string;
    nombre: string | null;
    razon_social: string | null;
    estatus: string | null;
};

export type UserOption = {
    id: number;
    name: string;
};

export type ProyectoFormValues = {
    client_id: string;
    nombre: string;
    descripcion: string;
    url_produccion: string;
    url_staging: string;
    repositorio_url: string;
    documentacion_url: string;
    tecnologia: string;
    responsable_tecnico_id: string;
    estado: string;
    criticidad: string;
    notas_internas: string;
};

type ProyectoFormProps = {
    initialValues?: Partial<ProyectoFormValues>;
    clientes: ClienteOption[];
    users: UserOption[];
    estadoOptions: string[];
    criticidadOptions: string[];
    submitLabel: string;
    submitUrl: string;
    method?: 'post' | 'put';
};

export function ProyectoForm({
    initialValues,
    clientes,
    users,
    estadoOptions,
    criticidadOptions,
    submitLabel,
    submitUrl,
    method = 'post',
}: ProyectoFormProps) {
    const form = useForm<ProyectoFormValues>({
        client_id: clientes[0]?.id ?? '',
        nombre: '',
        descripcion: '',
        url_produccion: '',
        url_staging: '',
        repositorio_url: '',
        documentacion_url: '',
        tecnologia: '',
        responsable_tecnico_id: 'sin_responsable',
        estado: 'mantenimiento',
        criticidad: 'media',
        notas_internas: '',
        ...initialValues,
    });

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        form.transform((data) => ({
            ...data,
            responsable_tecnico_id:
                data.responsable_tecnico_id === 'sin_responsable'
                    ? null
                    : data.responsable_tecnico_id,
        }));

        if (method === 'put') {
            form.put(submitUrl);
            return;
        }

        form.post(submitUrl);
    };

    return (
        <form className="space-y-6" onSubmit={submit}>
            <div className="grid gap-4 md:grid-cols-2">
                <Field>
                    <Label>Cliente</Label>
                    <Select value={form.data.client_id} onValueChange={(value) => form.setData('client_id', value)}>
                        <SelectTrigger className="w-full">
                            <SelectValue placeholder="Selecciona cliente" />
                        </SelectTrigger>
                        <SelectContent>
                            {clientes.map((cliente) => (
                                <SelectItem key={cliente.id} value={cliente.id}>
                                    <span className="inline-flex items-center gap-2">
                                        {cliente.nombre ?? cliente.razon_social ?? cliente.id}
                                        {(cliente.estatus === 'suspendido' || cliente.estatus === 'moroso') && (
                                            <Badge variant="destructive">{cliente.estatus}</Badge>
                                        )}
                                    </span>
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    {form.errors.client_id && <FieldError>{form.errors.client_id}</FieldError>}
                </Field>
                <FormInputField
                    id="proyecto-nombre"
                    label="Nombre"
                    value={form.data.nombre}
                    error={form.errors.nombre}
                    onChange={(event) => form.setData('nombre', event.target.value)}
                />
                <div className="md:col-span-2">
                    <FormTextareaField
                        id="proyecto-descripcion"
                        label="Descripcion"
                        value={form.data.descripcion}
                        error={form.errors.descripcion}
                        onChange={(event) => form.setData('descripcion', event.target.value)}
                    />
                </div>
                <FormInputField id="url-produccion" label="URL produccion" value={form.data.url_produccion} error={form.errors.url_produccion} onChange={(event) => form.setData('url_produccion', event.target.value)} />
                <FormInputField id="url-staging" label="URL staging" value={form.data.url_staging} error={form.errors.url_staging} onChange={(event) => form.setData('url_staging', event.target.value)} />
                <FormInputField id="repositorio-url" label="Repositorio URL" value={form.data.repositorio_url} error={form.errors.repositorio_url} onChange={(event) => form.setData('repositorio_url', event.target.value)} />
                <FormInputField id="documentacion-url" label="Documentacion URL" value={form.data.documentacion_url} error={form.errors.documentacion_url} onChange={(event) => form.setData('documentacion_url', event.target.value)} />
                <FormInputField id="tecnologia" label="Tecnologia" value={form.data.tecnologia} error={form.errors.tecnologia} onChange={(event) => form.setData('tecnologia', event.target.value)} />
                <Field>
                    <Label>Responsable tecnico</Label>
                    <Select value={form.data.responsable_tecnico_id} onValueChange={(value) => form.setData('responsable_tecnico_id', value)}>
                        <SelectTrigger className="w-full">
                            <SelectValue placeholder="Sin responsable" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="sin_responsable">Sin responsable</SelectItem>
                            {users.map((user) => (
                                <SelectItem key={user.id} value={String(user.id)}>
                                    {user.name}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    {form.errors.responsable_tecnico_id && <FieldError>{form.errors.responsable_tecnico_id}</FieldError>}
                </Field>
                <Field>
                    <Label>Estado</Label>
                    <Select value={form.data.estado} onValueChange={(value) => form.setData('estado', value)}>
                        <SelectTrigger className="w-full">
                            <SelectValue placeholder="Estado" />
                        </SelectTrigger>
                        <SelectContent>
                            {estadoOptions.map((option) => (
                                <SelectItem key={option} value={option}>
                                    {option}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    {form.errors.estado && <FieldError>{form.errors.estado}</FieldError>}
                </Field>
                <Field>
                    <Label>Criticidad</Label>
                    <Select value={form.data.criticidad} onValueChange={(value) => form.setData('criticidad', value)}>
                        <SelectTrigger className="w-full">
                            <SelectValue placeholder="Criticidad" />
                        </SelectTrigger>
                        <SelectContent>
                            {criticidadOptions.map((option) => (
                                <SelectItem key={option} value={option}>
                                    {option}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    {form.errors.criticidad && <FieldError>{form.errors.criticidad}</FieldError>}
                </Field>
                <div className="md:col-span-2">
                    <FormTextareaField
                        id="proyecto-notas"
                        label="Notas internas"
                        value={form.data.notas_internas}
                        error={form.errors.notas_internas}
                        onChange={(event) => form.setData('notas_internas', event.target.value)}
                    />
                </div>
            </div>

            <div className="flex justify-end gap-2">
                <Button asChild variant="outline">
                    <Link href={route('proyectos.index')}>Cancelar</Link>
                </Button>
                <LoadingSubmitButton label={submitLabel} processing={form.processing} />
            </div>
        </form>
    );
}
