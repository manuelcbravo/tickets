import type { InertiaFormProps } from '@inertiajs/react';
import { ImagePlus } from 'lucide-react';
import type { FormEvent, RefObject } from 'react';
import { CrudFormDialog } from '@/components/crud-form-dialog';
import { FormInputField } from '@/components/form-input-field';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Field, FieldError } from '@/components/ui/field';
import { Label } from '@/components/ui/label';

export type ClientFormValues = {
    id: string | null;
    first_name: string;
    last_name: string;
    email: string;
    phone: string;
    is_active: boolean;
    avatar: File | null;
    avatar_path: string | null;
};

type ClientDialogProps = {
    open: boolean;
    formMode: 'create' | 'edit' | null;
    activeClient: { avatar_url: string } | null;
    localAvatarPreview: string | null;
    avatarInputRef: RefObject<HTMLInputElement | null>;
    form: InertiaFormProps<ClientFormValues>;
    onOpenChange: (open: boolean) => void;
    onSubmit: (event: FormEvent<HTMLFormElement>) => void;
};

export function ClientDialog({
    open,
    formMode,
    activeClient,
    localAvatarPreview,
    avatarInputRef,
    form,
    onOpenChange,
    onSubmit,
}: ClientDialogProps) {
    return (
        <CrudFormDialog
            open={open}
            onOpenChange={onOpenChange}
            title={formMode === 'edit' ? 'Editar cliente' : 'Nuevo cliente'}
            description="Captura datos esenciales y guarda el cliente directamente desde este modal."
            submitLabel={formMode === 'edit' ? 'Guardar cambios' : 'Guardar cliente'}
            processing={form.processing}
            onSubmit={onSubmit}
        >
            <Field>
                <Label>Imagen de perfil</Label>
                <div className="flex items-center gap-3">
                    <Avatar className="size-16 border">
                        <AvatarImage src={localAvatarPreview ?? activeClient?.avatar_url} alt="Preview" />
                        <AvatarFallback>
                            <ImagePlus className="size-4" />
                        </AvatarFallback>
                    </Avatar>
                    <div className="space-x-2">
                        <input
                            id="client-avatar-input"
                            ref={avatarInputRef}
                            type="file"
                            accept="image/*"
                            className="hidden"
                            onChange={(event) => {
                                form.setData('avatar', event.target.files?.[0] ?? null);
                                form.setData('avatar_path', null);
                            }}
                        />
                        <Button type="button" variant="outline" onClick={() => avatarInputRef.current?.click()}>
                            Seleccionar imagen
                        </Button>
                        {(form.data.avatar || form.data.avatar_path) && (
                            <Button
                                type="button"
                                variant="ghost"
                                onClick={() => {
                                    form.setData('avatar', null);
                                    form.setData('avatar_path', null);
                                }}
                            >
                                Quitar
                            </Button>
                        )}
                    </div>
                </div>
                <p className="mt-2 text-xs text-muted-foreground">
                    La imagen se guarda directamente al guardar el cliente.
                </p>
                {form.errors.avatar && <FieldError>{form.errors.avatar}</FieldError>}
                {form.errors.avatar_path && <FieldError>{form.errors.avatar_path}</FieldError>}
            </Field>
            <div className="grid gap-4 md:grid-cols-2">
                <FormInputField
                    id="client-first-name"
                    label="Nombre"
                    value={form.data.first_name}
                    onChange={(event) => form.setData('first_name', event.target.value)}
                    placeholder="Ej. Camila"
                    error={form.errors.first_name}
                />

                <FormInputField
                    id="client-last-name"
                    label="Apellido"
                    value={form.data.last_name}
                    onChange={(event) => form.setData('last_name', event.target.value)}
                    placeholder="Ej. Salinas"
                    error={form.errors.last_name}
                />
            </div>

            <div className="grid gap-4 md:grid-cols-2">
                <FormInputField
                    id="client-email"
                    type="email"
                    label="Correo"
                    value={form.data.email}
                    onChange={(event) => form.setData('email', event.target.value)}
                    placeholder="cliente@email.com"
                    error={form.errors.email}
                />

                <FormInputField
                    id="client-phone"
                    label="Telefono"
                    value={form.data.phone}
                    onChange={(event) => form.setData('phone', event.target.value)}
                    placeholder="55 1234 5678"
                    error={form.errors.phone}
                />
            </div>

            <Field>
                <Label htmlFor="client-active">Estado</Label>
                <select
                    id="client-active"
                    className="h-10 w-full rounded-md border border-input bg-background px-3 text-sm"
                    value={form.data.is_active ? '1' : '0'}
                    onChange={(event) => form.setData('is_active', event.target.value === '1')}
                >
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
                {form.errors.is_active && <FieldError>{form.errors.is_active}</FieldError>}
            </Field>
        </CrudFormDialog>
    );
}
