import { FormTextareaField } from '@/components/form-textarea-field';
import { LoadingSubmitButton } from '@/components/loading-submit-button';
import {
    SEGUIMIENTO_ESTADO_OPTIONS,
    SEGUIMIENTO_PRIORIDAD_OPTIONS,
} from '@/components/seguimientos/options';
import type {
    SeguimientoFormData,
    SeguimientoFormErrors,
    SeguimientoTipo,
} from '@/components/seguimientos/types';
import { Button } from '@/components/ui/button';
import { Field, FieldError } from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';

type SeguimientoFormProps = {
    mode: 'create' | 'edit';
    data: SeguimientoFormData;
    errors: SeguimientoFormErrors;
    tipos: SeguimientoTipo[];
    processing: boolean;
    onChange: <K extends keyof SeguimientoFormData>(key: K, value: SeguimientoFormData[K]) => void;
    onCancel: () => void;
    onSubmit: (event: React.FormEvent<HTMLFormElement>) => void;
};

export function SeguimientoForm({
    mode,
    data,
    errors,
    tipos,
    processing,
    onChange,
    onCancel,
    onSubmit,
}: SeguimientoFormProps) {
    return (
        <form onSubmit={onSubmit} className="space-y-4 rounded-lg border p-4">
            <div className="grid gap-4 md:grid-cols-2">
                <Field>
                    <Label htmlFor="seguimiento-titulo">Titulo</Label>
                    <Input
                        id="seguimiento-titulo"
                        value={data.titulo}
                        onChange={(event) => onChange('titulo', event.target.value)}
                        aria-invalid={Boolean(errors.titulo)}
                    />
                    {errors.titulo && <FieldError>{errors.titulo}</FieldError>}
                </Field>

                <Field>
                    <Label htmlFor="seguimiento-tipo">Tipo</Label>
                    <Select
                        value={data.tipo_id}
                        onValueChange={(value) => onChange('tipo_id', value)}
                    >
                        <SelectTrigger id="seguimiento-tipo" aria-invalid={Boolean(errors.tipo_id)}>
                            <SelectValue placeholder="Selecciona tipo" />
                        </SelectTrigger>
                        <SelectContent>
                            {tipos.map((tipo) => (
                                <SelectItem key={tipo.id} value={String(tipo.id)}>
                                    {tipo.nombre}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    {errors.tipo_id && <FieldError>{errors.tipo_id}</FieldError>}
                </Field>
            </div>

            <FormTextareaField
                id="seguimiento-detalle"
                label="Seguimiento"
                value={data.seguimiento}
                onChange={(event) => onChange('seguimiento', event.target.value)}
                rows={4}
                error={errors.seguimiento}
            />

            <div className="grid gap-4 md:grid-cols-3">
                <Field>
                    <Label htmlFor="seguimiento-estado">Estado</Label>
                    <Select
                        value={data.estado}
                        onValueChange={(value) => onChange('estado', value)}
                    >
                        <SelectTrigger
                            id="seguimiento-estado"
                            aria-invalid={Boolean(errors.estado)}
                        >
                            <SelectValue placeholder="Selecciona estado" />
                        </SelectTrigger>
                        <SelectContent>
                            {SEGUIMIENTO_ESTADO_OPTIONS.map((option) => (
                                <SelectItem key={option.value} value={option.value}>
                                    {option.label}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    {errors.estado && <FieldError>{errors.estado}</FieldError>}
                </Field>

                <Field>
                    <Label htmlFor="seguimiento-prioridad">Prioridad</Label>
                    <Select
                        value={data.prioridad}
                        onValueChange={(value) => onChange('prioridad', value)}
                    >
                        <SelectTrigger
                            id="seguimiento-prioridad"
                            aria-invalid={Boolean(errors.prioridad)}
                        >
                            <SelectValue placeholder="Selecciona prioridad" />
                        </SelectTrigger>
                        <SelectContent>
                            {SEGUIMIENTO_PRIORIDAD_OPTIONS.map((option) => (
                                <SelectItem key={option.value} value={option.value}>
                                    {option.label}
                                </SelectItem>
                            ))}
                        </SelectContent>
                    </Select>
                    {errors.prioridad && <FieldError>{errors.prioridad}</FieldError>}
                </Field>

                <Field>
                    <Label htmlFor="seguimiento-fecha">Fecha seguimiento</Label>
                    <Input
                        id="seguimiento-fecha"
                        type="date"
                        value={data.fecha_seguimiento}
                        onChange={(event) => onChange('fecha_seguimiento', event.target.value)}
                        aria-invalid={Boolean(errors.fecha_seguimiento)}
                    />
                    {errors.fecha_seguimiento && (
                        <FieldError>{errors.fecha_seguimiento}</FieldError>
                    )}
                </Field>
            </div>

            <div className="grid gap-4 md:grid-cols-2">
                <Field>
                    <Label htmlFor="seguimiento-fecha-proxima">Proxima accion</Label>
                    <Input
                        id="seguimiento-fecha-proxima"
                        type="date"
                        value={data.fecha_proxima_accion}
                        onChange={(event) =>
                            onChange('fecha_proxima_accion', event.target.value)
                        }
                        aria-invalid={Boolean(errors.fecha_proxima_accion)}
                    />
                    {errors.fecha_proxima_accion && (
                        <FieldError>{errors.fecha_proxima_accion}</FieldError>
                    )}
                </Field>

                <Field>
                    <Label htmlFor="seguimiento-resultado">Resultado</Label>
                    <Input
                        id="seguimiento-resultado"
                        value={data.resultado}
                        onChange={(event) => onChange('resultado', event.target.value)}
                        aria-invalid={Boolean(errors.resultado)}
                    />
                    {errors.resultado && <FieldError>{errors.resultado}</FieldError>}
                </Field>
            </div>

            <FormTextareaField
                id="seguimiento-observaciones"
                label="Observaciones"
                value={data.observaciones}
                onChange={(event) => onChange('observaciones', event.target.value)}
                rows={2}
                error={errors.observaciones}
            />

            <div className="flex items-center justify-end gap-2">
                <Button type="button" variant="outline" onClick={onCancel}>
                    Cancelar
                </Button>
                <LoadingSubmitButton
                    label={mode === 'edit' ? 'Actualizar seguimiento' : 'Guardar seguimiento'}
                    processing={processing}
                />
            </div>
        </form>
    );
}
