import { Link, useForm } from '@inertiajs/react';
import type React from 'react';
import { useMemo } from 'react';
import { route } from 'ziggy-js';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { LoadingSubmitButton } from '@/components/loading-submit-button';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Field, FieldError } from '@/components/ui/field';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import type { ClientOption, ContactOption, ProjectOption } from '@/types';

export type QuoteModel = {
    id: string;
    cliente_id: string;
    proyecto_id: string | null;
    contacto_id: string | null;
    titulo: string;
    descripcion: string | null;
    alcance: string | null;
    exclusiones: string | null;
    entregables: string | null;
    condiciones: string | null;
    notas_internas: string | null;
    moneda: string;
    descuento: string | number;
    impuesto: string | number;
    horas_estimadas: number | null;
    dias_estimados: number | null;
    fecha_estimada_inicio: string | null;
    fecha_estimada_entrega: string | null;
    estado: string;
};

const none = 'none';

export function QuoteForm({
    quote,
    clientes,
    proyectos,
    contactos,
    estados,
}: {
    quote?: QuoteModel;
    clientes: ClientOption[];
    proyectos: ProjectOption[];
    contactos: ContactOption[];
    estados: string[];
}) {
    const form = useForm({
        cliente_id: quote?.cliente_id ?? '',
        proyecto_id: quote?.proyecto_id ?? none,
        contacto_id: quote?.contacto_id ?? none,
        titulo: quote?.titulo ?? '',
        descripcion: quote?.descripcion ?? '',
        alcance: quote?.alcance ?? '',
        exclusiones: quote?.exclusiones ?? '',
        entregables: quote?.entregables ?? '',
        condiciones: quote?.condiciones ?? '',
        notas_internas: quote?.notas_internas ?? '',
        moneda: quote?.moneda ?? 'MXN',
        descuento: String(quote?.descuento ?? 0),
        impuesto: String(quote?.impuesto ?? 0),
        horas_estimadas: quote?.horas_estimadas ? String(quote.horas_estimadas) : '',
        dias_estimados: quote?.dias_estimados ? String(quote.dias_estimados) : '',
        fecha_estimada_inicio: quote?.fecha_estimada_inicio ? quote.fecha_estimada_inicio.slice(0, 10) : '',
        fecha_estimada_entrega: quote?.fecha_estimada_entrega ? quote.fecha_estimada_entrega.slice(0, 10) : '',
        estado: quote?.estado ?? 'borrador',
    });

    const filteredProjects = useMemo(() => form.data.cliente_id ? proyectos.filter((project) => project.client_id === form.data.cliente_id) : proyectos, [form.data.cliente_id, proyectos]);
    const filteredContacts = useMemo(() => form.data.cliente_id ? contactos.filter((contact) => contact.client_id === form.data.cliente_id) : contactos, [form.data.cliente_id, contactos]);

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        form.transform((data) => ({
            ...data,
            proyecto_id: normalize(data.proyecto_id),
            contacto_id: normalize(data.contacto_id),
        }));

        if (quote) {
            form.patch(route('quotes.update', quote.id));
            return;
        }

        form.post(route('quotes.store'));
    };

    return (
        <form onSubmit={submit}>
            <Card className="rounded-lg">
                <CardHeader>
                    <CardTitle>{quote ? 'Editar cotizacion' : 'Nueva cotizacion'}</CardTitle>
                    <CardDescription>Define alcance, condiciones y datos comerciales. Las partidas se administran desde el detalle.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-4">
                    <div className="grid gap-4 md:grid-cols-2">
                        <SelectField label="Cliente" value={form.data.cliente_id} error={form.errors.cliente_id} onChange={(value) => form.setData((data) => ({ ...data, cliente_id: value, proyecto_id: none, contacto_id: none }))} options={clientes.map((client) => ({ value: client.id, label: client.nombre ?? client.razon_social ?? client.id }))} />
                        <SelectField label="Proyecto" value={form.data.proyecto_id} error={form.errors.proyecto_id} onChange={(value) => form.setData('proyecto_id', value)} options={[{ value: none, label: 'Sin proyecto' }, ...filteredProjects.map((project) => ({ value: project.id, label: project.nombre }))]} />
                        <SelectField label="Contacto" value={form.data.contacto_id} error={form.errors.contacto_id} onChange={(value) => form.setData('contacto_id', value)} options={[{ value: none, label: 'Sin contacto' }, ...filteredContacts.map((contact) => ({ value: contact.id, label: contact.nombre }))]} />
                        <SelectField label="Estado" value={form.data.estado} error={form.errors.estado} onChange={(value) => form.setData('estado', value)} options={estados.map((estado) => ({ value: estado, label: estado }))} />
                        <div className="md:col-span-2">
                            <FormInputField id="quote-title" label="Titulo" value={form.data.titulo} error={form.errors.titulo} onChange={(event) => form.setData('titulo', event.target.value)} />
                        </div>
                        <FormInputField id="quote-currency" label="Moneda" maxLength={3} value={form.data.moneda} error={form.errors.moneda} onChange={(event) => form.setData('moneda', event.target.value.toUpperCase())} />
                        <FormInputField id="quote-discount" label="Descuento" type="number" min="0" step="0.01" value={form.data.descuento} error={form.errors.descuento} onChange={(event) => form.setData('descuento', event.target.value)} />
                        <FormInputField id="quote-tax" label="Impuesto" type="number" min="0" step="0.01" value={form.data.impuesto} error={form.errors.impuesto} onChange={(event) => form.setData('impuesto', event.target.value)} />
                        <FormInputField id="quote-hours" label="Horas estimadas" type="number" min="0" value={form.data.horas_estimadas} error={form.errors.horas_estimadas} onChange={(event) => form.setData('horas_estimadas', event.target.value)} />
                        <FormInputField id="quote-days" label="Dias estimados" type="number" min="0" value={form.data.dias_estimados} error={form.errors.dias_estimados} onChange={(event) => form.setData('dias_estimados', event.target.value)} />
                        <FormInputField id="quote-start" label="Inicio estimado" type="date" value={form.data.fecha_estimada_inicio} error={form.errors.fecha_estimada_inicio} onChange={(event) => form.setData('fecha_estimada_inicio', event.target.value)} />
                        <FormInputField id="quote-delivery" label="Entrega estimada" type="date" value={form.data.fecha_estimada_entrega} error={form.errors.fecha_estimada_entrega} onChange={(event) => form.setData('fecha_estimada_entrega', event.target.value)} />
                        <div className="md:col-span-2"><FormTextareaField id="quote-description" label="Descripcion" value={form.data.descripcion} error={form.errors.descripcion} onChange={(event) => form.setData('descripcion', event.target.value)} /></div>
                        <FormTextareaField id="quote-scope" label="Alcance" value={form.data.alcance} error={form.errors.alcance} onChange={(event) => form.setData('alcance', event.target.value)} />
                        <FormTextareaField id="quote-exclusions" label="Exclusiones" value={form.data.exclusiones} error={form.errors.exclusiones} onChange={(event) => form.setData('exclusiones', event.target.value)} />
                        <FormTextareaField id="quote-deliverables" label="Entregables" value={form.data.entregables} error={form.errors.entregables} onChange={(event) => form.setData('entregables', event.target.value)} />
                        <FormTextareaField id="quote-conditions" label="Condiciones" value={form.data.condiciones} error={form.errors.condiciones} onChange={(event) => form.setData('condiciones', event.target.value)} />
                        <div className="md:col-span-2"><FormTextareaField id="quote-internal-notes" label="Notas internas" value={form.data.notas_internas} error={form.errors.notas_internas} onChange={(event) => form.setData('notas_internas', event.target.value)} /></div>
                    </div>
                    <div className="flex justify-end gap-2">
                        <Button asChild variant="outline"><Link href={quote ? route('quotes.show', quote.id) : route('quotes.index')}>Cancelar</Link></Button>
                        <LoadingSubmitButton processing={form.processing} label={quote ? 'Guardar cotizacion' : 'Crear cotizacion'} />
                    </div>
                </CardContent>
            </Card>
        </form>
    );
}

function SelectField({ label, value, options, error, onChange }: { label: string; value: string; options: { value: string; label: string }[]; error?: string; onChange: (value: string) => void }) {
    return (
        <Field>
            <Label>{label}</Label>
            <Select value={value} onValueChange={onChange}>
                <SelectTrigger className="w-full"><SelectValue placeholder={label} /></SelectTrigger>
                <SelectContent>{options.map((option) => <SelectItem key={option.value} value={option.value}>{option.label}</SelectItem>)}</SelectContent>
            </Select>
            {error && <FieldError>{error}</FieldError>}
        </Field>
    );
}

const normalize = (value: string) => value === none || value === '' ? null : value;
