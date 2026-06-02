import { Head, router, useForm } from '@inertiajs/react';
import { MoreHorizontal, Pencil, Plus, Trash2 } from 'lucide-react';
import type React from 'react';
import { useState } from 'react';
import { route } from 'ziggy-js';
import { ConfirmDeleteDialog } from '@/components/confirm-delete-dialog';
import { CrudFormDialog } from '@/components/crud-form-dialog';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Field, FieldError } from '@/components/ui/field';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, KnowledgeCategory } from '@/types';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';

type CategoryForm = {
    nombre: string;
    descripcion: string;
    parent_id: string;
    proyecto_id: string;
    orden: string;
    activo: boolean;
};

const none = 'none';
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Base de conocimiento', href: route('knowledge.index') },
    { title: 'Categorias', href: route('knowledge.categories.index') },
];

export default function KnowledgeCategories({ categories, projects }: { categories: KnowledgeCategory[]; projects: Array<{ id: string; nombre: string }> }) {
    const [open, setOpen] = useState(false);
    const [editTarget, setEditTarget] = useState<KnowledgeCategory | null>(null);
    const [deleteTarget, setDeleteTarget] = useState<KnowledgeCategory | null>(null);
    const form = useForm<CategoryForm>({
        nombre: '',
        descripcion: '',
        parent_id: none,
        proyecto_id: none,
        orden: '0',
        activo: true,
    });

    const columns: DataTableColumn<KnowledgeCategory>[] = [
        { key: 'nombre', header: 'Nombre', cell: (row) => <span className="font-medium">{row.nombre}</span> },
        { key: 'parent', header: 'Padre', cell: (row) => row.parent?.nombre ?? '-' },
        { key: 'proyecto', header: 'Proyecto', cell: (row) => row.proyecto?.nombre ?? '-' },
        { key: 'articles', header: 'Articulos', cell: (row) => row.articles_count ?? 0 },
        { key: 'activo', header: 'Estado', cell: (row) => <Badge variant={row.activo ? 'default' : 'secondary'}>{row.activo ? 'Activa' : 'Inactiva'}</Badge> },
        {
            key: 'actions',
            header: 'Acciones',
            className: 'w-20',
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

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        form.transform((data) => ({
            ...data,
            parent_id: data.parent_id === none ? null : data.parent_id,
            proyecto_id: data.proyecto_id === none ? null : data.proyecto_id,
            orden: data.orden || '0',
        }));

        if (editTarget) {
            form.patch(route('knowledge.categories.update', editTarget.id), { preserveScroll: true, onSuccess: closeDialog });
            return;
        }

        form.post(route('knowledge.categories.store'), { preserveScroll: true, onSuccess: closeDialog });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Categorias de conocimiento" />
            <div className="space-y-4 rounded-xl p-4">
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
                    <div className="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h1 className="text-xl font-semibold">Categorias</h1>
                            <p className="text-sm text-muted-foreground">Organiza la base de conocimiento por jerarquia y proyecto.</p>
                        </div>
                        <Button onClick={openCreate}><Plus className="size-4" /> Nueva categoria</Button>
                    </div>
                </div>

                <DataTable columns={columns} data={categories} searchColumn="nombre" emptyMessage="No hay categorias." />
            </div>

            <CrudFormDialog open={open} onOpenChange={setOpen} title={editTarget ? 'Editar categoria' : 'Nueva categoria'} description="Define nombre, jerarquia y proyecto opcional." processing={form.processing} submitLabel={editTarget ? 'Actualizar' : 'Guardar'} onSubmit={submit}>
                <FormInputField id="category-name" label="Nombre" value={form.data.nombre} error={form.errors.nombre} onChange={(event) => form.setData('nombre', event.target.value)} />
                <FormTextareaField id="category-description" label="Descripcion" value={form.data.descripcion} error={form.errors.descripcion} onChange={(event) => form.setData('descripcion', event.target.value)} />
                <div className="grid gap-3 md:grid-cols-2">
                    <SelectField label="Categoria padre" value={form.data.parent_id} error={form.errors.parent_id} onChange={(value) => form.setData('parent_id', value)} options={[{ value: none, label: 'Sin padre' }, ...categories.filter((category) => category.id !== editTarget?.id).map((category) => ({ value: category.id, label: category.nombre }))]} />
                    <SelectField label="Proyecto" value={form.data.proyecto_id} error={form.errors.proyecto_id} onChange={(value) => form.setData('proyecto_id', value)} options={[{ value: none, label: 'Global' }, ...projects.map((project) => ({ value: project.id, label: project.nombre }))]} />
                    <FormInputField id="category-order" label="Orden" type="number" min="0" value={form.data.orden} error={form.errors.orden} onChange={(event) => form.setData('orden', event.target.value)} />
                    <label className="mt-6 flex items-center gap-2 text-sm"><Checkbox checked={form.data.activo} onCheckedChange={(value) => form.setData('activo', Boolean(value))} /> Activa</label>
                </div>
            </CrudFormDialog>

            <ConfirmDeleteDialog open={deleteTarget !== null} onOpenChange={(value) => !value && setDeleteTarget(null)} title="Eliminar categoria" entityLabel="la categoria" itemName={deleteTarget?.nombre} onConfirm={() => {
                if (!deleteTarget) return;
                router.delete(route('knowledge.categories.destroy', deleteTarget.id), { preserveScroll: true, onSuccess: () => setDeleteTarget(null) });
            }} />
        </AppLayout>
    );

    function openCreate() {
        setEditTarget(null);
        form.setData({ nombre: '', descripcion: '', parent_id: none, proyecto_id: none, orden: '0', activo: true });
        form.clearErrors();
        setOpen(true);
    }

    function openEdit(category: KnowledgeCategory) {
        setEditTarget(category);
        form.setData({
            nombre: category.nombre,
            descripcion: category.descripcion ?? '',
            parent_id: category.parent_id ?? none,
            proyecto_id: category.proyecto_id ?? none,
            orden: String(category.orden ?? 0),
            activo: category.activo ?? true,
        });
        form.clearErrors();
        setOpen(true);
    }

    function closeDialog() {
        setOpen(false);
        setEditTarget(null);
        form.reset();
    }
}

function SelectField({ label, value, options, error, onChange }: { label: string; value: string; options: { value: string; label: string }[]; error?: string; onChange: (value: string) => void }) {
    return (
        <Field>
            <Label>{label}</Label>
            <Select value={value} onValueChange={onChange}>
                <SelectTrigger className="w-full"><SelectValue placeholder={label} /></SelectTrigger>
                <SelectContent>{options.map((option) => <SelectItem key={option.value} value={option.value}>{option.label}</SelectItem>)}</SelectContent>
            </Select>
            {error && <FieldError>{error}</FieldError>}
        </Field>
    );
}
