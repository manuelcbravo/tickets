import { Head, Link, router, useForm } from '@inertiajs/react';
import { AlertCircle, CheckCircle2, Link2, Plus, Save, Trash2 } from 'lucide-react';
import type React from 'react';
import { useMemo, useState } from 'react';
import { route } from 'ziggy-js';
import { CrudFormDialog } from '@/components/crud-form-dialog';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { LoadingSubmitButton } from '@/components/loading-submit-button';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Field, FieldError } from '@/components/ui/field';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, CatalogOption, PrioritySuggestion, TicketChecklistItem, TicketMissingInformationItem, TicketOptionProps, TicketRelation, UserOption } from '@/types';

type RelatedTicketOption = {
    id: string;
    folio: string;
    titulo: string;
};

type RelationType = {
    value: string;
    label: string;
};

type TicketTriage = {
    id: string;
    folio: string;
    titulo: string;
    descripcion: string;
    dificultad: string | null;
    priority_score: number | null;
    triage_notes: string | null;
    missing_information: TicketMissingInformationItem[] | null;
    created_at: string;
    requires_code_change: boolean;
    requires_quote: boolean;
    cliente?: { nombre: string | null; razon_social: string | null } | null;
    proyecto?: { nombre: string } | null;
    contacto?: { nombre: string; email: string | null } | null;
    responsable?: { id: number; name: string } | null;
    estado?: CatalogOption | null;
    tipo?: CatalogOption | null;
    prioridad?: CatalogOption | null;
    impacto?: CatalogOption | null;
    urgencia?: CatalogOption | null;
    riesgo?: CatalogOption | null;
    mensajes: { id: string; mensaje: string; created_at: string; usuario?: { name: string } | null }[];
    adjuntos: { id: string; nombre_original: string; size: number; usuario?: { name: string } | null }[];
    checklist_items: TicketChecklistItem[];
    relaciones_origen: TicketRelation[];
};

type TriageFormValues = {
    tipo_id: string;
    impacto_id: string;
    urgencia_id: string;
    riesgo_id: string;
    dificultad: string;
    prioridad_id: string;
    responsable_id: string;
    requires_code_change: boolean;
    requires_quote: boolean;
    triage_notes: string;
    next_status: string;
    missing_information: TicketMissingInformationItem[];
};

const none = 'none';

const breadcrumbsFor = (ticket: TicketTriage): BreadcrumbItem[] => [
    { title: 'Tickets', href: route('tickets.dashboard') },
    { title: 'Triage', href: route('tickets.triage.index') },
    { title: ticket.folio, href: route('tickets.triage.show', ticket.id) },
];

