import { Head, Link, router, usePage } from '@inertiajs/react';
import { Download, FileText, Trash2, UploadCloud } from 'lucide-react';
import { useEffect, useState } from 'react';
import { toast } from 'sonner';
import { route } from 'ziggy-js';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { FilePickerDialog } from '@/components/file-picker-dialog';
import { ModuleHeader } from '@/components/module-header';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type Proyecto = { id: string; nombre: string; cliente?: { nombre: string | null; razon_social: string | null } | null };
type ProjectFile = { id: string; original_name: string; path: string; url: string; mime_type: string | null; size: number; created_at: string };

export default function ProjectDocumentsIndex({ proyecto, documents }: { proyecto: Proyecto; documents: ProjectFile[] }) {
    const { flash, auth } = usePage<SharedData>().props;
    const [open, setOpen] = useState(false);
    const canManage = auth.permissions?.includes('project-planning.documents.manage') ?? false;
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Proyectos', href: route('proyectos.index') },
        { title: proyecto.nombre, href: route('proyectos.show', proyecto.id) },
        { title: 'Documentos', href: route('proyectos.documents.index', proyecto.id) },
    ];

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const columns: DataTableColumn<ProjectFile>[] = [
        { key: 'name', header: 'Archivo', accessor: (file) => file.original_name, cell: (file) => <span className="font-medium">{file.original_name}</span> },
        { key: 'type', header: 'Tipo', cell: (file) => file.mime_type ?? '-' },
        { key: 'size', header: 'Tamano', cell: (file) => `${Math.round(file.size / 1024)} KB` },
        { key: 'created', header: 'Creado', cell: (file) => date(file.created_at) },
        {
            key: 'actions',
            header: 'Acciones',
            cell: (file) => (
                <div className="flex gap-1">
                    <Button asChild variant="ghost" size="icon"><a href={file.url} target="_blank" rel="noreferrer"><Download className="size-4" /></a></Button>
                    {canManage && <Button variant="ghost" size="icon" onClick={() => router.delete(route('files.destroy', file.id), { data: { related_table: 'projects', related_uuid: proyecto.id }, preserveScroll: true })}><Trash2 className="size-4" /></Button>}
                </div>
            ),
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Documentos - ${proyecto.nombre}`} />
            <div className="space-y-4 p-4">
                <ModuleHeader title="Documentos del proyecto" description="Contratos, requerimientos, manuales y documentacion tecnica asociados al proyecto.">
                    <Button asChild variant="outline"><Link href={route('proyectos.show', proyecto.id)}>Volver al resumen</Link></Button>
                    {canManage && <Button onClick={() => setOpen(true)}><UploadCloud className="size-4" /> Subir documento</Button>}
                </ModuleHeader>

                <Card className="rounded-lg">
                    <CardHeader><CardTitle className="flex items-center gap-2"><FileText className="size-5" /> Archivos</CardTitle></CardHeader>
                    <CardContent><DataTable columns={columns} data={documents} searchColumn="name" searchPlaceholder="Buscar documento..." emptyMessage="Este proyecto aun no tiene documentos." /></CardContent>
                </Card>
            </div>

            <FilePickerDialog
                open={open}
                onOpenChange={setOpen}
                title="Archivos del proyecto"
                description={proyecto.nombre}
                storedFiles={documents}
                tableId="projects"
                relatedUuid={proyecto.id}
                accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx,.xls,.xlsx,.txt,.csv,.zip"
                maxSizeHint="Maximo 10MB"
                onDownloadStoredFile={(file) => window.open(file.url, '_blank', 'noopener,noreferrer')}
                onDeleteStoredFile={(fileId) => router.delete(route('files.destroy', fileId), { data: { related_table: 'projects', related_uuid: proyecto.id }, preserveScroll: true })}
            />
        </AppLayout>
    );
}

function date(value: string) {
    return new Intl.DateTimeFormat('es-MX', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true }).format(new Date(value));
}
