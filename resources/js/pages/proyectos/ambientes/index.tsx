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
import { Field, FieldError } from '@/components/ui/field';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type Proyecto = { id: string; nombre: string };
type Ambiente = { id: string; nombre: string; url: string | null; servidor: string | null; rama: string | null; notas: string | null; activo: boolean };
type AmbienteForm = { nombre: string; url: string; servidor: string; rama: string; notas: string; activo: boolean };

const defaults: AmbienteForm = { nombre: 'Produccion', url: '', servidor: '', rama: '', notas: '', activo: true };

export default function ProjectAmbientesIndex({ proyecto, ambientes, ambienteNombreOptions }: { proyecto: Proyecto; ambientes: Ambiente[]; ambienteNombreOptions: string[] }) {
    const { flash } = usePage<SharedData>().props;
    const [editing, setEditing] = useState<Ambiente | null>(null);
    const [open, setOpen] = useState(false);
    const [deleteTarget, setDeleteTarget] = useState<Ambiente | null>(null);
    const form = useForm<AmbienteForm>(defaults);
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Proyectos', href: route('proyectos.index') },
        { title: proyecto.nombre, href: route('proyectos.show', proyecto.id) },
        { title: 'Ambientes', href: route('proyectos.ambientes.index', proyecto.id) },
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

    const openEdit = (ambiente: Ambiente) => {
        setEditing(ambiente);
        form.setData({
            nombre: ambiente.nombre,
            url: ambiente.url ?? '',
            servidor: ambiente.servidor ?? '',
            rama: ambiente.rama ?? '',
            notas: ambiente.notas ?? '',
            activo: ambiente.activo,
        });
        form.clearErrors();
        setOpen(true);
    };

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        if (editing) {
            form.patch(route('proyectos.ambientes.update', [proyecto.id, editing.id]), { preserveScroll: true, onSuccess: () => setOpen(false) });
            return;
        }
        form.post(route('proyectos.ambientes.store', proyecto.id), { preserveScroll: true, onSuccess: () => setOpen(false) });
    };

    const columns: DataTableColumn<Ambiente>[] = [
        { key: 'nombre', header: 'Nombre', accessor: (row) => row.nombre, cell: (row) => <span className="font-medium">{row.nombre}</span> },
        { key: 'url', header: 'URL', cell: (row) => row.url ? <a className="text-primary hover:underline" href={row.url} target="_blank" rel="noreferrer">Abrir</a> : '-' },
        { key: 'servidor', header: 'Servidor', cell: (row) => row.servidor ?? '-' },
        { key: 'rama', header: 'Rama', cell: (row) => row.rama ?? '-' },
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
            <Head title={`Ambientes - ${proyecto.nombre}`} />
            <div className="space-y-4 p-4">
                <ModuleHeader title="Ambientes del proyecto" description="Produccion, staging, demos y otros ambientes tecnicos.">
                    <Button asChild variant="outline"><Link href={route('proyectos.show', proyecto.id)}>Volver al resumen</Link></Button>
                    <Button onClick={openCreate}><Plus className="size-4" /> Agregar ambiente</Button>
                </ModuleHeader>
                <Card className="rounded-lg"><CardHeader><CardTitle>Listado</CardTitle></CardHeader><CardContent><DataTable columns={columns} data={ambientes} searchColumn="nombre" searchPlaceholder="Buscar ambiente..." emptyMessage="Este proyecto aun no tiene ambientes." /></CardContent></Card>
            </div>

            <CrudFormDialog open={open} onOpenChange={setOpen} title={editing ? 'Editar ambiente' : 'Agregar ambiente'} description="Administra ambientes tecnicos del proyecto." submitLabel="Guardar ambiente" processing={form.processing} onSubmit={submit}>
                <Field>
                    <Label>Nombre</Label>
                    <Select value={form.data.nombre} onValueChange={(value) => form.setData('nombre', value)}>
                        <SelectTrigger><SelectValue /></SelectTrigger>
                        <SelectContent>{ambienteNombreOptions.map((option) => <SelectItem key={option} value={option}>{option}</SelectItem>)}</SelectContent>
                    </Select>
                    {form.errors.nombre && <FieldError>{form.errors.nombre}</FieldError>}
                </Field>
                <FormInputField label="URL" value={form.data.url} onChange={(event) => form.setData('url', event.target.value)} error={form.errors.url} />
                <FormInputField label="Servidor" value={form.data.servidor} onChange={(event) => form.setData('servidor', event.target.value)} error={form.errors.servidor} />
                <FormInputField label="Rama" value={form.data.rama} onChange={(event) => form.setData('rama', event.target.value)} error={form.errors.rama} />
                <FormTextareaField label="Notas" value={form.data.notas} onChange={(event) => form.setData('notas', event.target.value)} error={form.errors.notas} />
                <label className="flex items-center gap-2 text-sm"><Checkbox checked={form.data.activo} onCheckedChange={(value) => form.setData('activo', Boolean(value))} /> Activo</label>
            </CrudFormDialog>

            <ConfirmDeleteDialog open={deleteTarget !== null} onOpenChange={(value) => !value && setDeleteTarget(null)} title="Eliminar ambiente" entityLabel="el ambiente" itemName={deleteTarget?.nombre} onConfirm={() => deleteTarget && router.delete(route('proyectos.ambientes.destroy', [proyecto.id, deleteTarget.id]), { preserveScroll: true, onSuccess: () => setDeleteTarget(null) })} />
        </AppLayout>
    );
}
