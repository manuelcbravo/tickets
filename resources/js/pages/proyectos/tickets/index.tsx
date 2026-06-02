import { Head, Link } from '@inertiajs/react';
import { Eye } from 'lucide-react';
import { route } from 'ziggy-js';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { ModuleHeader } from '@/components/module-header';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';

type Proyecto = { id: string; nombre: string; cliente?: { nombre: string | null; razon_social: string | null } | null };
type TicketRow = {
    id: string;
    folio: string;
    titulo: string;
    created_at: string;
    cliente?: { nombre: string | null; razon_social: string | null } | null;
    estado?: { nombre: string } | null;
    prioridad?: { nombre: string } | null;
    responsable?: { name: string } | null;
};

export default function ProjectTicketsIndex({ proyecto, tickets }: { proyecto: Proyecto; tickets: TicketRow[] }) {
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Proyectos', href: route('proyectos.index') },
        { title: proyecto.nombre, href: route('proyectos.show', proyecto.id) },
        { title: 'Tickets', href: route('proyectos.tickets.index', proyecto.id) },
    ];

    const columns: DataTableColumn<TicketRow>[] = [
        { key: 'folio', header: 'Folio', accessor: (row) => row.folio, cell: (row) => <Link className="font-medium text-primary hover:underline" href={route('tickets.show', row.id)}>{row.folio}</Link> },
        { key: 'titulo', header: 'Titulo', accessor: (row) => row.titulo, cell: (row) => row.titulo },
        { key: 'estado', header: 'Estado', cell: (row) => <Badge variant="outline">{row.estado?.nombre ?? '-'}</Badge> },
        { key: 'prioridad', header: 'Prioridad', cell: (row) => <Badge variant={row.prioridad?.nombre?.startsWith('P0') ? 'destructive' : 'secondary'}>{row.prioridad?.nombre ?? '-'}</Badge> },
        { key: 'responsable', header: 'Responsable', cell: (row) => row.responsable?.name ?? '-' },
        { key: 'created', header: 'Creado', cell: (row) => date(row.created_at) },
        { key: 'actions', header: 'Acciones', cell: (row) => <Button asChild variant="ghost" size="sm"><Link href={route('tickets.show', row.id)}><Eye className="size-4" /> Ver</Link></Button> },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Tickets - ${proyecto.nombre}`} />
            <div className="space-y-4 p-4">
                <ModuleHeader title="Tickets del proyecto" description="Solicitudes, bugs, soporte y cambios relacionados al proyecto.">
                    <Button asChild variant="outline"><Link href={route('proyectos.show', proyecto.id)}>Volver al resumen</Link></Button>
                    <Button asChild><Link href={route('tickets.create')}>Nuevo ticket</Link></Button>
                </ModuleHeader>
                <Card className="rounded-lg">
                    <CardHeader><CardTitle>Listado de tickets</CardTitle></CardHeader>
                    <CardContent><DataTable columns={columns} data={tickets} searchColumn="titulo" searchPlaceholder="Buscar ticket..." emptyMessage="Este proyecto aun no tiene tickets." /></CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}

function date(value: string) {
    return new Intl.DateTimeFormat('es-MX', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true }).format(new Date(value));
}
