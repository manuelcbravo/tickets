import { Head, Link, router, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import { useEffect, useState } from 'react';
import { Eye, FileText, History, MoreHorizontal, Pencil, Plus, Rocket, Ticket, Trash2 } from 'lucide-react';
import { route } from 'ziggy-js';
import { ConfirmDeleteDialog } from '@/components/confirm-delete-dialog';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type ReleaseRow = {
    id: string;
    nombre: string;
    version: string | null;
    estado: string;
    scheduled_at: string | null;
    released_at: string | null;
    tickets_count: number;
    proyecto?: { nombre: string } | null;
    ambiente?: { nombre: string } | null;
};

type Paginated<T> = {
    data: T[];
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Desarrollo', href: route('development.releases.index') },
    { title: 'Releases', href: route('development.releases.index') },
];

export default function ReleasesIndex({ releases }: { releases: Paginated<ReleaseRow> }) {
    const { flash, auth } = usePage<SharedData>().props;
    const canManage = auth.permissions?.includes('development.releases.manage') ?? false;
    const [deleteTarget, setDeleteTarget] = useState<ReleaseRow | null>(null);

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Releases" />
            <div className="space-y-4 p-4">
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
                    <div className="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div className="flex items-center gap-3">
                            <Rocket className="size-5 text-primary" />
                            <div>
                                <h1 className="text-xl font-semibold">Releases</h1>
                                <p className="text-sm text-muted-foreground">Liberaciones registradas sin ejecutar deploys automaticos.</p>
                            </div>
                        </div>
                        {canManage && <Button asChild><Link href={route('development.releases.create')}><Plus className="size-4" /> Nuevo release</Link></Button>}
                    </div>
                </div>

                <Card className="rounded-lg">
                    <CardHeader>
                        <CardTitle>Listado</CardTitle>
                        <CardDescription>Releases por proyecto, ambiente y estado.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Nombre</TableHead>
                                    <TableHead>Version</TableHead>
                                    <TableHead>Proyecto</TableHead>
                                    <TableHead>Ambiente</TableHead>
                                    <TableHead>Estado</TableHead>
                                    <TableHead>Tickets</TableHead>
                                    <TableHead>Programado</TableHead>
                                    <TableHead>Liberado</TableHead>
                                    <TableHead>Acciones</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {releases.data.length === 0 ? (
                                    <TableRow><TableCell colSpan={9} className="text-muted-foreground">Sin releases registrados.</TableCell></TableRow>
                                ) : releases.data.map((release) => (
                                    <TableRow key={release.id}>
                                        <TableCell className="font-medium">{release.nombre}</TableCell>
                                        <TableCell>{release.version ?? '-'}</TableCell>
                                        <TableCell>{release.proyecto?.nombre ?? '-'}</TableCell>
                                        <TableCell>{release.ambiente?.nombre ?? '-'}</TableCell>
                                        <TableCell><Badge variant={release.estado === 'liberado' ? 'default' : 'secondary'}>{release.estado}</Badge></TableCell>
                                        <TableCell>{release.tickets_count}</TableCell>
                                        <TableCell>{formatDate(release.scheduled_at)}</TableCell>
                                        <TableCell>{formatDate(release.released_at)}</TableCell>
                                        <TableCell>
                                            <DropdownMenu>
                                                <DropdownMenuTrigger asChild>
                                                    <Button variant="ghost" size="icon" className="size-8">
                                                        <MoreHorizontal className="size-4" />
                                                    </Button>
                                                </DropdownMenuTrigger>
                                                <DropdownMenuContent align="end">
                                                    <DropdownMenuItem asChild><Link href={route('development.releases.show', release.id)}><Eye className="mr-2 size-4" /> Ver</Link></DropdownMenuItem>
                                                    {canManage && <DropdownMenuItem asChild><Link href={route('development.releases.edit', release.id)}><Pencil className="mr-2 size-4" /> Editar</Link></DropdownMenuItem>}
                                                    <DropdownMenuSeparator />
                                                    <DropdownMenuItem asChild><Link href={route('development.releases.show', release.id)}><Ticket className="mr-2 size-4" /> Tickets incluidos</Link></DropdownMenuItem>
                                                    <DropdownMenuItem asChild><Link href={route('development.releases.show', release.id)}><FileText className="mr-2 size-4" /> Notas de release</Link></DropdownMenuItem>
                                                    <DropdownMenuItem asChild><Link href={route('development.releases.show', release.id)}><History className="mr-2 size-4" /> Historial</Link></DropdownMenuItem>
                                                    {canManage && release.estado !== 'liberado' && <DropdownMenuItem onClick={() => router.patch(route('development.releases.publish', release.id), {}, { preserveScroll: true })}><Rocket className="mr-2 size-4" /> Publicar</DropdownMenuItem>}
                                                    {canManage && <><DropdownMenuSeparator /><DropdownMenuItem variant="destructive" onClick={() => setDeleteTarget(release)}><Trash2 className="mr-2 size-4" /> Eliminar</DropdownMenuItem></>}
                                                </DropdownMenuContent>
                                            </DropdownMenu>
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>
            </div>

            <ConfirmDeleteDialog
                open={deleteTarget !== null}
                onOpenChange={(open) => !open && setDeleteTarget(null)}
                title="Eliminar release"
                entityLabel="el release"
                itemName={deleteTarget?.nombre}
                onConfirm={() => {
                    if (!deleteTarget) return;
                    router.delete(route('development.releases.destroy', deleteTarget.id), {
                        onSuccess: () => setDeleteTarget(null),
                    });
                }}
            />
        </AppLayout>
    );
}

function formatDate(value?: string | null) {
    return value ? new Date(value).toLocaleDateString('es-MX') : '-';
}
