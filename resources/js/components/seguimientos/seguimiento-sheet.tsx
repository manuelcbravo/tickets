import { Plus } from 'lucide-react';
import { SeguimientoForm } from '@/components/seguimientos/seguimiento-form';
import { SeguimientosTable } from '@/components/seguimientos/seguimientos-table';
import type {
    Seguimiento,
    SeguimientoFormData,
    SeguimientoFormErrors,
    SeguimientoTipo,
} from '@/components/seguimientos/types';
import { Button } from '@/components/ui/button';
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetHeader,
    SheetTitle,
} from '@/components/ui/sheet';
import { Spinner } from '@/components/ui/spinner';

type SeguimientoSheetProps = {
    open: boolean;
    onOpenChange: (open: boolean) => void;
    idRelacion: string;
    tablaRelacion: string;
    items: Seguimiento[];
    tipos: SeguimientoTipo[];
    loading: boolean;
    processing: boolean;
    deletingId: number | null;
    formMode: 'create' | 'edit';
    showForm: boolean;
    formData: SeguimientoFormData;
    formErrors: SeguimientoFormErrors;
    onStartCreate: () => void;
    onFormChange: <K extends keyof SeguimientoFormData>(key: K, value: SeguimientoFormData[K]) => void;
    onSubmitForm: (event: React.FormEvent<HTMLFormElement>) => void;
    onCancelForm: () => void;
    onEdit: (item: Seguimiento) => void;
    onDelete: (item: Seguimiento) => void;
};

export function SeguimientoSheet({
    open,
    onOpenChange,
    idRelacion,
    tablaRelacion,
    items,
    tipos,
    loading,
    processing,
    deletingId,
    formMode,
    showForm,
    formData,
    formErrors,
    onStartCreate,
    onFormChange,
    onSubmitForm,
    onCancelForm,
    onEdit,
    onDelete,
}: SeguimientoSheetProps) {
    return (
        <Sheet open={open} onOpenChange={onOpenChange}>
            <SheetContent className="w-full overflow-y-auto sm:max-w-4xl">
                <SheetHeader>
                    <SheetTitle>Seguimientos</SheetTitle>
                    <SheetDescription />
                </SheetHeader>

                <div className="flex flex-col gap-4 p-4 pt-0 pb-8">
                    <div className="flex items-center justify-end gap-2">
                        <Button type="button" onClick={onStartCreate}>
                            <Plus className="mr-2 size-4" />
                            Nuevo seguimiento
                        </Button>
                    </div>

                    {showForm && (
                        <SeguimientoForm
                            mode={formMode}
                            data={formData}
                            errors={formErrors}
                            tipos={tipos}
                            processing={processing}
                            onChange={onFormChange}
                            onCancel={onCancelForm}
                            onSubmit={onSubmitForm}
                        />
                    )}

                    {loading ? (
                        <div className="flex items-center justify-center rounded-lg border p-10">
                            <Spinner className="size-5" />
                        </div>
                    ) : (
                        <SeguimientosTable
                            items={items}
                            deletingId={deletingId}
                            onEdit={onEdit}
                            onDelete={onDelete}
                        />
                    )}
                </div>
            </SheetContent>
        </Sheet>
    );
}
