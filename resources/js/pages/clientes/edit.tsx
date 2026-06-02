import { Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';
import { ClienteForm, type ClienteFormValues } from './form';

type Cliente = {
    id: string;
    nombre: string | null;
    razon_social: string | null;
    rfc: string | null;
    email: string | null;
    phone: string | null;
    sitio_web: string | null;
    estatus: string | null;
    clasificacion: string | null;
    notas_internas: string | null;
};

export default function ClientesEdit({
    cliente,
    estatusOptions,
    clasificacionOptions,
}: {
    cliente: Cliente;
    estatusOptions: string[];
    clasificacionOptions: string[];
}) {
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Clientes', href: route('clientes.index') },
        { title: cliente.nombre ?? 'Editar cliente', href: route('clientes.edit', cliente.id) },
    ];

    const initialValues: ClienteFormValues = {
        nombre: cliente.nombre ?? '',
        razon_social: cliente.razon_social ?? '',
        rfc: cliente.rfc ?? '',
        email: cliente.email ?? '',
        telefono: cliente.phone ?? '',
        sitio_web: cliente.sitio_web ?? '',
        estatus: cliente.estatus ?? 'activo',
        clasificacion: cliente.clasificacion ?? 'normal',
        notas_internas: cliente.notas_internas ?? '',
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Editar cliente" />
            <div className="space-y-4 rounded-xl p-4">
                <Card className="rounded-lg">
                    <CardHeader>
                        <CardTitle>Editar cliente</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <ClienteForm
                            initialValues={initialValues}
                            estatusOptions={estatusOptions}
                            clasificacionOptions={clasificacionOptions}
                            submitLabel="Guardar cambios"
                            submitUrl={route('clientes.update', cliente.id)}
                            method="put"
                        />
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
