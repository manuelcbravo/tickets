import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import type React from 'react';
import { CheckCircle2, CircleDollarSign, Pencil, Plus, Trash2, XCircle } from 'lucide-react';
import { useState } from 'react';
import { route } from 'ziggy-js';
import { CrudFormDialog } from '@/components/crud-form-dialog';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Field, FieldError } from '@/components/ui/field';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type QuoteItem = {
    id: string;
    titulo: string;
    descripcion: string | null;
    tipo: string;
    cantidad: string | number;
    unidad: string;
    precio_unitario: string | number;
    subtotal: string | number;
    horas_estimadas: number | null;
    orden: number;
    es_opcional: boolean;
};

type QuoteApproval = {
    id: string;
    tipo: string;
    estado: string;
    comentario: string | null;
    nombre_aprobador: string | null;
    email_aprobador: string | null;
    approved_at: string | null;
    rejected_at: string | null;
    usuario?: { name: string } | null;
};

type RelatedTicket = {
    id: string;
    folio: string;
    titulo: string;
    quote_status: string | null;
    pivot?: { tipo_relacion?: string | null };
};

type Quote = {
    id: string;
    folio: string;
    titulo: string;
    descripcion: string | null;
    alcance: string | null;
    exclusiones: string | null;
    entregables: string | null;
    condiciones: string | null;
    notas_internas: string | null;
    moneda: string;
    subtotal: string | number;
    descuento: string | number;
    impuesto: string | number;
    total: string | number;
    horas_estimadas: number | null;
    dias_estimados: number | null;
    estado: string;
    enviada_at: string | null;
    aprobada_internamente_at: string | null;
    aprobada_cliente_at: string | null;
    rechazada_at: string | null;
    cancelada_at: string | null;
    convertida_at: string | null;
    cliente?: { nombre?: string | null; razon_social?: string | null } | null;
    proyecto?: { nombre?: string | null } | null;
    contacto?: { nombre?: string | null; email?: string | null } | null;
    ticket_origen?: { id: string; folio: string; titulo: string } | null;
    creado_por?: { name: string } | null;
    items: QuoteItem[];
    aprobaciones: QuoteApproval[];
    tickets: RelatedTicket[];
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Cotizaciones', href: route('quotes.index') },
    { title: 'Detalle', href: '#' },
];

const none = 'none';

