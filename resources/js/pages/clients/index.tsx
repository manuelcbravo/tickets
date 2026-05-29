import { Head, router, useForm, usePage } from '@inertiajs/react';
import {
    CircleCheck,
    CircleX,
    FolderKanban,
    MoreHorizontal,
    Pencil,
    Trash2,
    UserPlus,
    Users,
    ClipboardList
} from 'lucide-react';
import { useEffect, useMemo, useRef, useState } from 'react';
import { toast } from 'sonner';
import { route } from 'ziggy-js';
import { ConfirmDeleteDialog } from '@/components/confirm-delete-dialog';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { FilePickerDialog } from '@/components/file-picker-dialog';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';
import { ClientDialog, type ClientFormValues } from './components/client-dialog';
import { SeguimientosSection } from '@/components/seguimientos/seguimientos-section';

type ClientRow = {
    id: string;
    first_name: string;
    last_name: string;
    full_name: string;
    email: string | null;
    phone: string | null;
    is_active: boolean;
    avatar_url: string;
    avatar_path: string | null;
    created_at: string;
};

type MediaFile = {
    id: string;
    original_name: string;
    path: string;
    url: string;
    mime_type: string | null;
    size: number;
    related_table: string;
    related_uuid: string;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Clientes', href: route('clients.index') },
];

const FILES_TABLE_ID = 'clients';

