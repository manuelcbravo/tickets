import { Link, useForm } from '@inertiajs/react';
import type React from 'react';
import { useMemo } from 'react';
import { route } from 'ziggy-js';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { LoadingSubmitButton } from '@/components/loading-submit-button';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Field, FieldError } from '@/components/ui/field';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import type { TicketFormValues, TicketOptionProps } from '@/types/tickets';

type TicketFormProps = TicketOptionProps & {
    initialValues?: Partial<TicketFormValues>;
    submitUrl: string;
    submitLabel: string;
    method?: 'post' | 'put';
};

const none = 'none';

const defaults: TicketFormValues = {
    cliente_id: '',
    proyecto_id: none,
    proyecto_modulo_id: none,
    contacto_id: none,
    ambiente_id: none,
    titulo: '',
    descripcion: '',
    tipo_id: '',
    estado_id: none,
    prioridad_id: '',
    impacto_id: none,
    urgencia_id: none,
    riesgo_id: none,
    dificultad: '',
    responsable_id: none,
    fecha_objetivo: '',
    tiempo_estimado_min: '',
    requires_code_change: false,
    requires_quote: false,
    is_internal: false,
};

export function TicketForm({
    initialValues,
    submitUrl,
    submitLabel,
    method = 'post',
    clientes,
    proyectos,
    modulos,
    contactos,
    ambientes,
    users,
    tipos,
    estados,
    prioridades,
    impactos,
    urgencias,
    riesgos,
}: TicketFormProps) {
    const form = useForm<TicketFormValues>({
        ...defaults,
        cliente_id: clientes[0]?.id ?? '',
        tipo_id: tipos[0] ? String(tipos[0].id) : '',
        prioridad_id: prioridades[0] ? String(prioridades[0].id) : '',
        ...initialValues,
    });

    const filteredProjects = useMemo(
        () => proyectos.filter((project) => project.client_id === form.data.cliente_id),
        [form.data.cliente_id, proyectos],
    );
    const filteredContacts = useMemo(
        () => contactos.filter((contact) => contact.client_id === form.data.cliente_id),
        [contactos, form.data.cliente_id],
    );
    const filteredModules = useMemo(
        () => modulos.filter((module) => module.project_id === form.data.proyecto_id),
        [form.data.proyecto_id, modulos],
    );
    const filteredEnvironments = useMemo(
        () => ambientes.filter((environment) => environment.project_id === form.data.proyecto_id),
        [ambientes, form.data.proyecto_id],
    );

    const normalize = (value: string) => (value === none || value === '' ? null : value);

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        form.transform((data) => ({
            ...data,
            proyecto_id: normalize(data.proyecto_id),
            proyecto_modulo_id: normalize(data.proyecto_modulo_id),
            contacto_id: normalize(data.contacto_id),
            ambiente_id: normalize(data.ambiente_id),
            estado_id: normalize(data.estado_id),
            impacto_id: normalize(data.impacto_id),
            urgencia_id: normalize(data.urgencia_id),
            riesgo_id: normalize(data.riesgo_id),
            responsable_id: normalize(data.responsable_id),
            tiempo_estimado_min: data.tiempo_estimado_min === '' ? null : data.tiempo_estimado_min,
            fecha_objetivo: data.fecha_objetivo === '' ? null : data.fecha_objetivo,
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
                <SelectField label="Cliente" value={form.data.cliente_id} error={form.errors.cliente_id} onChange={(value) => {
                    form.setData((data) => ({ ...data, cliente_id: value, proyecto_id: none, proyecto_modulo_id: none, contacto_id: none, ambiente_id: none }));
                }} options={clientes.map((cliente) => ({ value: cliente.id, label: cliente.nombre ?? cliente.razon_social ?? cliente.id }))} />
                <SelectField label="Proyecto" value={form.data.proyecto_id} error={form.errors.proyecto_id} onChange={(value) => {
                    form.setData((data) => ({ ...data, proyecto_id: value, proyecto_modulo_id: none, ambiente_id: none }));
                }} options={[{ value: none, label: 'Sin proyecto' }, ...filteredProjects.map((project) => ({ value: project.id, label: project.nombre }))]} />
                <SelectField label="Modulo" value={form.data.proyecto_modulo_id} error={form.errors.proyecto_modulo_id} onChange={(value) => form.setData('proyecto_modulo_id', value)} options={[{ value: none, label: 'Sin modulo' }, ...filteredModules.map((module) => ({ value: module.id, label: module.nombre }))]} />
                <SelectField label="Contacto" value={form.data.contacto_id} error={form.errors.contacto_id} onChange={(value) => form.setData('contacto_id', value)} options={[{ value: none, label: 'Sin contacto' }, ...filteredContacts.map((contact) => ({ value: contact.id, label: contact.nombre }))]} />
                <SelectField label="Ambiente" value={form.data.ambiente_id} error={form.errors.ambiente_id} onChange={(value) => form.setData('ambiente_id', value)} options={[{ value: none, label: 'Sin ambiente' }, ...filteredEnvironments.map((environment) => ({ value: environment.id, label: environment.nombre }))]} />
                <SelectField label="Responsable" value={form.data.responsable_id} error={form.errors.responsable_id} onChange={(value) => form.setData('responsable_id', value)} options={[{ value: none, label: 'Sin responsable' }, ...users.map((user) => ({ value: String(user.id), label: user.name }))]} />
                <div className="md:col-span-2">
                    <FormInputField id="ticket-title" label="Titulo" value={form.data.titulo} error={form.errors.titulo} onChange={(event) => form.setData('titulo', event.target.value)} />
                </div>
                <div className="md:col-span-2">
                    <FormTextareaField id="ticket-description" label="Descripcion" value={form.data.descripcion} error={form.errors.descripcion} onChange={(event) => form.setData('descripcion', event.target.value)} />
                </div>
                <SelectField label="Tipo" value={form.data.tipo_id} error={form.errors.tipo_id} onChange={(value) => form.setData('tipo_id', value)} options={tipos.map((option) => ({ value: String(option.id), label: option.nombre }))} />
                <SelectField label="Estado" value={form.data.estado_id} error={form.errors.estado_id} onChange={(value) => form.setData('estado_id', value)} options={[{ value: none, label: 'Automatico' }, ...estados.map((option) => ({ value: String(option.id), label: option.nombre }))]} />
                <SelectField label="Prioridad" value={form.data.prioridad_id} error={form.errors.prioridad_id} onChange={(value) => form.setData('prioridad_id', value)} options={prioridades.map((option) => ({ value: String(option.id), label: option.nombre }))} />
                <SelectField label="Impacto" value={form.data.impacto_id} error={form.errors.impacto_id} onChange={(value) => form.setData('impacto_id', value)} options={[{ value: none, label: 'Sin impacto' }, ...impactos.map((option) => ({ value: String(option.id), label: option.nombre }))]} />
                <SelectField label="Urgencia" value={form.data.urgencia_id} error={form.errors.urgencia_id} onChange={(value) => form.setData('urgencia_id', value)} options={[{ value: none, label: 'Sin urgencia' }, ...urgencias.map((option) => ({ value: String(option.id), label: option.nombre }))]} />
                <SelectField label="Riesgo" value={form.data.riesgo_id} error={form.errors.riesgo_id} onChange={(value) => form.setData('riesgo_id', value)} options={[{ value: none, label: 'Sin riesgo' }, ...riesgos.map((option) => ({ value: String(option.id), label: option.nombre }))]} />
                <FormInputField id="ticket-difficulty" label="Dificultad" value={form.data.dificultad} error={form.errors.dificultad} onChange={(event) => form.setData('dificultad', event.target.value)} />
                <FormInputField id="ticket-target-date" label="Fecha objetivo" type="datetime-local" value={form.data.fecha_objetivo} error={form.errors.fecha_objetivo} onChange={(event) => form.setData('fecha_objetivo', event.target.value)} />
                <FormInputField id="ticket-estimated-time" label="Tiempo estimado (min)" type="number" value={form.data.tiempo_estimado_min} error={form.errors.tiempo_estimado_min} onChange={(event) => form.setData('tiempo_estimado_min', event.target.value)} />
                <div className="grid gap-3 rounded-md border p-3 md:col-span-2 md:grid-cols-3">
                    <CheckField label="Requiere cambio de codigo" checked={form.data.requires_code_change} onChange={(checked) => form.setData('requires_code_change', checked)} />
                    <CheckField label="Requiere cotizacion" checked={form.data.requires_quote} onChange={(checked) => form.setData('requires_quote', checked)} />
                    <CheckField label="Interno" checked={form.data.is_internal} onChange={(checked) => form.setData('is_internal', checked)} />
                </div>
            </div>
            <div className="flex justify-end gap-2">
                <Button asChild variant="outline">
                    <Link href={route('tickets.index')}>Cancelar</Link>
                </Button>
                <LoadingSubmitButton label={submitLabel} processing={form.processing} />
            </div>
        </form>
    );
}

function SelectField({ label, value, options, error, onChange }: { label: string; value: string; options: { value: string; label: string }[]; error?: string; onChange: (value: string) => void }) {
    return (
        <Field>
            <Label>{label}</Label>
            <Select value={value} onValueChange={onChange}>
                <SelectTrigger className="w-full">
                    <SelectValue placeholder={label} />
                </SelectTrigger>
                <SelectContent>
                    {options.map((option) => (
                        <SelectItem key={option.value} value={option.value}>
                            {option.label}
                        </SelectItem>
                    ))}
                </SelectContent>
            </Select>
            {error && <FieldError>{error}</FieldError>}
        </Field>
    );
}

function CheckField({ label, checked, onChange }: { label: string; checked: boolean; onChange: (checked: boolean) => void }) {
    return (
        <label className="flex items-center gap-2 text-sm">
            <Checkbox checked={checked} onCheckedChange={(value) => onChange(Boolean(value))} />
            {label}
        </label>
    );
}
