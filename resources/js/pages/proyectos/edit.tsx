import { Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';
import { ProyectoForm, type ClienteOption, type ProyectoFormValues, type UserOption } from './form';

type Proyecto = {
    id: string;
    client_id: string;
    nombre: string;
    descripcion: string | null;
    url_produccion: string | null;
    url_staging: string | null;
    repositorio_url: string | null;
    documentacion_url: string | null;
    tecnologia: string | null;
    responsable_tecnico_id: number | null;
    estado: string;
    criticidad: string;
    notas_internas: string | null;
};

export default function ProyectosEdit({
    proyecto,
    clientes,
    users,
    estadoOptions,
    criticidadOptions,
}: {
    proyecto: Proyecto;
    clientes: ClienteOption[];
    users: UserOption[];
    estadoOptions: string[];
    criticidadOptions: string[];
}) {
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Proyectos', href: route('proyectos.index') },
        { title: proyecto.nombre, href: route('proyectos.edit', proyecto.id) },
    ];

    const initialValues: ProyectoFormValues = {
        client_id: proyecto.client_id,
        nombre: proyecto.nombre,
        descripcion: proyecto.descripcion ?? '',
        url_produccion: proyecto.url_produccion ?? '',
        url_staging: proyecto.url_staging ?? '',
        repositorio_url: proyecto.repositorio_url ?? '',
        documentacion_url: proyecto.documentacion_url ?? '',
        tecnologia: proyecto.tecnologia ?? '',
        responsable_tecnico_id: proyecto.responsable_tecnico_id ? String(proyecto.responsable_tecnico_id) : 'sin_responsable',
        estado: proyecto.estado,
        criticidad: proyecto.criticidad,
        notas_internas: proyecto.notas_internas ?? '',
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Editar proyecto" />
            <div className="space-y-4 rounded-xl p-4">
                <Card className="rounded-lg">
                    <CardHeader>
                        <CardTitle>Editar proyecto</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <ProyectoForm
                            initialValues={initialValues}
                            clientes={clientes}
                            users={users}
                            estadoOptions={estadoOptions}
                            criticidadOptions={criticidadOptions}
                            submitLabel="Guardar cambios"
                            submitUrl={route('proyectos.update', proyecto.id)}
                            method="put"
                        />
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