export default function TicketTriageShow({
    ticket,
    suggestion,
    missingInformationOptions,
    relationTypes,
    relatedTicketOptions,
    tipos,
    prioridades,
    impactos,
    urgencias,
    riesgos,
    users,
}: Pick<TicketOptionProps, 'tipos' | 'prioridades' | 'impactos' | 'urgencias' | 'riesgos' | 'users'> & {
    ticket: TicketTriage;
    suggestion: PrioritySuggestion;
    missingInformationOptions: { key: string; label: string }[];
    relationTypes: RelationType[];
    relatedTicketOptions: RelatedTicketOption[];
}) {
    const [checklistOpen, setChecklistOpen] = useState(false);
    const [relationOpen, setRelationOpen] = useState(false);
    const mergedMissingInformation = useMemo(
        () => mergeMissingInformation(missingInformationOptions, ticket.missing_information ?? []),
        [missingInformationOptions, ticket.missing_information],
    );

    const form = useForm<TriageFormValues>({
        tipo_id: ticket.tipo ? String(ticket.tipo.id) : '',
        impacto_id: ticket.impacto ? String(ticket.impacto.id) : '',
        urgencia_id: ticket.urgencia ? String(ticket.urgencia.id) : '',
        riesgo_id: ticket.riesgo ? String(ticket.riesgo.id) : '',
        dificultad: ticket.dificultad ?? 'Media',
        prioridad_id: ticket.prioridad ? String(ticket.prioridad.id) : (suggestion.prioridad_id ? String(suggestion.prioridad_id) : ''),
        responsable_id: ticket.responsable ? String(ticket.responsable.id) : none,
        requires_code_change: ticket.requires_code_change,
        requires_quote: ticket.requires_quote,
        triage_notes: ticket.triage_notes ?? '',
        next_status: 'priorizado',
        missing_information: mergedMissingInformation,
    });

    const calculated = calculateSuggestion(form.data, tipos, impactos, urgencias, riesgos, prioridades);
    const selectedTypeName = findName(tipos, form.data.tipo_id);
    const hasRequiredMissing = form.data.missing_information.some((item) => item.required && !item.completed);

    const checklistForm = useForm({ titulo: '', descripcion: '', tipo: 'informacion', requerido: true, orden: '' });
    const relationForm = useForm({ related_ticket_id: relatedTicketOptions[0]?.id ?? '', tipo: relationTypes[0]?.value ?? 'relacionado_con', descripcion: '' });

    const submitTriage = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        form.transform((data) => ({
            ...data,
            responsable_id: data.responsable_id === none ? null : data.responsable_id,
        }));
        form.patch(route('tickets.triage.complete', ticket.id));
    };

    return (
        <AppLayout breadcrumbs={breadcrumbsFor(ticket)}>
            <Head title={`Triage - ${ticket.folio}`} />
            <form className="space-y-4 rounded-xl p-4" onSubmit={submitTriage}>
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
                    <div className="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <div className="flex flex-wrap items-center gap-2">
                                <Badge variant="outline">{ticket.folio}</Badge>
                                <Badge>{ticket.estado?.nombre ?? '-'}</Badge>
                                <Badge variant={ticket.prioridad?.nombre?.startsWith('P0') ? 'destructive' : 'secondary'}>{ticket.prioridad?.nombre ?? '-'}</Badge>
                            </div>
                            <h1 className="mt-3 text-xl font-semibold">{ticket.titulo}</h1>
                            <p className="text-sm text-muted-foreground">
                                {ticket.cliente?.nombre ?? ticket.cliente?.razon_social ?? '-'} · {ticket.proyecto?.nombre ?? 'Sin proyecto'} · Creado {new Date(ticket.created_at).toLocaleString('es-MX')}
                            </p>
                        </div>
                        <div className="flex flex-wrap gap-2">
                            <Button type="button" variant="outline" asChild><Link href={route('tickets.show', ticket.id)}>Ver ticket</Link></Button>
                            <LoadingSubmitButton label="Guardar triage" processing={form.processing} />
                        </div>
                    </div>
                </div>

                <div className="grid gap-4 xl:grid-cols-3">
                    <Card className="rounded-lg xl:col-span-2">
                        <CardHeader>
                            <CardTitle>Descripcion y evidencia</CardTitle>
                            <CardDescription>Contexto original para clasificar sin perder trazabilidad.</CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            <p className="whitespace-pre-line text-sm">{ticket.descripcion}</p>
                            <div className="grid gap-3 md:grid-cols-2">
                                <Info label="Contacto" value={ticket.contacto?.nombre} />
                                <Info label="Responsable actual" value={ticket.responsable?.name} />
                            </div>
                            <div className="grid gap-3 md:grid-cols-2">
                                <MiniList title="Adjuntos" items={ticket.adjuntos.map((file) => `${file.nombre_original} (${(file.size / 1024).toFixed(0)} KB)`)} />
                                <MiniList title="Comentarios recientes" items={ticket.mensajes.slice(0, 3).map((message) => `${message.usuario?.name ?? 'Sistema'}: ${message.mensaje}`)} />
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="rounded-lg">
                        <CardHeader>
                            <CardTitle>Prioridad sugerida</CardTitle>
                            <CardDescription>Regla simple sin IA.</CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-3">
                            <div className="rounded-md border p-3">
                                <p className="text-sm font-medium">{calculated.priorityName ?? suggestion.prioridad_nombre ?? 'Sin sugerencia'}</p>
                                <p className="text-xs text-muted-foreground">{calculated.explanation}</p>
                            </div>
                            {calculated.effortWarning && <Warning>{calculated.effortWarning}</Warning>}
                            {selectedTypeName === 'Incidente critico' && <Warning>Incidente critico: no puede quedar como P3 o P4.</Warning>}
                            {form.data.requires_quote && <Warning>Requiere cotizacion: no debe avanzar directo a desarrollo sin aprobacion.</Warning>}
                            <Button type="button" variant="outline" onClick={() => calculated.priorityId && form.setData('prioridad_id', String(calculated.priorityId))}>
                                Usar sugerida
                            </Button>
                        </CardContent>
                    </Card>
                </div>

                <Card className="rounded-lg">
                    <CardHeader>
                        <CardTitle>Clasificacion</CardTitle>
                        <CardDescription>Define tipo, impacto, urgencia, riesgo, dificultad y prioridad final.</CardDescription>
                    </CardHeader>
                    <CardContent className="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        <SelectField label="Tipo" value={form.data.tipo_id} error={form.errors.tipo_id} onChange={(value) => applyTypeDefaults(value, tipos, form)} options={toCatalogOptions(tipos)} />
                        <SelectField label="Impacto" value={form.data.impacto_id} error={form.errors.impacto_id} onChange={(value) => form.setData('impacto_id', value)} options={toCatalogOptions(impactos)} />
                        <SelectField label="Urgencia" value={form.data.urgencia_id} error={form.errors.urgencia_id} onChange={(value) => form.setData('urgencia_id', value)} options={toCatalogOptions(urgencias)} />
                        <SelectField label="Riesgo" value={form.data.riesgo_id} error={form.errors.riesgo_id} onChange={(value) => form.setData('riesgo_id', value)} options={toCatalogOptions(riesgos)} />
                        <SelectField label="Dificultad" value={form.data.dificultad} error={form.errors.dificultad} onChange={(value) => form.setData('dificultad', value)} options={['Simple', 'Media', 'Compleja'].map((value) => ({ value, label: value }))} />
                        <SelectField label="Prioridad final" value={form.data.prioridad_id} error={form.errors.prioridad_id} onChange={(value) => form.setData('prioridad_id', value)} options={toCatalogOptions(prioridades)} />
                        <SelectField label="Responsable" value={form.data.responsable_id} error={form.errors.responsable_id} onChange={(value) => form.setData('responsable_id', value)} options={[{ value: none, label: 'Sin responsable' }, ...toUserOptions(users)]} />
                        <SelectField label="Accion final" value={form.data.next_status} error={form.errors.next_status} onChange={(value) => form.setData('next_status', value)} options={[
                            { value: 'falta_informacion', label: 'Marcar Falta informacion' },
                            { value: 'priorizado', label: 'Marcar Priorizado' },
                            { value: 'en_analisis', label: 'Enviar a analisis' },
                            { value: 'en_desarrollo', label: 'Enviar a desarrollo' },
                        ]} />
                        <div className="flex flex-col gap-3 rounded-md border p-3">
                            <CheckField label="Requiere cambio de codigo" checked={form.data.requires_code_change} onChange={(checked) => form.setData('requires_code_change', checked)} />
                            <CheckField label="Requiere cotizacion" checked={form.data.requires_quote} onChange={(checked) => form.setData('requires_quote', checked)} />
                        </div>
                        <div className="md:col-span-2 xl:col-span-3">
                            <FormTextareaField id="triage-notes" label="Notas de triage" value={form.data.triage_notes} error={form.errors.triage_notes} onChange={(event) => form.setData('triage_notes', event.target.value)} />
                        </div>
                    </CardContent>
                </Card>

                <div className="grid gap-4 xl:grid-cols-2">
                    <Card className="rounded-lg">
                        <CardHeader>
                            <CardTitle>Informacion faltante</CardTitle>
                            <CardDescription>Marca que datos son requeridos y cuales ya estan completos.</CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-2">
                            {hasRequiredMissing && <Warning>Hay informacion requerida faltante. La salida recomendada es Falta informacion.</Warning>}
                            {form.data.missing_information.map((item, index) => (
                                <div key={item.key} className="grid gap-2 rounded-md border p-3 sm:grid-cols-[1fr_auto_auto] sm:items-center">
                                    <span className="text-sm font-medium">{item.label}</span>
                                    <CheckField label="Requerido" checked={item.required} onChange={(checked) => updateMissing(form, index, { required: checked })} />
                                    <CheckField label="Completo" checked={item.completed} onChange={(checked) => updateMissing(form, index, { completed: checked })} />
                                </div>
                            ))}
                        </CardContent>
                    </Card>

                    <Card className="rounded-lg">
                        <CardHeader className="flex flex-row items-center justify-between space-y-0">
                            <div>
                                <CardTitle>Checklist del ticket</CardTitle>
                                <CardDescription>Items sugeridos por tipo y ajustes manuales.</CardDescription>
                            </div>
                            <Button type="button" onClick={() => setChecklistOpen(true)}><Plus className="size-4" /> Item</Button>
                        </CardHeader>
                        <CardContent className="space-y-2">
                            {ticket.checklist_items.length === 0 && <p className="text-sm text-muted-foreground">Aun no hay checklist.</p>}
                            {ticket.checklist_items.map((item) => (
                                <div key={item.id} className="flex items-start justify-between gap-3 rounded-md border p-3">
                                    <label className="flex gap-2 text-sm">
                                        <Checkbox checked={item.completado} onCheckedChange={(checked) => router.patch(route('tickets.checklist.update', [ticket.id, item.id]), { completado: Boolean(checked) }, { preserveScroll: true })} />
                                        <span>
                                            <span className="font-medium">{item.titulo}</span>
                                            <span className="block text-xs text-muted-foreground">{item.requerido ? 'Requerido' : 'Opcional'} · {item.tipo ?? 'sin tipo'}</span>
                                        </span>
                                    </label>
                                    <Button type="button" variant="ghost" size="icon-sm" onClick={() => router.delete(route('tickets.checklist.destroy', [ticket.id, item.id]), { preserveScroll: true })}><Trash2 className="size-4" /></Button>
                                </div>
                            ))}
                        </CardContent>
                    </Card>
                </div>

                <Card className="rounded-lg">
                    <CardHeader className="flex flex-row items-center justify-between space-y-0">
                        <div>
                            <CardTitle>Relaciones</CardTitle>
                            <CardDescription>Duplicados, bloqueos y tickets vinculados.</CardDescription>
                        </div>
                        <Button type="button" onClick={() => setRelationOpen(true)}><Link2 className="size-4" /> Relacionar</Button>
                    </CardHeader>
                    <CardContent className="space-y-2">
                        {ticket.relaciones_origen.length === 0 && <p className="text-sm text-muted-foreground">Sin relaciones.</p>}
                        {ticket.relaciones_origen.map((relation) => (
                            <div key={relation.id} className="flex items-center justify-between gap-3 rounded-md border p-3 text-sm">
                                <div>
                                    <Badge variant="outline">{relation.tipo}</Badge>
                                    <Link className="ml-2 font-medium text-primary hover:underline" href={route('tickets.show', relation.related_ticket?.id)}>
                                        {relation.related_ticket?.folio} · {relation.related_ticket?.titulo}
                                    </Link>
                                    {relation.descripcion && <p className="mt-1 text-xs text-muted-foreground">{relation.descripcion}</p>}
                                </div>
                                <Button type="button" variant="ghost" size="icon-sm" onClick={() => router.delete(route('tickets.relations.destroy', [ticket.id, relation.id]), { preserveScroll: true })}><Trash2 className="size-4" /></Button>
                            </div>
                        ))}
                    </CardContent>
                </Card>

                <div className="flex justify-end gap-2">
                    <Button type="button" variant="outline" asChild><Link href={route('tickets.triage.index')}>Cancelar</Link></Button>
                    <LoadingSubmitButton label="Guardar triage" processing={form.processing} />
                </div>
            </form>

            <CrudFormDialog open={checklistOpen} onOpenChange={setChecklistOpen} title="Agregar item" description="Agrega un item manual al checklist." processing={checklistForm.processing} onSubmit={(event) => {
                event.preventDefault();
                checklistForm.transform((data) => ({ ...data, orden: data.orden === '' ? null : data.orden }));
                checklistForm.post(route('tickets.checklist.store', ticket.id), { preserveScroll: true, onSuccess: () => { setChecklistOpen(false); checklistForm.reset(); } });
            }}>
                <FormInputField id="checklist-title" label="Titulo" value={checklistForm.data.titulo} error={checklistForm.errors.titulo} onChange={(event) => checklistForm.setData('titulo', event.target.value)} />
                <FormTextareaField id="checklist-description" label="Descripcion" value={checklistForm.data.descripcion} error={checklistForm.errors.descripcion} onChange={(event) => checklistForm.setData('descripcion', event.target.value)} />
                <SelectField label="Tipo" value={checklistForm.data.tipo} error={checklistForm.errors.tipo} onChange={(value) => checklistForm.setData('tipo', value)} options={['informacion', 'evidencia', 'tecnico', 'qa', 'cierre'].map((value) => ({ value, label: value }))} />
                <CheckField label="Requerido" checked={checklistForm.data.requerido} onChange={(checked) => checklistForm.setData('requerido', checked)} />
            </CrudFormDialog>

            <CrudFormDialog open={relationOpen} onOpenChange={setRelationOpen} title="Relacionar ticket" description="Vincula este ticket con otro registro." processing={relationForm.processing} onSubmit={(event) => {
                event.preventDefault();
                relationForm.post(route('tickets.relations.store', ticket.id), { preserveScroll: true, onSuccess: () => { setRelationOpen(false); relationForm.reset(); } });
            }}>
                <SelectField label="Ticket relacionado" value={relationForm.data.related_ticket_id} error={relationForm.errors.related_ticket_id} onChange={(value) => relationForm.setData('related_ticket_id', value)} options={relatedTicketOptions.map((option) => ({ value: option.id, label: `${option.folio} · ${option.titulo}` }))} />
                <SelectField label="Tipo de relacion" value={relationForm.data.tipo} error={relationForm.errors.tipo} onChange={(value) => relationForm.setData('tipo', value)} options={relationTypes} />
                <FormTextareaField id="relation-description" label="Descripcion" value={relationForm.data.descripcion} error={relationForm.errors.descripcion} onChange={(event) => relationForm.setData('descripcion', event.target.value)} />
            </CrudFormDialog>
        </AppLayout>
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

function CheckField({ label, checked, onChange }: { label: string; checked: boolean; onChange: (checked: boolean) => void }) {
    return <label className="flex items-center gap-2 text-sm"><Checkbox checked={checked} onCheckedChange={(value) => onChange(Boolean(value))} /> {label}</label>;
}

function Info({ label, value }: { label: string; value?: string | null }) {
    return <div className="rounded-md border p-3"><p className="text-xs text-muted-foreground">{label}</p><p className="text-sm font-medium">{value || '-'}</p></div>;
}

function Warning({ children }: { children: React.ReactNode }) {
    return <div className="flex gap-2 rounded-md border border-destructive/30 bg-destructive/10 p-3 text-sm text-destructive"><AlertCircle className="mt-0.5 size-4" /> <span>{children}</span></div>;
}

function MiniList({ title, items }: { title: string; items: string[] }) {
    return (
        <div className="rounded-md border p-3">
            <p className="text-sm font-medium">{title}</p>
            {items.length === 0 ? <p className="text-xs text-muted-foreground">Sin registros.</p> : items.map((item, index) => <p key={`${title}-${index}`} className="truncate text-xs text-muted-foreground">{item}</p>)}
        </div>
    );
}

function mergeMissingInformation(options: { key: string; label: string }[], current: TicketMissingInformationItem[]): TicketMissingInformationItem[] {
    return options.map((option) => current.find((item) => item.key === option.key) ?? { ...option, required: false, completed: false });
}

function updateMissing(form: ReturnType<typeof useForm<TriageFormValues>>, index: number, patch: Partial<TicketMissingInformationItem>) {
    form.setData('missing_information', form.data.missing_information.map((item, itemIndex) => itemIndex === index ? { ...item, ...patch } : item));
}

function calculateSuggestion(form: TriageFormValues, tipos: CatalogOption[], impactos: CatalogOption[], urgencias: CatalogOption[], riesgos: CatalogOption[], prioridades: CatalogOption[]) {
    const impact = valueFor(findName(impactos, form.impacto_id), { bajo: 1, medio: 2, alto: 3, critico: 4 });
    const urgency = valueFor(findName(urgencias, form.urgencia_id), { baja: 1, media: 2, alta: 3, inmediata: 4 });
    const risk = valueFor(findName(riesgos, form.riesgo_id), { bajo: 1, medio: 2, alto: 3 });
    const score = impact + urgency + risk;
    const type = key(findName(tipos, form.tipo_id));
    let prefix = impact >= 4 || urgency >= 4 || score >= 9 ? 'P0' : score >= 7 ? 'P1' : score >= 5 ? 'P2' : score >= 3 ? 'P3' : 'P4';

    if (['solicitud comercial', 'nuevo desarrollo'].includes(type) && !['P0', 'P1'].includes(prefix)) prefix = 'P4';
    if (type === 'incidente critico' && ['P2', 'P3', 'P4'].includes(prefix)) prefix = 'P1';

    const priority = prioridades.find((item) => item.nombre.startsWith(prefix));

    return {
        priorityId: priority?.id ?? null,
        priorityName: priority?.nombre ?? null,
        explanation: `Score ${score}: impacto ${impact}, urgencia ${urgency}, riesgo ${risk}.`,
        effortWarning: key(form.dificultad) === 'compleja' ? 'Dificultad compleja: revisar esfuerzo antes de comprometer entrega.' : null,
    };
}

function applyTypeDefaults(value: string, tipos: CatalogOption[], form: ReturnType<typeof useForm<TriageFormValues>>) {
    const type = key(findName(tipos, value));
    form.setData((data) => ({
        ...data,
        tipo_id: value,
        requires_code_change: type === 'nuevo desarrollo' ? true : data.requires_code_change,
        requires_quote: ['nuevo desarrollo', 'solicitud comercial'].includes(type) ? true : data.requires_quote,
    }));
}

function valueFor(name: string | null, values: Record<string, number>) {
    return values[key(name)] ?? 0;
}

function findName(items: CatalogOption[], value: string) {
    return items.find((item) => String(item.id) === value)?.nombre ?? null;
}

function key(value: string | null) {
    return (value ?? '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
}

const toCatalogOptions = (items: CatalogOption[]) => items.map((item) => ({ value: String(item.id), label: item.nombre }));
const toUserOptions = (items: UserOption[]) => items.map((item) => ({ value: String(item.id), label: item.name }));
