import { Link, useForm } from '@inertiajs/react';
import type React from 'react';
import { route } from 'ziggy-js';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { LoadingSubmitButton } from '@/components/loading-submit-button';
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

export type ClienteFormValues = {
    nombre: string;
    razon_social: string;
    rfc: string;
    email: string;
    telefono: string;
    sitio_web: string;
    estatus: string;
    clasificacion: string;
    notas_internas: string;
};

type ClienteFormProps = {
    initialValues?: Partial<ClienteFormValues>;
    estatusOptions: string[];
    clasificacionOptions: string[];
    submitLabel: string;
    submitUrl: string;
    method?: 'post' | 'put';
};

const defaults: ClienteFormValues = {
    nombre: '',
    razon_social: '',
    rfc: '',
    email: '',
    telefono: '',
    sitio_web: '',
    estatus: 'activo',
    clasificacion: 'normal',
    notas_internas: '',
};

export function ClienteForm({
    initialValues,
    estatusOptions,
    clasificacionOptions,
    submitLabel,
    submitUrl,
    method = 'post',
}: ClienteFormProps) {
    const form = useForm<ClienteFormValues>({
        ...defaults,
        ...initialValues,
    });

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        if (method === 'put') {
            form.put(submitUrl);
            return;
        }

        form.post(submitUrl);
    };

    return (
        <form className="space-y-6" onSubmit={submit}>
            <div className="grid gap-4 md:grid-cols-2">
                <FormInputField
                    id="cliente-nombre"
                    label="Nombre"
                    value={form.data.nombre}
                    error={form.errors.nombre}
                    onChange={(event) => form.setData('nombre', event.target.value)}
                />
                <FormInputField
                    id="cliente-razon-social"
                    label="Razon social"
                    value={form.data.razon_social}
                    error={form.errors.razon_social}
                    onChange={(event) => form.setData('razon_social', event.target.value)}
                />
                <FormInputField
                    id="cliente-rfc"
                    label="RFC"
                    value={form.data.rfc}
                    error={form.errors.rfc}
                    onChange={(event) => form.setData('rfc', event.target.value)}
                />
                <FormInputField
                    id="cliente-email"
                    label="Email"
                    type="email"
                    value={form.data.email}
                    error={form.errors.email}
                    onChange={(event) => form.setData('email', event.target.value)}
                />
                <FormInputField
                    id="cliente-telefono"
                    label="Telefono"
                    value={form.data.telefono}
                    error={form.errors.telefono}
                    onChange={(event) => form.setData('telefono', event.target.value)}
                />
                <FormInputField
                    id="cliente-sitio-web"
                    label="Sitio web"
                    value={form.data.sitio_web}
                    error={form.errors.sitio_web}
                    onChange={(event) => form.setData('sitio_web', event.target.value)}
                />
                <Field>
                    <Label>Estatus</Label>
                    <Select value={form.data.estatus} onValueChange={(value) => form.setData('estatus', value)}>
                        <SelectTrigger className="w-full">
                            <SelectValue placeholder="Selecciona estatus" />
                        </SelectTrigger>
                        <SelectContent>
                            {estatusOptions.map((option) => (
                                <SelectItem key={option} value={option}>
                                    {option}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    {form.errors.estatus && <FieldError>{form.errors.estatus}</FieldError>}
                </Field>
                <Field>
                    <Label>Clasificacion</Label>
                    <Select value={form.data.clasificacion} onValueChange={(value) => form.setData('clasificacion', value)}>
                        <SelectTrigger className="w-full">
                            <SelectValue placeholder="Selecciona clasificacion" />
                        </SelectTrigger>
                        <SelectContent>
                            {clasificacionOptions.map((option) => (
                                <SelectItem key={option} value={option}>
                                    {option}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    {form.errors.clasificacion && <FieldError>{form.errors.clasificacion}</FieldError>}
                </Field>
                <div className="md:col-span-2">
                    <FormTextareaField
                        id="cliente-notas"
                        label="Notas internas"
                        value={form.data.notas_internas}
                        error={form.errors.notas_internas}
                        onChange={(event) => form.setData('notas_internas', event.target.value)}
                    />
                </div>
            </div>

            <div className="flex justify-end gap-2">
                <Button asChild variant="outline">
                    <Link href={route('clientes.index')}>Cancelar</Link>
                </Button>
                <LoadingSubmitButton label={submitLabel} processing={form.processing} />
            </div>
        </form>
    );
}
