import { Head, Link, useForm } from '@inertiajs/react';
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
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, ClientOption, ProjectOption } from '@/types';

type Payment = { id: string; cliente_id: string; proyecto_id: string | null; fecha_pago: string; moneda: string; monto: string | number; metodo_pago: string | null; referencia: string | null; banco: string | null; cuenta_origen: string | null; notas: string | null } | null;
type PaymentForm = { cliente_id: string; proyecto_id: string; fecha_pago: string; moneda: string; monto: string | number; metodo_pago: string; referencia: string; banco: string; cuenta_origen: string; notas: string };

export default function PaymentFormPage({ payment, clientes, proyectos, metodos }: { payment: Payment; clientes: ClientOption[]; proyectos: ProjectOption[]; metodos: string[] }) {
    const isEdit = Boolean(payment);
    const form = useForm<PaymentForm>({
        cliente_id: payment?.cliente_id ?? '',
        proyecto_id: payment?.proyecto_id ?? '',
        fecha_pago: payment?.fecha_pago?.slice(0, 10) ?? new Date().toISOString().slice(0, 10),
        moneda: payment?.moneda ?? 'MXN',
        monto: payment?.monto ?? '',
        metodo_pago: payment?.metodo_pago ?? 'transferencia',
        referencia: payment?.referencia ?? '',
        banco: payment?.banco ?? '',
        cuenta_origen: payment?.cuenta_origen ?? '',
        notas: payment?.notas ?? '',
    });
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Cobranza', href: route('project-billing.dashboard') },
        { title: 'Pagos', href: route('project-billing.payments.index') },
        { title: isEdit ? 'Editar' : 'Registrar', href: isEdit && payment ? route('project-billing.payments.edit', payment.id) : route('project-billing.payments.create') },
    ];

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        if (isEdit && payment) {
            form.put(route('project-billing.payments.update', payment.id));
            return;
        }
        form.post(route('project-billing.payments.store'));
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={isEdit ? 'Editar pago' : 'Registrar pago'} />
            <form onSubmit={submit} className="space-y-4 p-4">
                <Card className="rounded-lg">
                    <CardHeader><CardTitle>{isEdit ? 'Editar pago' : 'Registrar pago'}</CardTitle><CardDescription>Captura el pago recibido. Los comprobantes se suben desde el detalle del pago.</CardDescription></CardHeader>
                    <CardContent className="grid gap-4 md:grid-cols-2">
                        <Field><Label>Cliente</Label><Select value={form.data.cliente_id} onValueChange={(value) => form.setData('cliente_id', value)}><SelectTrigger><SelectValue placeholder="Selecciona cliente" /></SelectTrigger><SelectContent>{clientes.map((cliente) => <SelectItem key={cliente.id} value={cliente.id}>{cliente.nombre ?? cliente.razon_social ?? cliente.id}</SelectItem>)}</SelectContent></Select><FieldError>{form.errors.cliente_id}</FieldError></Field>
                        <Field><Label>Proyecto</Label><Select value={form.data.proyecto_id || 'sin_proyecto'} onValueChange={(value) => form.setData('proyecto_id', value === 'sin_proyecto' ? '' : value)}><SelectTrigger><SelectValue placeholder="Proyecto opcional" /></SelectTrigger><SelectContent><SelectItem value="sin_proyecto">Sin proyecto</SelectItem>{proyectos.filter((proyecto) => !form.data.cliente_id || proyecto.client_id === form.data.cliente_id).map((proyecto) => <SelectItem key={proyecto.id} value={proyecto.id}>{proyecto.nombre}</SelectItem>)}</SelectContent></Select><FieldError>{form.errors.proyecto_id}</FieldError></Field>
                        <FormInputField label="Fecha de pago" type="date" value={form.data.fecha_pago} onChange={(event) => form.setData('fecha_pago', event.target.value)} error={form.errors.fecha_pago} />
                        <FormInputField label="Monto" type="number" min="0.01" step="0.01" value={form.data.monto} onChange={(event) => form.setData('monto', event.target.value)} error={form.errors.monto} />
                        <FormInputField label="Moneda" value={form.data.moneda} maxLength={3} onChange={(event) => form.setData('moneda', event.target.value.toUpperCase())} error={form.errors.moneda} />
                        <Field><Label>Metodo de pago</Label><Select value={form.data.metodo_pago || 'otro'} onValueChange={(value) => form.setData('metodo_pago', value)}><SelectTrigger><SelectValue /></SelectTrigger><SelectContent>{metodos.map((metodo) => <SelectItem key={metodo} value={metodo}>{metodo}</SelectItem>)}</SelectContent></Select><FieldError>{form.errors.metodo_pago}</FieldError></Field>
                        <FormInputField label="Referencia" value={form.data.referencia} onChange={(event) => form.setData('referencia', event.target.value)} error={form.errors.referencia} />
                        <FormInputField label="Banco" value={form.data.banco} onChange={(event) => form.setData('banco', event.target.value)} error={form.errors.banco} />
                        <FormInputField label="Cuenta origen" value={form.data.cuenta_origen} onChange={(event) => form.setData('cuenta_origen', event.target.value)} error={form.errors.cuenta_origen} />
                        <div className="md:col-span-2"><FormTextareaField label="Notas" value={form.data.notas} onChange={(event) => form.setData('notas', event.target.value)} error={form.errors.notas} /></div>
                    </CardContent>
                </Card>
                <div className="flex justify-end gap-2"><Button asChild variant="outline"><Link href={route('project-billing.payments.index')}>Cancelar</Link></Button><LoadingSubmitButton processing={form.processing} label={isEdit ? 'Guardar pago' : 'Registrar pago'} /></div>
            </form>
        </AppLayout>
    );
}
