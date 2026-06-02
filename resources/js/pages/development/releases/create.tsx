import { Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';
import { ReleaseForm } from './form';

type ProjectOption = { id: string; nombre: string };
type EnvironmentOption = { id: string; project_id: string; nombre: string };

export default function ReleasesCreate({ projects, environments, statusOptions }: { projects: ProjectOption[]; environments: EnvironmentOption[]; statusOptions: string[] }) {
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Releases', href: route('development.releases.index') },
        { title: 'Nuevo release', href: route('development.releases.create') },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Nuevo release" />
            <div className="p-4">
                <ReleaseForm projects={projects} environments={environments} statusOptions={statusOptions} />
            </div>
        </AppLayout>
    );
}
