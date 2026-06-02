import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import type React from 'react';
import { MoreHorizontal, Pencil, Plus, Trash2 } from 'lucide-react';
import { useEffect, useState } from 'react';
import { toast } from 'sonner';
import { route } from 'ziggy-js';
import { ConfirmDeleteDialog } from '@/components/confirm-delete-dialog';
import { CrudFormDialog } from '@/components/crud-form-dialog';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { ModuleHeader } from '@/components/module-header';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type Proyecto = { id: string; nombre: string };
type Modulo = { id: string; nombre: string; descripcion: string | null; orden: number; activo: boolean };
type ModuloForm = { nombre: string; descripcion: string; orden: number; activo: boolean };

const defaults: ModuloForm = { nombre: '', descripcion: '', orden: 0, activo: true };

export default function ProjectModulosIndex({ proyecto, modulos }: { proyecto: Proyecto; modulos: Modulo[] }) {
    const { flash } = usePage<SharedData>().props;
    const [editing, setEditing] = useState<Modulo | null>(null);
    const [open, setOpen] = useState(false);
    const [deleteTarget, setDeleteTarget] = useState<Modulo | null>(null);
    const form = useForm<ModuloForm>(defaults);
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Proyectos', href: route('proyectos.index') },
        { title: proyecto.nombre, href: route('proyectos.show', proyecto.id) },
        { title: 'Modulos', href: route('proyectos.modulos.index', proyecto.id) },
    ];

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const openCreate = () => {
        setEditing(null);
        form.setData(defaults);
        form.clearErrors();
        setOpen(true);
    };

    const openEdit = (modulo: Modulo) => {
        setEditing(modulo);
        form.setData({
            nombre: modulo.nombre,
            descripcion: modulo.descripcion ?? '',
            orden: modulo.orden,
            activo: modulo.activo,
        });
        form.clearErrors();
        setOpen(true);
    };

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        if (editing) {
            form.patch(route('proyectos.modulos.update', [proyecto.id, editing.id]), { preserveScroll: true, onSuccess: () => setOpen(false) });
            return;
        }
        form.post(route('proyectos.modulos.store', proyecto.id), { preserveScroll: true, onSuccess: () => setOpen(false) });
    };

    const columns: DataTableColumn<Modulo>[] = [
        { key: 'nombre', header: 'Nombre', accessor: (row) => row.nombre, cell: (row) => <span className="font-medium">{row.nombre}</span> },
        { key: 'descripcion', header: 'Descripcion', cell: (row) => row.descripcion ?? '-' },
        { key: 'orden', header: 'Orden', cell: (row) => row.orden },
        { key: 'activo', header: 'Estado', cell: (row) => <Badge variant={row.activo ? 'secondary' : 'outline'}>{row.activo ? 'Activo' : 'Inactivo'}</Badge> },
        {
            key: 'actions',
            header: 'Acciones',
            cell: (row) => (
                <DropdownMenu>
                    <DropdownMenuTrigger asChild><Button variant="ghost" size="icon" className="size-8"><MoreHorizontal className="size-4" /></Button></DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuItem onClick={() => openEdit(row)}><Pencil className="mr-2 size-4" /> Editar</DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem variant="destructive" onClick={() => setDeleteTarget(row)}><Trash2 className="mr-2 size-4" /> Eliminar</DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            ),
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Modulos - ${proyecto.nombre}`} />
            <div className="space-y-4 p-4">
                <ModuleHeader title="Modulos del proyecto" description="Modulos funcionales disponibles para clasificar tickets y alcance del proyecto.">
                    <Button asChild variant="outline"><Link href={route('proyectos.show', proyecto.id)}>Volver al resumen</Link></Button>
                    <Button onClick={openCreate}><Plus className="size-4" /> Agregar modulo</Button>
                </ModuleHeader>
                <Card className="rounded-lg"><CardHeader><CardTitle>Listado</CardTitle></CardHeader><CardContent><DataTable columns={columns} data={modulos} searchColumn="nombre" searchPlaceholder="Buscar modulo..." emptyMessage="Este proyecto aun no tiene modulos." /></CardContent></Card>
            </div>

            <CrudFormDialog open={open} onOpenChange={setOpen} title={editing ? 'Editar modulo' : 'Agregar modulo'} description="Administra modulos funcionales del proyecto." submitLabel="Guardar modulo" processing={form.processing} onSubmit={submit}>
                <FormInputField label="Nombre" value={form.data.nombre} onChange={(event) => form.setData('nombre', event.target.value)} error={form.errors.nombre} />
                <FormTextareaField label="Descripcion" value={form.data.descripcion} onChange={(event) => form.setData('descripcion', event.target.value)} error={form.errors.descripcion} />
                <FormInputField label="Orden" type="number" value={String(form.data.orden)} onChange={(event) => form.setData('orden', Number(event.target.value))} error={form.errors.orden} />
                <label className="flex items-center gap-2 text-sm"><Checkbox checked={form.data.activo} onCheckedChange={(value) => form.setData('activo', Boolean(value))} /> Activo</label>
            </CrudFormDialog>

            <ConfirmDeleteDialog open={deleteTarget !== null} onOpenChange={(value) => !value && setDeleteTarget(null)} title="Eliminar modulo" entityLabel="el modulo" itemName={deleteTarget?.nombre} onConfirm={() => deleteTarget && router.delete(route('proyectos.modulos.destroy', [proyecto.id, deleteTarget.id]), { preserveScroll: true, onSuccess: () => setDeleteTarget(null) })} />
        </AppLayout>
    );
}
