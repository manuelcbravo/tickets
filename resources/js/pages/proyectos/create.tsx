import { Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';
import { ProyectoForm, type ClienteOption, type UserOption } from './form';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Proyectos', href: route('proyectos.index') },
    { title: 'Nuevo proyecto', href: route('proyectos.create') },
];

export default function ProyectosCreate({
    clientes,
    users,
    estadoOptions,
    criticidadOptions,
}: {
    clientes: ClienteOption[];
    users: UserOption[];
    estadoOptions: string[];
    criticidadOptions: string[];
}) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Nuevo proyecto" />
            <div className="space-y-4 rounded-xl p-4">
                <Card className="rounded-lg">
                    <CardHeader>
                        <CardTitle>Nuevo proyecto</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <ProyectoForm
                            clientes={clientes}
                            users={users}
                            estadoOptions={estadoOptions}
                            criticidadOptions={criticidadOptions}
                            submitLabel="Guardar proyecto"
                            submitUrl={route('proyectos.store')}
                        />
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
