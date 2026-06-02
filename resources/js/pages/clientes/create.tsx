import { Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';
import { ClienteForm } from './form';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Clientes', href: route('clientes.index') },
    { title: 'Nuevo cliente', href: route('clientes.create') },
];

export default function ClientesCreate({
    estatusOptions,
    clasificacionOptions,
}: {
    estatusOptions: string[];
    clasificacionOptions: string[];
}) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Nuevo cliente" />
            <div className="space-y-4 rounded-xl p-4">
                <Card className="rounded-lg">
                    <CardHeader>
                        <CardTitle>Nuevo cliente</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <ClienteForm
                            estatusOptions={estatusOptions}
                            clasificacionOptions={clasificacionOptions}
                            submitLabel="Guardar cliente"
                            submitUrl={route('clientes.store')}
                        />
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
