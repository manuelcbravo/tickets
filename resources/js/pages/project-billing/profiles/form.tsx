import { Head, Link, useForm } from '@inertiajs/react';
import { AlertTriangle } from 'lucide-react';
import type React from 'react';
import { route } from 'ziggy-js';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { LoadingSubmitButton } from '@/components/loading-submit-button';
import { ModuleHeader } from '@/components/module-header';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Field, FieldError } from '@/components/ui/field';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';

type ClientOption = {
    id: string;
    nombre: string | null;
    razon_social?: string | null;
    estatus?: string | null;
};

type ActivePlan = {
    id: string;
    tipo_cobro: string;
    estado: string;
    activo: boolean;
};

type ProjectOption = {
    id: string;
    client_id: string;
    nombre: string;
    plan_cobro?: ActivePlan | null;
};

type BillingProfile = {
    id: string;
    cliente_id: string;
    proyecto_id: string;
    tipo_cobro: string;
    moneda: string;
    monto_total: string | number | null;
    monto_mensual: string | number | null;
    dia_vencimiento: number | null;
    fecha_inicio: string | null;
    fecha_fin: string | null;
    notas: string | null;
} | null;

type BillingProfileForm = {
    cliente_id: string;
    proyecto_id: string;
    tipo_cobro: string;
    moneda: string;
    monto_total: string;
    monto_mensual: string;
    dia_vencimiento: string;
    fecha_inicio: string;
    fecha_fin: string;
    notas: string;
    generar_cargo_inicial: boolean;
    generar_cargo_mes_actual: boolean;
    generar_cargos_mensuales: boolean;
    fecha_emision: string;
    fecha_vencimiento: string;
    concepto_cargo: string;
    reemplazar_plan_activo: boolean;
    activo: boolean;
};