export default function QuoteShow({
    quote,
    itemTypes,
    tipos,
    prioridades,
}: {
    quote: Quote;
    itemTypes: string[];
    tipos: { id: number; nombre: string }[];
    prioridades: { id: number; nombre: string }[];
}) {
    const permissions = usePage<SharedData>().props.auth.permissions ?? [];
    const canManage = permissions.includes('quotes.manage');
    const canApproveInternal = permissions.includes('quotes.approve.internal');
    const canApproveClient = permissions.includes('quotes.approve.client');
    const canConvert = permissions.includes('quotes.convert');
    const [itemDialogOpen, setItemDialogOpen] = useState(false);
    const [editingItem, setEditingItem] = useState<QuoteItem | null>(null);
    const [approveInternalOpen, setApproveInternalOpen] = useState(false);
    const [approveClientOpen, setApproveClientOpen] = useState(false);
    const [rejectOpen, setRejectOpen] = useState(false);
    const [cancelOpen, setCancelOpen] = useState(false);
    const [convertOpen, setConvertOpen] = useState(false);

    const itemForm = useForm({
        titulo: '',
        descripcion: '',
        tipo: 'servicio',
        cantidad: '1',
        unidad: 'servicio',
        precio_unitario: '0',
        horas_estimadas: '',
        orden: '0',
        es_opcional: false,
    });
    const approveInternalForm = useForm({ comentario: '' });
    const approveClientForm = useForm({ nombre_aprobador: '', email_aprobador: '', comentario: '' });
    const rejectForm = useForm({ comentario: '' });
    const cancelForm = useForm({ comentario: '' });
    const convertForm = useForm({
        create_single_ticket: true,
        tipo_id: tipos[0]?.id ? String(tipos[0].id) : none,
        prioridad_id: prioridades[0]?.id ? String(prioridades[0].id) : none,
    });

    const openItemDialog = (item?: QuoteItem) => {
        setEditingItem(item ?? null);
        itemForm.setData({
            titulo: item?.titulo ?? '',
            descripcion: item?.descripcion ?? '',
            tipo: item?.tipo ?? 'servicio',
            cantidad: String(item?.cantidad ?? 1),
            unidad: item?.unidad ?? 'servicio',
            precio_unitario: String(item?.precio_unitario ?? 0),
            horas_estimadas: item?.horas_estimadas ? String(item.horas_estimadas) : '',
            orden: String(item?.orden ?? 0),
            es_opcional: Boolean(item?.es_opcional),
        });
        itemForm.clearErrors();
        setItemDialogOpen(true);
    };

    const submitItem = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        const options = { preserveScroll: true, onSuccess: () => setItemDialogOpen(false) };
        if (editingItem) {
            itemForm.patch(route('quotes.items.update', [quote.id, editingItem.id]), options);
            return;
        }
        itemForm.post(route('quotes.items.store', quote.id), options);
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={quote.folio} />
            <div className="space-y-4 rounded-xl p-4">
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
                    <div className="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <div className="flex flex-wrap items-center gap-2">
                                <Badge variant={quoteStatusVariant(quote.estado)}>{labelize(quote.estado)}</Badge>
                                <span className="font-mono text-sm text-muted-foreground">{quote.folio}</span>
                            </div>
                            <h1 className="mt-2 text-2xl font-semibold">{quote.titulo}</h1>
                            <p className="text-sm text-muted-foreground">{quote.cliente?.nombre ?? quote.cliente?.razon_social ?? 'Sin cliente'}{quote.proyecto ? ` / ${quote.proyecto.nombre}` : ''}</p>
                        </div>
                        <div className="flex flex-wrap gap-2">
                            <Button asChild variant="outline"><Link href={route('quotes.index')}>Volver</Link></Button>
                            {canManage && quote.estado !== 'convertida' && <Button asChild variant="outline"><Link href={route('quotes.edit', quote.id)}><Pencil className="size-4" /> Editar</Link></Button>}
                            {canApproveInternal && quote.estado === 'borrador' && <Button onClick={() => setApproveInternalOpen(true)}><CheckCircle2 className="size-4" /> Aprobar interna</Button>}
                            {canApproveClient && ['aprobada_internamente', 'enviada'].includes(quote.estado) && <Button onClick={() => setApproveClientOpen(true)}><CheckCircle2 className="size-4" /> Aprobar cliente</Button>}
                            {canConvert && quote.estado === 'aprobada_cliente' && <Button onClick={() => setConvertOpen(true)}><CircleDollarSign className="size-4" /> Convertir</Button>}
                        </div>
                    </div>
                </div>

                <div className="grid gap-4 lg:grid-cols-4">
                    <SummaryCard title="Subtotal" value={formatCurrency(quote.subtotal, quote.moneda)} />
                    <SummaryCard title="Descuento" value={formatCurrency(quote.descuento, quote.moneda)} />
                    <SummaryCard title="Impuesto" value={formatCurrency(quote.impuesto, quote.moneda)} />
                    <SummaryCard title="Total" value={formatCurrency(quote.total, quote.moneda)} strong />
                </div>

                <div className="grid gap-4 xl:grid-cols-3">
                    <Card className="rounded-lg xl:col-span-2">
                        <CardHeader><CardTitle>Alcance comercial</CardTitle></CardHeader>
                        <CardContent className="grid gap-4 md:grid-cols-2">
                            <TextBlock title="Descripcion" value={quote.descripcion} />
                            <TextBlock title="Alcance" value={quote.alcance} />
                            <TextBlock title="Exclusiones" value={quote.exclusiones} />
                            <TextBlock title="Entregables" value={quote.entregables} />
                            <TextBlock title="Condiciones" value={quote.condiciones} />
                            <TextBlock title="Notas internas" value={quote.notas_internas} muted />
                        </CardContent>
                    </Card>
                    <Card className="rounded-lg">
                        <CardHeader><CardTitle>Datos generales</CardTitle></CardHeader>
                        <CardContent className="space-y-3 text-sm">
                            <Info label="Cliente" value={quote.cliente?.nombre ?? quote.cliente?.razon_social} />
                            <Info label="Proyecto" value={quote.proyecto?.nombre} />
                            <Info label="Contacto" value={quote.contacto?.nombre} />
                            <Info label="Creado por" value={quote.creado_por?.name} />
                            <Info label="Horas estimadas" value={quote.horas_estimadas?.toString()} />
                            <Info label="Dias estimados" value={quote.dias_estimados?.toString()} />
                            {quote.ticket_origen && <div><span className="text-muted-foreground">Ticket origen</span><br /><Link className="font-medium text-primary hover:underline" href={route('tickets.show', quote.ticket_origen.id)}>{quote.ticket_origen.folio}</Link></div>}
                        </CardContent>
                    </Card>
                </div>

                <Card className="rounded-lg">
                    <CardHeader className="flex flex-row items-center justify-between">
                        <div>
                            <CardTitle>Partidas</CardTitle>
                            <CardDescription>Los totales se recalculan a partir de estas partidas.</CardDescription>
                        </div>
                        {canManage && quote.estado !== 'convertida' && <Button onClick={() => openItemDialog()}><Plus className="size-4" /> Agregar item</Button>}
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader><TableRow><TableHead>Titulo</TableHead><TableHead>Tipo</TableHead><TableHead>Cantidad</TableHead><TableHead>Unitario</TableHead><TableHead>Subtotal</TableHead><TableHead>Horas</TableHead><TableHead>Opcional</TableHead><TableHead /></TableRow></TableHeader>
                            <TableBody>
                                {quote.items.length === 0 ? <TableRow><TableCell colSpan={8} className="text-muted-foreground">Sin partidas.</TableCell></TableRow> : quote.items.map((item) => (
                                    <TableRow key={item.id}>
                                        <TableCell><div className="font-medium">{item.titulo}</div><div className="text-xs text-muted-foreground">{item.descripcion}</div></TableCell>
                                        <TableCell><Badge variant="outline">{labelize(item.tipo)}</Badge></TableCell>
                                        <TableCell>{Number(item.cantidad)}</TableCell>
                                        <TableCell>{formatCurrency(item.precio_unitario, quote.moneda)}</TableCell>
                                        <TableCell>{formatCurrency(item.subtotal, quote.moneda)}</TableCell>
                                        <TableCell>{item.horas_estimadas ?? '-'}</TableCell>
                                        <TableCell>{item.es_opcional ? 'Si' : 'No'}</TableCell>
                                        <TableCell className="text-right">
                                            {canManage && quote.estado !== 'convertida' && <div className="flex justify-end gap-1"><Button size="icon" variant="ghost" onClick={() => openItemDialog(item)}><Pencil className="size-4" /></Button><Button size="icon" variant="ghost" onClick={() => router.delete(route('quotes.items.destroy', [quote.id, item.id]), { preserveScroll: true })}><Trash2 className="size-4" /></Button></div>}
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>

                <div className="grid gap-4 xl:grid-cols-2">
                    <Card className="rounded-lg">
                        <CardHeader><CardTitle>Aprobaciones</CardTitle></CardHeader>
                        <CardContent>
                            <Table>
                                <TableHeader><TableRow><TableHead>Tipo</TableHead><TableHead>Estado</TableHead><TableHead>Aprobador</TableHead><TableHead>Fecha</TableHead><TableHead>Comentario</TableHead></TableRow></TableHeader>
                                <TableBody>
                                    {quote.aprobaciones.length === 0 ? <TableRow><TableCell colSpan={5} className="text-muted-foreground">Sin aprobaciones.</TableCell></TableRow> : quote.aprobaciones.map((approval) => (
                                        <TableRow key={approval.id}>
                                            <TableCell>{approval.tipo}</TableCell>
                                            <TableCell><Badge variant={approval.estado === 'aprobada' ? 'default' : approval.estado === 'rechazada' ? 'destructive' : 'outline'}>{approval.estado}</Badge></TableCell>
                                            <TableCell>{approval.nombre_aprobador ?? approval.usuario?.name ?? '-'}</TableCell>
                                            <TableCell>{approval.approved_at ?? approval.rejected_at ? new Date(approval.approved_at ?? approval.rejected_at ?? '').toLocaleDateString('es-MX') : '-'}</TableCell>
                                            <TableCell>{approval.comentario ?? '-'}</TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </CardContent>
                    </Card>
                    <Card className="rounded-lg">
                        <CardHeader><CardTitle>Tickets relacionados</CardTitle></CardHeader>
                        <CardContent>
                            <Table>
                                <TableHeader><TableRow><TableHead>Folio</TableHead><TableHead>Titulo</TableHead><TableHead>Relacion</TableHead><TableHead>Estado cotizacion</TableHead></TableRow></TableHeader>
                                <TableBody>
                                    {quote.tickets.length === 0 ? <TableRow><TableCell colSpan={4} className="text-muted-foreground">Sin tickets relacionados.</TableCell></TableRow> : quote.tickets.map((ticket) => (
                                        <TableRow key={`${ticket.id}-${ticket.pivot?.tipo_relacion}`}>
                                            <TableCell><Link className="font-medium text-primary hover:underline" href={route('tickets.show', ticket.id)}>{ticket.folio}</Link></TableCell>
                                            <TableCell>{ticket.titulo}</TableCell>
                                            <TableCell><Badge variant="outline">{ticket.pivot?.tipo_relacion ?? 'relacionado'}</Badge></TableCell>
                                            <TableCell>{ticket.quote_status ?? '-'}</TableCell>
                                        </TableRow>
                                    ))}
                                </TableBody>
                            </Table>
                        </CardContent>
                    </Card>
                </div>

                {(canApproveClient || canManage) && !['rechazada_cliente', 'cancelada', 'convertida'].includes(quote.estado) && (
                    <Card className="rounded-lg">
                        <CardHeader><CardTitle>Control de cotizacion</CardTitle><CardDescription>Acciones administrativas que requieren confirmacion.</CardDescription></CardHeader>
                        <CardContent className="flex flex-wrap gap-2">
                            {canApproveClient && <Button variant="outline" onClick={() => setRejectOpen(true)}><XCircle className="size-4" /> Rechazar cliente</Button>}
                            {canManage && <Button variant="outline" onClick={() => setCancelOpen(true)}><XCircle className="size-4" /> Cancelar</Button>}
                        </CardContent>
                    </Card>
                )}
            </div>

            <CrudFormDialog open={itemDialogOpen} onOpenChange={setItemDialogOpen} title={editingItem ? 'Editar partida' : 'Agregar partida'} description="Define concepto, cantidad y precio unitario." submitLabel="Guardar partida" processing={itemForm.processing} onSubmit={submitItem} size="lg">
                <div className="grid gap-4 md:grid-cols-2">
                    <FormInputField id="item-title" label="Titulo" value={itemForm.data.titulo} error={itemForm.errors.titulo} onChange={(event) => itemForm.setData('titulo', event.target.value)} />
                    <SelectField label="Tipo" value={itemForm.data.tipo} error={itemForm.errors.tipo} onChange={(value) => itemForm.setData('tipo', value)} options={itemTypes.map((type) => ({ value: type, label: labelize(type) }))} />
                    <FormInputField id="item-quantity" label="Cantidad" type="number" min="0.01" step="0.01" value={itemForm.data.cantidad} error={itemForm.errors.cantidad} onChange={(event) => itemForm.setData('cantidad', event.target.value)} />
                    <FormInputField id="item-unit" label="Unidad" value={itemForm.data.unidad} error={itemForm.errors.unidad} onChange={(event) => itemForm.setData('unidad', event.target.value)} />
                    <FormInputField id="item-price" label="Precio unitario" type="number" min="0" step="0.01" value={itemForm.data.precio_unitario} error={itemForm.errors.precio_unitario} onChange={(event) => itemForm.setData('precio_unitario', event.target.value)} />
                    <FormInputField id="item-hours" label="Horas estimadas" type="number" min="0" value={itemForm.data.horas_estimadas} error={itemForm.errors.horas_estimadas} onChange={(event) => itemForm.setData('horas_estimadas', event.target.value)} />
                    <FormInputField id="item-order" label="Orden" type="number" value={itemForm.data.orden} error={itemForm.errors.orden} onChange={(event) => itemForm.setData('orden', event.target.value)} />
                    <label className="mt-6 flex items-center gap-2 text-sm"><Checkbox checked={itemForm.data.es_opcional} onCheckedChange={(value) => itemForm.setData('es_opcional', Boolean(value))} /> Partida opcional</label>
                    <div className="md:col-span-2"><FormTextareaField id="item-description" label="Descripcion" value={itemForm.data.descripcion} error={itemForm.errors.descripcion} onChange={(event) => itemForm.setData('descripcion', event.target.value)} /></div>
                </div>
            </CrudFormDialog>

            <CrudFormDialog open={approveInternalOpen} onOpenChange={setApproveInternalOpen} title="Aprobar internamente" description="Registra la aprobacion interna de esta cotizacion." submitLabel="Aprobar" processing={approveInternalForm.processing} onSubmit={(event) => { event.preventDefault(); approveInternalForm.patch(route('quotes.approve-internal', quote.id), { preserveScroll: true, onSuccess: () => setApproveInternalOpen(false) }); }}>
                <FormTextareaField id="internal-comment" label="Comentario" value={approveInternalForm.data.comentario} error={approveInternalForm.errors.comentario} onChange={(event) => approveInternalForm.setData('comentario', event.target.value)} />
            </CrudFormDialog>

            <CrudFormDialog open={approveClientOpen} onOpenChange={setApproveClientOpen} title="Registrar aprobacion cliente" description="Captura quien aprobo la cotizacion por parte del cliente." submitLabel="Aprobar cliente" processing={approveClientForm.processing} onSubmit={(event) => { event.preventDefault(); approveClientForm.patch(route('quotes.approve-client', quote.id), { preserveScroll: true, onSuccess: () => setApproveClientOpen(false) }); }}>
                <FormInputField id="client-approver" label="Nombre aprobador" value={approveClientForm.data.nombre_aprobador} error={approveClientForm.errors.nombre_aprobador} onChange={(event) => approveClientForm.setData('nombre_aprobador', event.target.value)} />
                <FormInputField id="client-email" label="Email aprobador" type="email" value={approveClientForm.data.email_aprobador} error={approveClientForm.errors.email_aprobador} onChange={(event) => approveClientForm.setData('email_aprobador', event.target.value)} />
                <FormTextareaField id="client-comment" label="Comentario" value={approveClientForm.data.comentario} error={approveClientForm.errors.comentario} onChange={(event) => approveClientForm.setData('comentario', event.target.value)} />
            </CrudFormDialog>

            <CrudFormDialog open={rejectOpen} onOpenChange={setRejectOpen} title="Rechazar cotizacion" description="El rechazo de cliente requiere comentario." submitLabel="Registrar rechazo" processing={rejectForm.processing} onSubmit={(event) => { event.preventDefault(); rejectForm.patch(route('quotes.reject-client', quote.id), { preserveScroll: true, onSuccess: () => setRejectOpen(false) }); }}>
                <FormTextareaField id="reject-comment" label="Comentario" value={rejectForm.data.comentario} error={rejectForm.errors.comentario} onChange={(event) => rejectForm.setData('comentario', event.target.value)} />
            </CrudFormDialog>

            <CrudFormDialog open={cancelOpen} onOpenChange={setCancelOpen} title="Cancelar cotizacion" description="La cancelacion requiere una razon para auditoria." submitLabel="Cancelar cotizacion" processing={cancelForm.processing} onSubmit={(event) => { event.preventDefault(); cancelForm.patch(route('quotes.cancel', quote.id), { preserveScroll: true, onSuccess: () => setCancelOpen(false) }); }}>
                <FormTextareaField id="cancel-comment" label="Comentario" value={cancelForm.data.comentario} error={cancelForm.errors.comentario} onChange={(event) => cancelForm.setData('comentario', event.target.value)} />
            </CrudFormDialog>

            <CrudFormDialog open={convertOpen} onOpenChange={setConvertOpen} title="Convertir en tickets" description="Esta accion creara tickets reales derivados de la cotizacion aprobada." submitLabel="Convertir" processing={convertForm.processing} onSubmit={(event) => { event.preventDefault(); convertForm.transform((data) => ({ ...data, tipo_id: normalize(data.tipo_id), prioridad_id: normalize(data.prioridad_id) })); convertForm.patch(route('quotes.convert', quote.id), { preserveScroll: true, onSuccess: () => setConvertOpen(false) }); }}>
                <label className="flex items-center gap-2 text-sm"><Checkbox checked={convertForm.data.create_single_ticket} onCheckedChange={(value) => convertForm.setData('create_single_ticket', Boolean(value))} /> Crear un ticket unico de ejecucion</label>
                <SelectField label="Tipo inicial" value={convertForm.data.tipo_id} error={convertForm.errors.tipo_id} onChange={(value) => convertForm.setData('tipo_id', value)} options={[{ value: none, label: 'Usar predeterminado' }, ...tipos.map((tipo) => ({ value: String(tipo.id), label: tipo.nombre }))]} />
                <SelectField label="Prioridad inicial" value={convertForm.data.prioridad_id} error={convertForm.errors.prioridad_id} onChange={(value) => convertForm.setData('prioridad_id', value)} options={[{ value: none, label: 'Usar predeterminada' }, ...prioridades.map((prioridad) => ({ value: String(prioridad.id), label: prioridad.nombre }))]} />
            </CrudFormDialog>
        </AppLayout>
    );
}

function SummaryCard({ title, value, strong = false }: { title: string; value: string; strong?: boolean }) {
    return (
        <Card className="rounded-lg">
            <CardHeader className="pb-2"><CardTitle className="text-sm">{title}</CardTitle></CardHeader>
            <CardContent><p className={strong ? 'text-2xl font-semibold' : 'text-xl font-medium'}>{value}</p></CardContent>
        </Card>
    );
}

function TextBlock({ title, value, muted = false }: { title: string; value: string | null; muted?: boolean }) {
    return <div><h3 className="mb-1 text-sm font-medium">{title}</h3><p className={muted ? 'whitespace-pre-wrap text-sm text-muted-foreground' : 'whitespace-pre-wrap text-sm'}>{value || '-'}</p></div>;
}

function Info({ label, value }: { label: string; value?: string | null }) {
    return <div><span className="text-muted-foreground">{label}</span><br /><span className="font-medium">{value ?? '-'}</span></div>;
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

function quoteStatusVariant(status: string) {
    if (['aprobada_cliente', 'convertida'].includes(status)) return 'default';
    if (['rechazada_cliente', 'cancelada'].includes(status)) return 'destructive';
    if (['aprobada_internamente', 'enviada'].includes(status)) return 'secondary';
    return 'outline';
}

const labelize = (value: string) => value.replaceAll('_', ' ');
const normalize = (value: string) => value === none || value === '' ? null : value;
const formatCurrency = (value: string | number, currency = 'MXN') => new Intl.NumberFormat('es-MX', { style: 'currency', currency }).format(Number(value ?? 0));
