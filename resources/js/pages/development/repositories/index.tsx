import { Head, Link, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import { useEffect } from 'react';
import { ExternalLink, FolderGit2 } from 'lucide-react';
import { route } from 'ziggy-js';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type RepositoryRow = {
    id: string;
    nombre: string;
    proveedor: string | null;
    url: string;
    rama_principal: string;
    activo: boolean;
    proyecto?: { id: string; nombre: string } | null;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Desarrollo', href: route('development.releases.index') },
    { title: 'Repositorios', href: route('development.repositories.index') },
];

export default function RepositoriesIndex({ repositories }: { repositories: RepositoryRow[] }) {
    const { flash } = usePage<SharedData>().props;

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Repositorios" />
            <div className="space-y-4 p-4">
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
                    <div className="flex items-center gap-3">
                        <FolderGit2 className="size-5 text-primary" />
                        <div>
                            <h1 className="text-xl font-semibold">Repositorios</h1>
                            <p className="text-sm text-muted-foreground">Vista global de repositorios registrados por proyecto.</p>
                        </div>
                    </div>
                </div>

                <Card className="rounded-lg">
                    <CardHeader>
                        <CardTitle>Repositorio por proyecto</CardTitle>
                        <CardDescription>La administracion principal vive dentro del detalle de cada proyecto.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader><TableRow><TableHead>Nombre</TableHead><TableHead>Proyecto</TableHead><TableHead>Proveedor</TableHead><TableHead>Rama</TableHead><TableHead>Estado</TableHead><TableHead>URL</TableHead></TableRow></TableHeader>
                            <TableBody>
                                {repositories.length === 0 ? (
                                    <TableRow><TableCell colSpan={6} className="text-muted-foreground">Sin repositorios registrados.</TableCell></TableRow>
                                ) : repositories.map((repository) => (
                                    <TableRow key={repository.id}>
                                        <TableCell className="font-medium">{repository.nombre}</TableCell>
                                        <TableCell>{repository.proyecto ? <Link className="text-primary hover:underline" href={route('proyectos.show', repository.proyecto.id)}>{repository.proyecto.nombre}</Link> : '-'}</TableCell>
                                        <TableCell>{repository.proveedor ?? '-'}</TableCell>
                                        <TableCell>{repository.rama_principal}</TableCell>
                                        <TableCell><Badge variant={repository.activo ? 'secondary' : 'outline'}>{repository.activo ? 'Activo' : 'Inactivo'}</Badge></TableCell>
                                        <TableCell><a className="inline-flex items-center gap-1 text-primary hover:underline" href={repository.url} target="_blank" rel="noreferrer">Abrir <ExternalLink className="size-3" /></a></TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
