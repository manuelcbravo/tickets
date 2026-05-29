export const SEGUIMIENTO_ESTADO_OPTIONS = [
    { value: 'pendiente', label: 'Pendiente' },
    { value: 'en_proceso', label: 'En proceso' },
    { value: 'completado', label: 'Completado' },
    { value: 'cancelado', label: 'Cancelado' },
] as const;

export const SEGUIMIENTO_PRIORIDAD_OPTIONS = [
    { value: 'baja', label: 'Baja' },
    { value: 'media', label: 'Media' },
    { value: 'alta', label: 'Alta' },
    { value: 'urgente', label: 'Urgente' },
] as const;

export const SEGUIMIENTO_ESTADO_LABELS: Record<string, string> = Object.fromEntries(
    SEGUIMIENTO_ESTADO_OPTIONS.map((option) => [option.value, option.label]),
);

export const SEGUIMIENTO_PRIORIDAD_LABELS: Record<string, string> = Object.fromEntries(
    SEGUIMIENTO_PRIORIDAD_OPTIONS.map((option) => [option.value, option.label]),
);
