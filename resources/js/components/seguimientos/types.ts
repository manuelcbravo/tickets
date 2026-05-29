export type SeguimientoTipo = {
    id: number;
    nombre: string;
    descripcion: string | null;
};

export type Seguimiento = {
    id: number;
    id_relacion: string;
    tabla_relacion: string;
    titulo: string;
    seguimiento: string;
    tipo_id: number;
    estado: string | null;
    prioridad: string | null;
    fecha_seguimiento: string | null;
    fecha_proxima_accion: string | null;
    resultado: string | null;
    observaciones: string | null;
    created_at: string;
    updated_at: string;
    created_by?: { id: number; name: string } | null;
    updated_by?: { id: number; name: string } | null;
    tipo?: { id: number; nombre: string } | null;
};

export type SeguimientoFormData = {
    titulo: string;
    seguimiento: string;
    tipo_id: string;
    estado: string;
    prioridad: string;
    fecha_seguimiento: string;
    fecha_proxima_accion: string;
    resultado: string;
    observaciones: string;
};

export type SeguimientoFormErrors = Partial<Record<keyof SeguimientoFormData, string>>;
