import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import type React from 'react';
import { Download, FileUp, Link2, Pencil, Trash2 } from 'lucide-react';
import { useState } from 'react';
import { route } from 'ziggy-js';
import { CrudFormDialog } from '@/components/crud-form-dialog';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { FilePickerDialog } from '@/components/file-picker-dialog';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Field, FieldError } from '@/components/ui/field';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type Payment = { id: string; folio: string; fecha_pago: string; moneda: string; monto: string | number; monto_aplicado: number; saldo_disponible: number; metodo_pago: string | null; referencia: string | null; estado: string; cliente?: { nombre?: string | null; razon_social?: string | null } | null; proyecto?: { nombre?: string | null } | null; aplicaciones: Application[]; documentos: Document[] };
type Charge = { id: string; folio: string; concepto: string; fecha_vencimiento: string; saldo: string | number };
type Application = { id: string; monto_aplicado: string | number; cargo: Charge };
type Document = { id: string; nombre_original: string; url: string; mime_type: string | null; size: number; descripcion: string | null };

export default function PaymentShow({ payment, pendingCharges }: { payment: Payment; pendingCharges: Charge[] }) {
    const permissions = usePage<SharedData>().props.auth.permissions ?? [];
    const canManage = permissions.includes('project-billing.payments.manage');
    const canConfirm = permissions.includes('project-billing.payments.confirm');
    const canDocs = permissions.includes('project-billing.documents.manage');
    const [allocationOpen, setAllocationOpen] = useState(false);
    const [documentOpen, setDocumentOpen] = useState(false);
    const [documentUploading, setDocumentUploading] = useState(false);
    const [cancelOpen, setCancelOpen] = useState(false);
    const allocationForm = useForm({ cargo_id: '', monto_aplicado: '' });
    const cancelForm = useForm({ cancellation_reason: '' });

    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Cobranza', href: route('project-billing.dashboard') },
        { title: 'Pagos', href: route('project-billing.payments.index') },
        { title: payment.folio, href: route('project-billing.payments.show', payment.id) },
    ];

    const appColumns: DataTableColumn<Application>[] = [
        { key: 'cargo', header: 'Cargo', cell: (row) => `${row.cargo.folio} - ${row.cargo.concepto}` },
        { key: 'vencimiento', header: 'Vencimiento', cell: (row) => date(row.cargo.fecha_vencimiento) },
        { key: 'monto', header: 'Aplicado', cell: (row) => money(row.monto_aplicado) },
        { key: 'actions', header: 'Acciones', cell: (row) => canManage && <Button variant="ghost" size="icon" onClick={() => router.delete(route('project-billing.payments.allocations.destroy', [payment.id, row.id]), { preserveScroll: true })}><Trash2 className="size-4" /></Button> },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={payment.folio} />
            <div className="space-y-4 p-4">
                <div className="flex flex-col gap-3 rounded-xl border bg-sidebar-accent/20 p-4 sm:flex-row sm:items-center sm:justify-between">
                    <div><h1 className="text-xl font-semibold">{payment.folio}</h1><p className="text-sm text-muted-foreground">{payment.cliente?.nombre ?? payment.cliente?.razon_social} {payment.proyecto ? `- ${payment.proyecto.nombre}` : ''}</p></div>
                    <div className="flex flex-wrap gap-2">
                        <StatusBadge status={payment.estado} />
                        <Button asChild variant="outline"><Link href={route('project-billing.payments.index')}>Volver</Link></Button>
                        {canManage && !['cancelado', 'rechazado'].includes(payment.estado) && <Button asChild variant="outline"><Link href={route('project-billing.payments.edit', payment.id)}><Pencil className="size-4" /> Editar</Link></Button>}
                        {canConfirm && payment.estado === 'registrado' && <Button onClick={() => router.patch(route('project-billing.payments.confirm', payment.id), {}, { preserveScroll: true })}>Confirmar pago</Button>}
                    </div>
                </div>

                <div className="grid gap-3 md:grid-cols-4">
                    <Metric label="Monto" value={money(payment.monto)} />
                    <Metric label="Aplicado" value={money(payment.monto_aplicado)} />
                    <Metric label="Disponible" value={money(payment.saldo_disponible)} />
                    <Metric label="Fecha pago" value={date(payment.fecha_pago)} />
                </div>

                <Card className="rounded-lg"><CardHeader><CardTitle>Aplicaciones</CardTitle></CardHeader><CardContent className="space-y-3">{canManage && payment.saldo_disponible > 0 && <Button onClick={() => setAllocationOpen(true)}><Link2 className="size-4" /> Aplicar a cargo</Button>}<DataTable columns={appColumns} data={payment.aplicaciones} showSearch={false} emptyMessage="Este pago no se ha aplicado a cargos." /></CardContent></Card>

                <Card className="rounded-lg"><CardHeader><CardTitle>Comprobantes</CardTitle></CardHeader><CardContent className="space-y-3">{canDocs && <Button onClick={() => setDocumentOpen(true)}><FileUp className="size-4" /> Agregar comprobante</Button>}<div className="grid gap-2">{payment.documentos.length === 0 && <p className="text-sm text-muted-foreground">No hay comprobantes.</p>}{payment.documentos.map((document) => <div key={document.id} className="flex items-center justify-between rounded-lg border p-3 text-sm"><div><p className="font-medium">{document.nombre_original}</p><p className="text-muted-foreground">{document.descripcion ?? document.mime_type ?? '-'}</p></div><div className="flex gap-1"><Button asChild variant="ghost" size="icon"><a href={route('project-billing.payments.documents.download', [payment.id, document.id])}><Download className="size-4" /></a></Button>{canDocs && <Button variant="ghost" size="icon" onClick={() => router.delete(route('project-billing.payments.documents.destroy', [payment.id, document.id]), { preserveScroll: true })}><Trash2 className="size-4" /></Button>}</div></div>)}</div></CardContent></Card>
                {canManage && !['cancelado', 'rechazado'].includes(payment.estado) && <Card className="rounded-lg"><CardHeader><CardTitle>Control del pago</CardTitle></CardHeader><CardContent><Button variant="outline" onClick={() => setCancelOpen(true)}>Cancelar pago</Button></CardContent></Card>}
            </div>

            <CrudFormDialog open={allocationOpen} onOpenChange={setAllocationOpen} title="Aplicar pago a cargo" description="El monto no puede exceder el saldo del cargo ni el saldo disponible del pago." onSubmit={(event: React.FormEvent<HTMLFormElement>) => { event.preventDefault(); allocationForm.post(route('project-billing.payments.allocations.store', payment.id), { preserveScroll: true, onSuccess: () => setAllocationOpen(false) }); }} submitLabel="Aplicar" processing={allocationForm.processing}>
                <Field><Label>Cargo</Label><Select value={allocationForm.data.cargo_id} onValueChange={(value) => allocationForm.setData('cargo_id', value)}><SelectTrigger><SelectValue placeholder="Selecciona cargo" /></SelectTrigger><SelectContent>{pendingCharges.map((charge) => <SelectItem key={charge.id} value={charge.id}>{charge.folio} - {charge.concepto} ({money(charge.saldo)})</SelectItem>)}</SelectContent></Select><FieldError>{allocationForm.errors.cargo_id}</FieldError></Field>
                <FormInputField label="Monto aplicado" type="number" min="0.01" step="0.01" value={allocationForm.data.monto_aplicado} onChange={(event) => allocationForm.setData('monto_aplicado', event.target.value)} error={allocationForm.errors.monto_aplicado} />
            </CrudFormDialog>

            <FilePickerDialog open={documentOpen} onOpenChange={setDocumentOpen} title="Comprobantes de pago" description="Sube comprobantes del pago. No se admiten ejecutables." storedFiles={payment.documentos.map((document) => ({ id: document.id, original_name: document.nombre_original, path: document.url, url: document.url, mime_type: document.mime_type, size: document.size }))} accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx,.xls,.xlsx,.txt,.csv,.zip" onUpload={(files) => { const file = files[0]; if (!file) return; router.post(route('project-billing.payments.documents.store', payment.id), { archivo: file }, { forceFormData: true, preserveScroll: true, onStart: () => setDocumentUploading(true), onFinish: () => setDocumentUploading(false), onSuccess: () => setDocumentOpen(false) }); }} onDeleteStoredFile={(id) => router.delete(route('project-billing.payments.documents.destroy', [payment.id, id]), { preserveScroll: true })} onDownloadStoredFile={(file) => window.open(file.url, '_blank', 'noopener,noreferrer')} uploading={documentUploading} />

            <CrudFormDialog open={cancelOpen} onOpenChange={setCancelOpen} title="Cancelar pago" description="Cancela el pago y revierte aplicaciones." onSubmit={(event: React.FormEvent<HTMLFormElement>) => { event.preventDefault(); cancelForm.patch(route('project-billing.payments.cancel', payment.id), { preserveScroll: true, onSuccess: () => setCancelOpen(false) }); }} submitLabel="Cancelar pago" processing={cancelForm.processing}>
                <FormTextareaField label="Motivo" value={cancelForm.data.cancellation_reason} onChange={(event) => cancelForm.setData('cancellation_reason', event.target.value)} error={cancelForm.errors.cancellation_reason} />
            </CrudFormDialog>
        </AppLayout>
    );
}

function Metric({ label, value }: { label: string; value: string }) { return <Card className="rounded-lg"><CardContent className="p-4"><p className="text-xs text-muted-foreground">{label}</p><p className="font-semibold">{value}</p></CardContent></Card>; }
function StatusBadge({ status }: { status: string }) { return <Badge variant={status === 'confirmado' ? 'default' : ['rechazado', 'cancelado'].includes(status) ? 'destructive' : 'outline'}>{status}</Badge>; }
const money = (value: string | number) => new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(Number(value ?? 0));
const date = (value: string) => new Date(value).toLocaleDateString('es-MX');
