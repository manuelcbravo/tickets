import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import type React from 'react';
import {
    BriefcaseBusiness,
    Mail,
    MoreHorizontal,
    Pencil,
    Phone,
    Plus,
    Trash2,
    UserRound,
    Users,
} from 'lucide-react';
import { useEffect, useState } from 'react';
import { toast } from 'sonner';
import { route } from 'ziggy-js';
import { ConfirmDeleteDialog } from '@/components/confirm-delete-dialog';
import { CrudFormDialog } from '@/components/crud-form-dialog';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Field, FieldError } from '@/components/ui/field';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type Cliente = {
    id: string;
    nombre: string | null;
    razon_social: string | null;
    rfc: string | null;
    email: string | null;
    phone: string | null;
    sitio_web: string | null;
    estatus: string | null;
    clasificacion: string | null;
    notas_internas: string | null;
};

type Contacto = {
    id: string;
    nombre: string;
    email: string | null;
    telefono: string | null;
    puesto: string | null;
    tipo_contacto: string;
    es_principal: boolean;
    recibe_notificaciones: boolean;
    notas: string | null;
};

type Proyecto = {
    id: string;
    nombre: string;
    estado: string;
    criticidad: string;
    responsable_tecnico?: { id: number; name: string } | null;
};

type ContactoForm = {
    nombre: string;
    email: string;
    telefono: string;
    puesto: string;
    tipo_contacto: string;
    es_principal: boolean;
    recibe_notificaciones: boolean;
    notas: string;
};

const defaultContacto: ContactoForm = {
    nombre: '',
    email: '',
    telefono: '',
    puesto: '',
    tipo_contacto: 'solicitante',
    es_principal: false,
    recibe_notificaciones: true,
    notas: '',
};

