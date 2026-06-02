import { Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';
import { ReleaseForm } from './form';

type ProjectOption = { id: string; nombre: string };
type EnvironmentOption = { id: string; project_id: string; nombre: string };
type ReleaseModel = {
    id: string;
    proyecto_id: string;
    ambiente_id: string | null;
    nombre: string;
    version: string | null;
    descripcion: string | null;
    estado: string;
    release_notes: string | null;
    scheduled_at: string | null;
};

export default function ReleasesEdit({ release, projects, environments, statusOptions }: { release: ReleaseModel; projects: ProjectOption[]; environments: EnvironmentOption[]; statusOptions: string[] }) {
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Releases', href: route('development.releases.index') },
        { title: release.nombre, href: route('development.releases.show', release.id) },
        { title: 'Editar', href: route('development.releases.edit', release.id) },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Editar ${release.nombre}`} />
            <div className="p-4">
                <ReleaseForm release={release} projects={projects} environments={environments} statusOptions={statusOptions} />
            </div>
        </AppLayout>
    );
}
