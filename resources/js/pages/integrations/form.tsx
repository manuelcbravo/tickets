import { Head, Link, useForm } from '@inertiajs/react';
import type React from 'react';
import { route } from 'ziggy-js';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { LoadingSubmitButton } from '@/components/loading-submit-button';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Field, FieldError } from '@/components/ui/field';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';

type Integration = {
    id: string;
    nombre: string;
    tipo: string;
    proveedor: string | null;
    descripcion: string | null;
    activo: boolean;
    config?: Record<string, unknown> | null;
};

const none = 'none';

export default function IntegrationForm({ integration, types, providers }: { integration?: Integration; types: string[]; providers: string[] }) {
    const form = useForm({
        nombre: integration?.nombre ?? '',
        tipo: integration?.tipo ?? 'webhook',
        proveedor: integration?.proveedor ?? none,
        descripcion: integration?.descripcion ?? '',
        config_json: JSON.stringify(integration?.config ?? {}, null, 2),
        activo: integration?.activo ?? true,
    });
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Integraciones', href: route('integrations.index') },
        { title: integration ? 'Editar' : 'Nueva', href: '#' },
    ];

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        form.transform((data) => ({
            nombre: data.nombre,
            tipo: data.tipo,
            proveedor: data.proveedor === none ? null : data.proveedor,
            descripcion: data.descripcion,
            config: parseConfig(data.config_json),
            activo: data.activo,
        }));

        if (integration) {
            form.patch(route('integrations.update', integration.id));
            return;
        }

        form.post(route('integrations.store'));
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={integration ? 'Editar integracion' : 'Nueva integracion'} />
            <div className="rounded-xl p-4">
                <form onSubmit={submit}>
                    <Card className="rounded-lg">
                        <CardHeader>
                            <CardTitle>{integration ? 'Editar integracion' : 'Nueva integracion'}</CardTitle>
                            <CardDescription>Configura integraciones sin guardar secretos; usa variables .env para firmas y tokens.</CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            <div className="grid gap-4 md:grid-cols-2">
                                <FormInputField id="integration-name" label="Nombre" value={form.data.nombre} error={form.errors.nombre} onChange={(event) => form.setData('nombre', event.target.value)} />
                                <SelectField label="Tipo" value={form.data.tipo} error={form.errors.tipo} onChange={(value) => form.setData('tipo', value)} options={types.map((type) => ({ value: type, label: labelize(type) }))} />
                                <SelectField label="Proveedor" value={form.data.proveedor} error={form.errors.proveedor} onChange={(value) => form.setData('proveedor', value)} options={[{ value: none, label: 'Sin proveedor' }, ...providers.map((provider) => ({ value: provider, label: labelize(provider) }))]} />
                                <label className="mt-6 flex items-center gap-2 text-sm"><Checkbox checked={form.data.activo} onCheckedChange={(value) => form.setData('activo', Boolean(value))} /> Activa</label>
                                <div className="md:col-span-2"><FormTextareaField id="integration-description" label="Descripcion" value={form.data.descripcion} error={form.errors.descripcion} onChange={(event) => form.setData('descripcion', event.target.value)} /></div>
                                <div className="md:col-span-2">
                                    <FormTextareaField id="integration-config" label="Configuracion no sensible JSON" value={form.data.config_json} error={form.errors.config_json} onChange={(event) => form.setData('config_json', event.target.value)} />
                                    <p className="mt-1 text-xs text-muted-foreground">No incluyas tokens, passwords, secrets o credenciales. Las claves sensibles se ignoran en backend.</p>
                                </div>
                            </div>
                            <div className="flex justify-end gap-2">
                                <Button asChild variant="outline"><Link href={integration ? route('integrations.show', integration.id) : route('integrations.index')}>Cancelar</Link></Button>
                                <LoadingSubmitButton processing={form.processing} label={integration ? 'Guardar integracion' : 'Crear integracion'} />
                            </div>
                        </CardContent>
                    </Card>
                </form>
            </div>
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

function parseConfig(value: string) {
    try {
        const parsed = JSON.parse(value || '{}');
        return typeof parsed === 'object' && !Array.isArray(parsed) ? parsed : {};
    } catch {
        return {};
    }
}

const labelize = (value: string) => value.replaceAll('_', ' ');