export default function ClientsIndex({
    clients,
    files,
}: {
    clients: ClientRow[];
    files: MediaFile[];
}) {
    const [activeClient, setActiveClient] = useState<ClientRow | null>(null);
    const [formMode, setFormMode] = useState<'create' | 'edit' | null>(null);
    const [fileManagerClient, setFileManagerClient] = useState<ClientRow | null>(null);
    const [seguimientosClient, setSeguimientosClient] = useState<ClientRow | null>(null);
    const [uploadingFile] = useState(false);
    const avatarInputRef = useRef<HTMLInputElement>(null);
    const { flash } = usePage<SharedData>().props;

    const form = useForm<ClientFormValues>({
        id: null,
        first_name: '',
        last_name: '',
        email: '',
        phone: '',
        is_active: true,
        avatar: null,
        avatar_path: null,
    });

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const openCreateDialog = () => {
        setActiveClient(null);
        form.reset();
        form.clearErrors();
        setFormMode('create');
    };

    const openEditDialog = (client: ClientRow) => {
        setActiveClient(client);
        form.clearErrors();
        form.setData({
            id: client.id,
            first_name: client.first_name,
            last_name: client.last_name,
            email: client.email ?? '',
            phone: client.phone ?? '',
            is_active: client.is_active,
            avatar: null,
            avatar_path: client.avatar_path,
        });
        setFormMode('edit');
    };

    const submitForm = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        form.post(route('clients.store'), {
            forceFormData: true,
            onSuccess: () => {
                setFormMode(null);
                setActiveClient(null);
                form.reset();
            },
            onError: () => toast.error('Verifica los campos marcados.'),
        });
    };

    const localAvatarPreview = useMemo(() => {
        if (!form.data.avatar) return null;

        return URL.createObjectURL(form.data.avatar);
    }, [form.data.avatar]);

    useEffect(() => {
        return () => {
            if (localAvatarPreview?.startsWith('blob:')) {
                URL.revokeObjectURL(localAvatarPreview);
            }
        };
    }, [localAvatarPreview]);

    const contextualFiles = useMemo(() => {
        if (!fileManagerClient) return [];

        return files.filter(
            (file) => file.related_table === FILES_TABLE_ID && file.related_uuid === fileManagerClient.id,
        );
    }, [fileManagerClient, files]);

    const columns: DataTableColumn<ClientRow>[] = [
        {
            key: 'full_name',
            header: 'Cliente',
            accessor: (row) => row.full_name,
            cell: (row) => (
                <div className="flex items-center gap-3">
                    <Avatar className="size-9 border">
                        <AvatarImage src={row.avatar_url} alt={row.full_name} />
                        <AvatarFallback>
                            {row.first_name.charAt(0)}
                            {row.last_name.charAt(0)}
                        </AvatarFallback>
                    </Avatar>
                    <div>
                        <p className="font-medium">{row.full_name}</p>
                        <p className="text-xs text-muted-foreground">
                            Alta {new Date(row.created_at).toLocaleDateString('es-MX')}
                        </p>
                    </div>
                </div>
            ),
        },
        {
            key: 'email',
            header: 'Correo',
            cell: (row) => row.email ?? '—',
        },
        {
            key: 'phone',
            header: 'Teléfono',
            cell: (row) => row.phone ?? '—',
        },
        {
            key: 'is_active',
            header: 'Estado',
            cell: (row) =>
                row.is_active ? (
                    <Badge className="gap-1" variant="secondary">
                        <CircleCheck className="size-3" /> Activo
                    </Badge>
                ) : (
                    <Badge className="gap-1" variant="outline">
                        <CircleX className="size-3" /> Inactivo
                    </Badge>
                ),
        },
        {
            key: 'actions',
            header: '',
            className: 'w-14',
            cell: (row) => (
                <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                        <Button variant="ghost" size="icon" className="size-8">
                            <MoreHorizontal className="size-4" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuItem onClick={() => openEditDialog(row)}>
                            <Pencil className="mr-2 size-4" /> Editar
                        </DropdownMenuItem>
                        <DropdownMenuItem onClick={() => setFileManagerClient(row)}>
                            <FolderKanban className="mr-2 size-4" /> Files
                        </DropdownMenuItem>
                        <DropdownMenuItem onClick={() => setSeguimientosClient(row)}>
                            <ClipboardList className="mr-2 size-4" /> Seguimientos
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem
                            variant="destructive"
                            onClick={() => setActiveClient(row)}
                        >
                            <Trash2 className="mr-2 size-4" /> Eliminar
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            ),
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Clientes" />

            <div className="space-y-4 rounded-xl p-4">
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
                    <div className="flex items-center justify-between gap-3">
                        <div className="flex items-center gap-3">
                            <Users className="size-5 text-primary" />
                            <div>
                                <h1 className="text-xl font-semibold">Clientes</h1>
                                <p className="text-sm text-muted-foreground">
                                    Gestiona clientes y abre el gestor de archivos desde las opciones de cada cliente.
                                </p>
                            </div>
                        </div>
                        <Button onClick={openCreateDialog}>
                            <UserPlus className="mr-2 size-4" /> Nuevo cliente
                        </Button>
                    </div>
                </div>

                <DataTable
                    columns={columns}
                    data={clients}
                    searchColumn="full_name"
                    searchPlaceholder="Buscar cliente por nombre..."
                />
            </div>

            <ClientDialog
                open={formMode !== null}
                formMode={formMode}
                activeClient={activeClient}
                localAvatarPreview={localAvatarPreview}
                avatarInputRef={avatarInputRef}
                form={form}
                onOpenChange={(open) => {
                    if (!open) {
                        setFormMode(null);
                        setActiveClient(null);
                        form.clearErrors();
                    }
                }}
                onSubmit={submitForm}
            />
            <FilePickerDialog
                key={fileManagerClient?.id ?? 'files-manager'}
                open={fileManagerClient !== null}
                onOpenChange={(open) => {
                    if (!open) setFileManagerClient(null);
                }}
                title={fileManagerClient ? `Files · ${fileManagerClient.full_name}` : 'Files'}
                description="Gestiona solo los archivos del cliente activo (subir, descargar o eliminar) para evitar cruces entre registros."
                storedFiles={contextualFiles}
                tableId={FILES_TABLE_ID}
                relatedUuid={fileManagerClient?.id ?? null}
                onDeleteStoredFile={(fileId) => {
                    if (!fileManagerClient) return;

                    router.delete(route('files.destroy', fileId), {
                        preserveScroll: true,
                        data: {
                            related_table: FILES_TABLE_ID,
                            related_uuid: fileManagerClient.id,
                        },
                        onError: () => toast.error('No se pudo eliminar el archivo.'),
                    });
                }}
                onDownloadStoredFile={(file) => {
                    window.open(file.url, '_blank', 'noopener,noreferrer');
                }}
                accept="*/*"
                maxSizeHint="Cualquier formato · máximo 10MB"
                uploading={uploadingFile}
            />

            {seguimientosClient && (
                <SeguimientosSection
                    idRelacion={String(seguimientosClient.id)}
                    tablaRelacion="clients"
                    open={seguimientosClient !== null}
                    onOpenChange={(open) => {
                        if (!open) setSeguimientosClient(null);
                    }}
                    hideTrigger
                />
            )}

            <ConfirmDeleteDialog
                open={formMode === null && activeClient !== null}
                onOpenChange={(open) => !open && setActiveClient(null)}
                title="Eliminar cliente"
                entityLabel="el registro de"
                itemName={activeClient?.full_name}
                onConfirm={() => {
                    if (!activeClient) return;

                    router.delete(route('clients.destroy', activeClient.id), {
                        onSuccess: () => setActiveClient(null),
                        onError: () => toast.error('No se pudo eliminar el cliente.'),
                    });
                }}
            />
        </AppLayout>
    );
}