export default function BillingProfileFormPage({
    profile,
    clientes,
    proyectos,
    tipoCobroOptions,
}: {
    profile: BillingProfile;
    clientes: ClientOption[];
    proyectos: ProjectOption[];
    tipoCobroOptions: string[];
}) {
    const isEdit = Boolean(profile);
    const today = new Date().toISOString().slice(0, 10);
    const form = useForm<BillingProfileForm>({
        cliente_id: profile?.cliente_id ?? '',
        proyecto_id: profile?.proyecto_id ?? '',
        tipo_cobro: profile?.tipo_cobro ?? 'unico',
        moneda: profile?.moneda ?? 'MXN',
        monto_total: profile?.monto_total ? String(profile.monto_total) : '',
        monto_mensual: profile?.monto_mensual ? String(profile.monto_mensual) : '',
        dia_vencimiento: profile?.dia_vencimiento ? String(profile.dia_vencimiento) : '',
        fecha_inicio: profile?.fecha_inicio?.slice(0, 10) ?? today,
        fecha_fin: profile?.fecha_fin?.slice(0, 10) ?? '',
        notas: profile?.notas ?? '',
        generar_cargo_inicial: true,
        generar_cargo_mes_actual: false,
        generar_cargos_mensuales: !isEdit,
        fecha_emision: today,
        fecha_vencimiento: today,
        concepto_cargo: '',
        reemplazar_plan_activo: false,
        activo: true,
    });
    const filteredProjects = proyectos.filter((proyecto) => !form.data.cliente_id || proyecto.client_id === form.data.cliente_id);
    const selectedProject = proyectos.find((proyecto) => proyecto.id === form.data.proyecto_id);
    const activePlan = !isEdit ? selectedProject?.plan_cobro : null;
    const showSingleChargeFields = form.data.tipo_cobro === 'unico';
    const showMonthlyFields = form.data.tipo_cobro === 'mensual';
    const showPartialFields = form.data.tipo_cobro === 'parcialidades';
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Cobranza', href: route('project-billing.dashboard') },
        { title: isEdit ? 'Editar plan' : 'Configurar plan', href: isEdit && profile ? route('project-billing.profiles.edit', profile.id) : route('project-billing.profiles.create') },
    ];

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        if (isEdit && profile) {
            form.put(route('project-billing.profiles.update', profile.id));
            return;
        }

        form.post(route('project-billing.profiles.store'));
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={isEdit ? 'Editar plan de cobro' : 'Configurar cobranza'} />
            <form onSubmit={submit} className="space-y-4 p-4">
                <ModuleHeader
                    title={isEdit ? 'Editar plan de cobro' : 'Configurar cobranza de proyecto'}
                    description="Define si el proyecto se cobrara como pago unico, mensualidad tipo SaaS o parcialidades. El plan queda ligado al proyecto y a sus cargos."
                />

                <Card className="rounded-lg">
                    <CardHeader>
                        <CardTitle>Proyecto y tipo de cobro</CardTitle>
                        <CardDescription>Selecciona el cliente, el proyecto y la modalidad de cobranza.</CardDescription>
                    </CardHeader>
                    <CardContent className="grid gap-4 md:grid-cols-2">
                        <Field>
                            <Label>Cliente</Label>
                            <Select
                                disabled={isEdit}
                                value={form.data.cliente_id}
                                onValueChange={(value) => {
                                    form.setData('cliente_id', value);
                                    if (form.data.proyecto_id && proyectos.find((proyecto) => proyecto.id === form.data.proyecto_id)?.client_id !== value) {
                                        form.setData('proyecto_id', '');
                                    }
                                }}
                            >
                                <SelectTrigger><SelectValue placeholder="Selecciona cliente" /></SelectTrigger>
                                <SelectContent>{clientes.map((cliente) => <SelectItem key={cliente.id} value={cliente.id}>{cliente.nombre ?? cliente.razon_social ?? cliente.id}</SelectItem>)}</SelectContent>
                            </Select>
                            <FieldError>{form.errors.cliente_id}</FieldError>
                        </Field>

                        <Field>
                            <Label>Proyecto</Label>
                            <Select disabled={isEdit} value={form.data.proyecto_id} onValueChange={(value) => form.setData('proyecto_id', value)}>
                                <SelectTrigger><SelectValue placeholder="Selecciona proyecto" /></SelectTrigger>
                                <SelectContent>{filteredProjects.map((proyecto) => <SelectItem key={proyecto.id} value={proyecto.id}>{proyecto.nombre}</SelectItem>)}</SelectContent>
                            </Select>
                            <FieldError>{form.errors.proyecto_id}</FieldError>
                        </Field>

                        {activePlan && (
                            <div className="md:col-span-2 rounded-lg border border-amber-300 bg-amber-50 p-3 text-sm text-amber-950">
                                <div className="flex gap-2">
                                    <AlertTriangle className="mt-0.5 size-4" />
                                    <div className="space-y-2">
                                        <p className="font-medium">Este proyecto ya tiene un plan de cobro activo.</p>
                                        <p>Tipo actual: {activePlan.tipo_cobro}. Puedes editarlo o confirmar que deseas reemplazarlo.</p>
                                        <div className="flex flex-wrap gap-2">
                                            <Button asChild size="sm" variant="outline"><Link href={route('project-billing.profiles.edit', activePlan.id)}>Editar plan existente</Link></Button>
                                            <label className="flex items-center gap-2">
                                                <Checkbox checked={form.data.reemplazar_plan_activo} onCheckedChange={(checked) => form.setData('reemplazar_plan_activo', Boolean(checked))} />
                                                Reemplazar plan activo
                                            </label>
                                        </div>
                                        <FieldError>{form.errors.reemplazar_plan_activo}</FieldError>
                                    </div>
                                </div>
                            </div>
                        )}

                        <Field>
                            <Label>Tipo de cobro</Label>
                            <Select value={form.data.tipo_cobro} onValueChange={(value) => form.setData('tipo_cobro', value)}>
                                <SelectTrigger><SelectValue /></SelectTrigger>
                                <SelectContent>{tipoCobroOptions.map((option) => <SelectItem key={option} value={option}>{option}</SelectItem>)}</SelectContent>
                            </Select>
                            <FieldError>{form.errors.tipo_cobro}</FieldError>
                        </Field>
                        <FormInputField label="Moneda" value={form.data.moneda} maxLength={3} onChange={(event) => form.setData('moneda', event.target.value.toUpperCase())} error={form.errors.moneda} />
                    </CardContent>
                </Card>

                <Card className="rounded-lg">
                    <CardHeader>
                        <CardTitle>Condiciones de cobro</CardTitle>
                        <CardDescription>Captura los montos y fechas necesarias para generar cargos.</CardDescription>
                    </CardHeader>
                    <CardContent className="grid gap-4 md:grid-cols-2">
                        {(form.data.tipo_cobro === 'unico' || showPartialFields) && <FormInputField label="Monto total" type="number" min="0.01" step="0.01" value={form.data.monto_total} onChange={(event) => form.setData('monto_total', event.target.value)} error={form.errors.monto_total} />}
                        {showMonthlyFields && <FormInputField label="Monto mensual" type="number" min="0.01" step="0.01" value={form.data.monto_mensual} onChange={(event) => form.setData('monto_mensual', event.target.value)} error={form.errors.monto_mensual} />}
                        {showMonthlyFields && <FormInputField label="Dia de vencimiento" type="number" min="1" max="31" value={form.data.dia_vencimiento} onChange={(event) => form.setData('dia_vencimiento', event.target.value)} error={form.errors.dia_vencimiento} />}
                        {(showMonthlyFields || showPartialFields) && <FormInputField label="Fecha inicio" type="date" value={form.data.fecha_inicio} onChange={(event) => form.setData('fecha_inicio', event.target.value)} error={form.errors.fecha_inicio} />}
                        {(showMonthlyFields || showPartialFields) && <FormInputField label="Fecha fin" type="date" value={form.data.fecha_fin} onChange={(event) => form.setData('fecha_fin', event.target.value)} error={form.errors.fecha_fin} />}

                        {showSingleChargeFields && (
                            <>
                                <div className="md:col-span-2 rounded-md border bg-muted/30 p-3 text-sm text-muted-foreground">
                                    Al guardar se generara automaticamente el cargo inicial por el monto total.
                                </div>
                                <FormInputField label="Concepto del cargo" value={form.data.concepto_cargo} onChange={(event) => form.setData('concepto_cargo', event.target.value)} error={form.errors.concepto_cargo} />
                                <FormInputField label="Fecha emision" type="date" value={form.data.fecha_emision} onChange={(event) => form.setData('fecha_emision', event.target.value)} error={form.errors.fecha_emision} />
                                <FormInputField label="Fecha vencimiento" type="date" value={form.data.fecha_vencimiento} onChange={(event) => form.setData('fecha_vencimiento', event.target.value)} error={form.errors.fecha_vencimiento} />
                            </>
                        )}

                        {showMonthlyFields && (
                            <div className="md:col-span-2 rounded-md border bg-muted/30 p-3 text-sm text-muted-foreground">
                                Se generaran cargos mensuales desde la fecha de inicio hasta la fecha de fin del contrato.
                            </div>
                        )}

                        {showPartialFields && (
                            <div className="md:col-span-2 rounded-md border bg-muted/30 p-3 text-sm text-muted-foreground">
                                El plan quedara configurado. Despues genera las parcialidades para crear cargos.
                            </div>
                        )}

                        <div className="md:col-span-2">
                            <FormTextareaField label="Notas" value={form.data.notas} onChange={(event) => form.setData('notas', event.target.value)} error={form.errors.notas} />
                        </div>
                    </CardContent>
                </Card>

                <div className="flex justify-end gap-2">
                    <Button asChild variant="outline"><Link href={route('project-billing.dashboard')}>Cancelar</Link></Button>
                    <LoadingSubmitButton processing={form.processing} label={isEdit ? 'Guardar plan' : 'Configurar cobranza'} />
                </div>
            </form>
        </AppLayout>
    );
}
