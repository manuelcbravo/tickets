import { ClipboardList } from 'lucide-react';
import { useEffect, useMemo, useState } from 'react';
import { toast } from 'sonner';
import { SeguimientoSheet } from '@/components/seguimientos/seguimiento-sheet';
import type {
    Seguimiento,
    SeguimientoFormData,
    SeguimientoFormErrors,
    SeguimientoTipo,
} from '@/components/seguimientos/types';
import { Button } from '@/components/ui/button';

type SeguimientosSectionProps = {
    idRelacion: string;
    tablaRelacion: string;
    open?: boolean;
    onOpenChange?: (open: boolean) => void;
    hideTrigger?: boolean;
};

const emptyForm = (): SeguimientoFormData => ({
    titulo: '',
    seguimiento: '',
    tipo_id: '',
    estado: '',
    prioridad: '',
    fecha_seguimiento: '',
    fecha_proxima_accion: '',
    resultado: '',
    observaciones: '',
});

const xsrfToken = () => {
    const cookie = document.cookie
        .split('; ')
        .find((row) => row.startsWith('XSRF-TOKEN='));

    if (!cookie) return '';

    return decodeURIComponent(cookie.split('=').slice(1).join('='));
};

const secureHeaders = (withJson: boolean) => {
    const xsrf = xsrfToken();

    return {
        Accept: 'application/json',
        ...(withJson ? { 'Content-Type': 'application/json' } : {}),
        'X-Requested-With': 'XMLHttpRequest',
        ...(xsrf ? { 'X-XSRF-TOKEN': xsrf } : {}),
    };
};

const authFetchOptions = {
    credentials: 'include' as const,
};

const toDateInput = (value: string | null) => {
    if (!value) return '';
    return value.slice(0, 10);
};

const parseValidationErrors = (payload: unknown): SeguimientoFormErrors => {
    if (
        typeof payload !== 'object' ||
        payload === null ||
        !('errors' in payload) ||
        typeof payload.errors !== 'object' ||
        payload.errors === null
    ) {
        return {};
    }

    const result: SeguimientoFormErrors = {};
    const allowedKeys: (keyof SeguimientoFormData)[] = [
        'titulo',
        'seguimiento',
        'tipo_id',
        'estado',
        'prioridad',
        'fecha_seguimiento',
        'fecha_proxima_accion',
        'resultado',
        'observaciones',
    ];

    for (const key of allowedKeys) {
        const raw = (payload.errors as Record<string, unknown>)[key];
        if (Array.isArray(raw) && raw.length > 0 && typeof raw[0] === 'string') {
            result[key] = raw[0];
        }
    }

    return result;
};