export default function ClientesShow({
    cliente,
    contactos,
    proyectos,
    contactoTipoOptions,
}: {
    cliente: Cliente;
    contactos: Contacto[];
    proyectos: Proyecto[];
    contactoTipoOptions: string[];
}) {
    const [contactoMode, setContactoMode] = useState<'create' | 'edit' | null>(null);
    const [activeContacto, setActiveContacto] = useState<Contacto | null>(null);
    const [deleteContacto, setDeleteContacto] = useState<Contacto | null>(null);
    const { flash, auth } = usePage<SharedData>().props;
    const canManage = auth.permissions?.includes('clientes.manage') ?? false;
    const canCreateProject = auth.permissions?.includes('proyectos.create') ?? false;
    const form = useForm<ContactoForm>(defaultContacto);

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Clientes', href: route('clientes.index') },
        { title: cliente.nombre ?? 'Cliente', href: route('clientes.show', cliente.id) },
    ];

    const openContactoCreate = () => {
        setActiveContacto(null);
        form.clearErrors();
        form.setData(defaultContacto);
        setContactoMode('create');
    };

    const openContactoEdit = (contacto: Contacto) => {
        setActiveContacto(contacto);
        form.clearErrors();
        form.setData({
            nombre: contacto.nombre,
            email: contacto.email ?? '',
            telefono: contacto.telefono ?? '',
            puesto: contacto.puesto ?? '',
            tipo_contacto: contacto.tipo_contacto,
            es_principal: contacto.es_principal,
            recibe_notificaciones: contacto.recibe_notificaciones,
            notas: contacto.notas ?? '',
        });
        setContactoMode('edit');
    };

    const submitContacto = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        const options = {
            preserveScroll: true,
            onSuccess: () => {
                setContactoMode(null);
                setActiveContacto(null);
                form.reset();
            },
            onError: () => toast.error('Verifica los campos del contacto.'),
        };

        if (contactoMode === 'edit' && activeContacto) {
            form.put(route('clientes.contactos.update', [cliente.id, activeContacto.id]), options);
            return;
        }

        form.post(route('clientes.contactos.store', cliente.id), options);
    };

    const contactoColumns: DataTableColumn<Contacto>[] = [
        {
            key: 'nombre',
            header: 'Nombre',
            accessor: (contacto) => contacto.nombre,
            cell: (contacto) => (
                <div className="space-y-1">
                    <div className="flex items-center gap-2">
                        <span className="font-medium">{contacto.nombre}</span>
                        {contacto.es_principal && <Badge variant="secondary">Principal</Badge>}
                    </div>
                    <p className="text-xs text-muted-foreground">{contacto.puesto ?? '-'}</p>
                </div>
            ),
        },
        { key: 'email', header: 'Email', accessor: (contacto) => contacto.email ?? '', cell: (contacto) => contacto.email ?? '-' },
        { key: 'telefono', header: 'Telefono', accessor: (contacto) => contacto.telefono ?? '', cell: (contacto) => contacto.telefono ?? '-' },
        { key: 'tipo_contacto', header: 'Tipo', accessor: (contacto) => contacto.tipo_contacto, cell: (contacto) => contacto.tipo_contacto },
        {
            key: 'notificaciones',
            header: 'Notifica',
            cell: (contacto) => contacto.recibe_notificaciones ? 'Si' : 'No',
        },
        {
            key: 'actions',
            header: 'Acciones',
            className: 'w-24',
            cell: (contacto) => canManage ? (
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <Button variant="ghost" size="icon" className="size-8">
                            <MoreHorizontal className="size-4" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuItem onClick={() => openContactoEdit(contacto)}>
                            <Pencil className="mr-2 size-4" /> Editar
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem variant="destructive" onClick={() => setDeleteContacto(contacto)}>
                            <Trash2 className="mr-2 size-4" /> Eliminar
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            ) : null,
        },
    ];

    const proyectoColumns: DataTableColumn<Proyecto>[] = [
        {
            key: 'nombre',
            header: 'Nombre',
            accessor: (proyecto) => proyecto.nombre,
            cell: (proyecto) => (
                <Link className="font-medium text-primary hover:underline" href={route('proyectos.show', proyecto.id)}>
                    {proyecto.nombre}
                </Link>
            ),
        },
        { key: 'estado', header: 'Estado', accessor: (proyecto) => proyecto.estado, cell: (proyecto) => <Badge variant="outline">{proyecto.estado}</Badge> },
        { key: 'criticidad', header: 'Criticidad', accessor: (proyecto) => proyecto.criticidad, cell: (proyecto) => proyecto.criticidad },
        { key: 'responsable', header: 'Responsable tecnico', cell: (proyecto) => proyecto.responsable_tecnico?.name ?? '-' },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={cliente.nombre ?? 'Cliente'} />

            <div className="space-y-4 rounded-xl p-4">
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
                    <div className="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div className="flex items-center gap-3">
                            <Users className="size-5 text-primary" />
                            <div>
                                <h1 className="text-xl font-semibold">{cliente.nombre}</h1>
                                <p className="text-sm text-muted-foreground">{cliente.razon_social ?? 'Sin razon social'}</p>
                            </div>
                        </div>
                        <div className="flex flex-wrap gap-2">
                            <Badge variant={cliente.estatus === 'moroso' || cliente.estatus === 'suspendido' ? 'destructive' : 'secondary'}>
                                {cliente.estatus ?? 'sin estatus'}
                            </Badge>
                            {cliente.clasificacion && <Badge variant="outline">{cliente.clasificacion}</Badge>}
                        </div>
                    </div>
                </div>

                <div className="grid gap-4 lg:grid-cols-3">
                    <Card className="rounded-lg lg:col-span-2">
                        <CardHeader>
                            <CardTitle>Informacion general</CardTitle>
                            <CardDescription>Datos base usados por tickets y proyectos.</CardDescription>
                        </CardHeader>
                        <CardContent className="grid gap-3 md:grid-cols-2">
                            <InfoItem icon={UserRound} label="RFC" value={cliente.rfc} />
                            <InfoItem icon={Mail} label="Email" value={cliente.email} />
                            <InfoItem icon={Phone} label="Telefono" value={cliente.phone} />
                            <InfoItem icon={BriefcaseBusiness} label="Sitio web" value={cliente.sitio_web} />
                        </CardContent>
                    </Card>

                    <Card className="rounded-lg">
                        <CardHeader>
                            <CardTitle>Notas internas</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <p className="text-sm text-muted-foreground">
                                {cliente.notas_internas || 'Sin notas internas registradas.'}
                            </p>
                        </CardContent>
                    </Card>
                </div>

                <Card className="rounded-lg">
                    <CardHeader className="flex flex-row items-center justify-between space-y-0">
                        <div>
                            <CardTitle>Contactos</CardTitle>
                            <CardDescription>Contactos solicitantes, aprobadores y tecnicos del cliente.</CardDescription>
                        </div>
                        {canManage && (
                            <Button onClick={openContactoCreate}>
                                <Plus className="size-4" /> Agregar contacto
                            </Button>
                        )}
                    </CardHeader>
                    <CardContent>
                        <DataTable
                            columns={contactoColumns}
                            data={contactos}
                            searchColumn="nombre"
                            searchPlaceholder="Buscar contacto..."
                            emptyMessage="Este cliente aun no tiene contactos."
                        />
                    </CardContent>
                </Card>

                <Card className="rounded-lg">
                    <CardHeader className="flex flex-row items-center justify-between space-y-0">
                        <div>
                            <CardTitle>Proyectos</CardTitle>
                            <CardDescription>Sistemas o productos asociados a este cliente.</CardDescription>
                        </div>
                        {canCreateProject && (
                            <Button asChild>
                                <Link href={route('proyectos.create')}>
                                    <Plus className="size-4" /> Agregar proyecto
                                </Link>
                            </Button>
                        )}
                    </CardHeader>
                    <CardContent>
                        <DataTable
                            columns={proyectoColumns}
                            data={proyectos}
                            searchColumn="nombre"
                            searchPlaceholder="Buscar proyecto..."
                            emptyMessage="Este cliente aun no tiene proyectos."
                        />
                    </CardContent>
                </Card>
            </div>

            <CrudFormDialog
                open={contactoMode !== null}
                onOpenChange={(open) => {
                    if (!open) {
                        setContactoMode(null);
                        setActiveContacto(null);
                        form.clearErrors();
                    }
                }}
                title={contactoMode === 'edit' ? 'Editar contacto' : 'Agregar contacto'}
                description="Administra contactos operativos del cliente."
                submitLabel={contactoMode === 'edit' ? 'Guardar cambios' : 'Guardar contacto'}
                processing={form.processing}
                onSubmit={submitContacto}
            >
                <div className="grid gap-4 md:grid-cols-2">
                    <FormInputField id="contacto-nombre" label="Nombre" value={form.data.nombre} error={form.errors.nombre} onChange={(event) => form.setData('nombre', event.target.value)} />
                    <FormInputField id="contacto-email" label="Email" type="email" value={form.data.email} error={form.errors.email} onChange={(event) => form.setData('email', event.target.value)} />
                    <FormInputField id="contacto-telefono" label="Telefono" value={form.data.telefono} error={form.errors.telefono} onChange={(event) => form.setData('telefono', event.target.value)} />
                    <FormInputField id="contacto-puesto" label="Puesto" value={form.data.puesto} error={form.errors.puesto} onChange={(event) => form.setData('puesto', event.target.value)} />
                    <Field>
                        <Label>Tipo de contacto</Label>
                        <Select value={form.data.tipo_contacto} onValueChange={(value) => form.setData('tipo_contacto', value)}>
                            <SelectTrigger className="w-full">
                                <SelectValue placeholder="Tipo" />
                            </SelectTrigger>
                            <SelectContent>
                                {contactoTipoOptions.map((option) => (
                                    <SelectItem key={option} value={option}>
                                        {option}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        {form.errors.tipo_contacto && <FieldError>{form.errors.tipo_contacto}</FieldError>}
                    </Field>
                    <div className="flex flex-col justify-end gap-3 rounded-md border p-3">
                        <label className="flex items-center gap-2 text-sm">
                            <Checkbox checked={form.data.es_principal} onCheckedChange={(checked) => form.setData('es_principal', Boolean(checked))} />
                            Contacto principal
                        </label>
                        <label className="flex items-center gap-2 text-sm">
                            <Checkbox checked={form.data.recibe_notificaciones} onCheckedChange={(checked) => form.setData('recibe_notificaciones', Boolean(checked))} />
                            Recibe notificaciones
                        </label>
                    </div>
                    <div className="md:col-span-2">
                        <FormTextareaField id="contacto-notas" label="Notas" value={form.data.notas} error={form.errors.notas} onChange={(event) => form.setData('notas', event.target.value)} />
                    </div>
                </div>
            </CrudFormDialog>

            <ConfirmDeleteDialog
                open={deleteContacto !== null}
                onOpenChange={(open) => !open && setDeleteContacto(null)}
                title="Eliminar contacto"
                entityLabel="el contacto"
                itemName={deleteContacto?.nombre}
                onConfirm={() => {
                    if (!deleteContacto) return;
                    router.delete(route('clientes.contactos.destroy', [cliente.id, deleteContacto.id]), {
                        preserveScroll: true,
                        onSuccess: () => setDeleteContacto(null),
                    });
                }}
            />
        </AppLayout>
    );
}

function InfoItem({
    icon: Icon,
    label,
    value,
}: {
    icon: React.ComponentType<{ className?: string }>;
    label: string;
    value?: string | null;
}) {
    return (
        <div className="flex items-start gap-3 rounded-md border p-3">
            <Icon className="mt-0.5 size-4 text-muted-foreground" />
            <div>
                <p className="text-xs text-muted-foreground">{label}</p>
                <p className="text-sm font-medium">{value || '-'}</p>
            </div>
        </div>
    );
}
