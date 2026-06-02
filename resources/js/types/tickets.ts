export type CatalogOption = {
    id: number;
    nombre: string;
    descripcion?: string | null;
    activo?: boolean;
};

export type TicketMissingInformationItem = {
    key: string;
    label: string;
    required: boolean;
    completed: boolean;
};

export type TicketChecklistItem = {
    id: string;
    titulo: string;
    descripcion?: string | null;
    tipo?: string | null;
    requerido: boolean;
    completado: boolean;
    orden: number;
    completado_at?: string | null;
    completado_por?: { name: string } | null;
};

export type TicketRelation = {
    id: string;
    tipo: string;
    descripcion?: string | null;
    related_ticket?: {
        id: string;
        folio: string;
        titulo: string;
    } | null;
};

export type TicketTiempo = {
    id: string;
    descripcion: string;
    minutos: number;
    fecha: string;
    iniciado_at?: string | null;
    terminado_at?: string | null;
    es_facturable: boolean;
    origen: string;
    usuario?: { id?: number; name: string } | null;
};

export type TicketSla = {
    id: string;
    estado_sla: string;
    vence_primera_respuesta_at?: string | null;
    vence_resolucion_at?: string | null;
    primera_respuesta_cumplida?: boolean | null;
    resolucion_cumplida?: boolean | null;
    primera_respuesta_at?: string | null;
    resuelto_at?: string | null;
    politica?: { id: string; nombre: string } | null;
    prioridad?: CatalogOption | null;
};

export type TicketAiCatalog = {
    id: number;
    nombre: string;
};

export type TicketAiAnalysis = {
    id: string;
    status: 'pending' | 'processing' | 'completed' | 'failed' | 'applied' | 'rejected' | string;
    analysis_type: string;
    summary?: string | null;
    detected_problem?: string | null;
    suggested_difficulty?: string | null;
    missing_information?: Array<{ key?: string; label?: string; required?: boolean; reason?: string }> | null;
    suggested_reply?: string | null;
    suggested_checklist?: Array<{ title?: string; description?: string; required?: boolean }> | null;
    can_answer_directly: boolean;
    requires_code_change: boolean;
    requires_quote: boolean;
    confidence?: string | number | null;
    error_message?: string | null;
    raw_response?: {
        parsed?: Record<string, unknown>;
        metadata?: { used_knowledge_article_ids?: string[] };
    } | null;
    executed_at?: string | null;
    created_at: string;
    user?: { id: number; name: string } | null;
    suggested_type?: TicketAiCatalog | null;
    suggested_priority?: TicketAiCatalog | null;
    suggested_impact?: TicketAiCatalog | null;
    suggested_urgency?: TicketAiCatalog | null;
    suggested_risk?: TicketAiCatalog | null;
};

export type TicketAiAction = {
    id: string;
    type: string;
    status: string;
    title?: string | null;
    response?: string | null;
    metadata?: Record<string, unknown> | null;
    applied_at?: string | null;
    rejected_at?: string | null;
    rejection_reason?: string | null;
    created_at: string;
    user?: { id: number; name: string } | null;
};

export type TicketAiConfig = {
    enabled: boolean;
    configured: boolean;
    model: string;
};

export type ClientOption = {
    id: string;
    nombre: string | null;
    razon_social?: string | null;
    estatus?: string | null;
};

export type ProjectOption = {
    id: string;
    client_id: string;
    nombre: string;
};

export type ProjectChildOption = {
    id: string;
    project_id: string;
    nombre: string;
    url?: string | null;
};

export type ContactOption = {
    id: string;
    client_id: string;
    nombre: string;
    email?: string | null;
};

export type UserOption = {
    id: number;
    name: string;
};

export type TicketFormValues = {
    cliente_id: string;
    proyecto_id: string;
    proyecto_modulo_id: string;
    contacto_id: string;
    ambiente_id: string;
    titulo: string;
    descripcion: string;
    tipo_id: string;
    estado_id: string;
    prioridad_id: string;
    impacto_id: string;
    urgencia_id: string;
    riesgo_id: string;
    dificultad: string;
    responsable_id: string;
    fecha_objetivo: string;
    tiempo_estimado_min: string;
    requires_code_change: boolean;
    requires_quote: boolean;
    is_internal: boolean;
};

export type TicketOptionProps = {
    clientes: ClientOption[];
    proyectos: ProjectOption[];
    modulos: ProjectChildOption[];
    contactos: ContactOption[];
    ambientes: ProjectChildOption[];
    users: UserOption[];
    tipos: CatalogOption[];
    estados: CatalogOption[];
    prioridades: CatalogOption[];
    impactos: CatalogOption[];
    urgencias: CatalogOption[];
    riesgos: CatalogOption[];
};

export type PrioritySuggestion = {
    priority_score: number;
    prioridad_id: number | null;
    prioridad_nombre: string | null;
    explanation: string;
    effort_warning?: string | null;
};