export function SeguimientosSection({
    idRelacion,
    tablaRelacion,
    open: controlledOpen,
    onOpenChange: controlledOnOpenChange,
    hideTrigger = false,
}: SeguimientosSectionProps) {
    const [internalOpen, setInternalOpen] = useState(false);
    const [loading, setLoading] = useState(false);
    const [processing, setProcessing] = useState(false);
    const [deletingId, setDeletingId] = useState<number | null>(null);
    const [items, setItems] = useState<Seguimiento[]>([]);
    const [tipos, setTipos] = useState<SeguimientoTipo[]>([]);
    const [formMode, setFormMode] = useState<'create' | 'edit'>('create');
    const [showForm, setShowForm] = useState(false);
    const [active, setActive] = useState<Seguimiento | null>(null);
    const [formData, setFormData] = useState<SeguimientoFormData>(emptyForm);
    const [formErrors, setFormErrors] = useState<SeguimientoFormErrors>({});

    const isControlled = controlledOpen !== undefined && controlledOnOpenChange !== undefined;
    const open = isControlled ? controlledOpen : internalOpen;
    const setOpen = isControlled ? controlledOnOpenChange : setInternalOpen;

    const baseParams = useMemo(
        () =>
            new URLSearchParams({
                id_relacion: idRelacion,
                tabla_relacion: tablaRelacion,
            }),
        [idRelacion, tablaRelacion],
    );

    const loadTipos = async () => {
        try {
            const response = await fetch('/seguimientos/tipos', {
                headers: { Accept: 'application/json' },
                ...authFetchOptions,
            });

            if (!response.ok) throw new Error('No se pudieron cargar los tipos.');

            const payload = (await response.json()) as { data?: SeguimientoTipo[] };
            setTipos(Array.isArray(payload.data) ? payload.data : []);
        } catch {
            toast.error('No se pudieron cargar los tipos de seguimiento.');
        }
    };

    const loadSeguimientos = async () => {
        setLoading(true);
        try {
            const response = await fetch(`/seguimientos?${baseParams.toString()}`, {
                headers: { Accept: 'application/json' },
                ...authFetchOptions,
            });

            if (!response.ok) throw new Error('No se pudieron cargar los seguimientos.');

            const payload = (await response.json()) as { data?: Seguimiento[] };
            setItems(Array.isArray(payload.data) ? payload.data : []);
        } catch {
            toast.error('No se pudieron cargar los seguimientos.');
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        if (!open) return;
        setShowForm(false);
        setActive(null);
        setFormMode('create');
        setFormErrors({});
        setFormData(emptyForm());
        void Promise.all([loadTipos(), loadSeguimientos()]);
    }, [open, baseParams]);

    const handleChange = <K extends keyof SeguimientoFormData>(
        key: K,
        value: SeguimientoFormData[K],
    ) => {
        setFormData((prev) => ({ ...prev, [key]: value }));
        setFormErrors((prev) => ({ ...prev, [key]: undefined }));
    };

    const startCreate = () => {
        setActive(null);
        setFormMode('create');
        setFormErrors({});
        setFormData(emptyForm());
        setShowForm(true);
    };

    const startEdit = (item: Seguimiento) => {
        setActive(item);
        setFormMode('edit');
        setFormErrors({});
        setShowForm(true);
        setFormData({
            titulo: item.titulo ?? '',
            seguimiento: item.seguimiento ?? '',
            tipo_id: item.tipo_id ? String(item.tipo_id) : '',
            estado: item.estado ?? '',
            prioridad: item.prioridad ?? '',
            fecha_seguimiento: toDateInput(item.fecha_seguimiento),
            fecha_proxima_accion: toDateInput(item.fecha_proxima_accion),
            resultado: item.resultado ?? '',
            observaciones: item.observaciones ?? '',
        });
    };

    const cancelForm = () => {
        setActive(null);
        setFormMode('create');
        setFormErrors({});
        setFormData(emptyForm());
        setShowForm(false);
    };

    const submitForm = async (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        setProcessing(true);
        setFormErrors({});

        try {
            const payload = {
                id_relacion: idRelacion,
                tabla_relacion: tablaRelacion,
                titulo: formData.titulo,
                seguimiento: formData.seguimiento,
                tipo_id: formData.tipo_id ? Number(formData.tipo_id) : null,
                estado: formData.estado || null,
                prioridad: formData.prioridad || null,
                fecha_seguimiento: formData.fecha_seguimiento || null,
                fecha_proxima_accion: formData.fecha_proxima_accion || null,
                resultado: formData.resultado || null,
                observaciones: formData.observaciones || null,
            };

            const endpoint =
                formMode === 'edit' && active
                    ? `/seguimientos/${active.id}`
                    : '/seguimientos';
            const method = formMode === 'edit' && active ? 'PUT' : 'POST';

            const response = await fetch(endpoint, {
                method,
                ...authFetchOptions,
                headers: secureHeaders(true),
                body: JSON.stringify(payload),
            });

            if (response.status === 422) {
                const validationPayload = await response.json();
                setFormErrors(parseValidationErrors(validationPayload));
                toast.error('Verifica los campos marcados.');
                return;
            }

            if (!response.ok) {
                throw new Error('No se pudo guardar el seguimiento.');
            }

            toast.success(
                formMode === 'edit'
                    ? 'Seguimiento actualizado correctamente.'
                    : 'Seguimiento creado correctamente.',
            );
            setActive(null);
            setFormMode('create');
            setFormErrors({});
            setFormData(emptyForm());
            setShowForm(false);
            await loadSeguimientos();
        } catch {
            toast.error('No se pudo guardar el seguimiento.');
        } finally {
            setProcessing(false);
        }
    };

    const remove = async (item: Seguimiento) => {
        const confirmed = window.confirm('Deseas eliminar este seguimiento?');
        if (!confirmed) return;

        setDeletingId(item.id);
        try {
            const params = new URLSearchParams(baseParams);

            const response = await fetch(`/seguimientos/${item.id}?${params.toString()}`, {
                method: 'DELETE',
                ...authFetchOptions,
                headers: secureHeaders(false),
            });

            if (!response.ok) {
                throw new Error('No se pudo eliminar el seguimiento.');
            }

            toast.success('Seguimiento eliminado correctamente.');

            if (active?.id === item.id) {
                setActive(null);
                setFormMode('create');
                setFormErrors({});
                setFormData(emptyForm());
                setShowForm(false);
            }

            await loadSeguimientos();
        } catch {
            toast.error('No se pudo eliminar el seguimiento.');
        } finally {
            setDeletingId(null);
        }
    };

    return (
        <>
            {!hideTrigger && (
                <Button type="button" variant="outline" onClick={() => setOpen(true)}>
                    <ClipboardList className="mr-2 size-4" />
                    Seguimientos
                </Button>
            )}

            <SeguimientoSheet
                open={open}
                onOpenChange={setOpen}
                idRelacion={idRelacion}
                tablaRelacion={tablaRelacion}
                items={items}
                tipos={tipos}
                loading={loading}
                processing={processing}
                deletingId={deletingId}
                formMode={formMode}
                showForm={showForm}
                formData={formData}
                formErrors={formErrors}
                onStartCreate={startCreate}
                onFormChange={handleChange}
                onSubmitForm={submitForm}
                onCancelForm={cancelForm}
                onEdit={startEdit}
                onDelete={remove}
            />
        </>
    );
}
