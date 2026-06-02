export type KnowledgeCategory = {
    id: string;
    nombre: string;
    slug?: string;
    descripcion?: string | null;
    parent_id?: string | null;
    proyecto_id?: string | null;
    orden?: number;
    activo?: boolean;
    parent?: { id: string; nombre: string } | null;
    proyecto?: { id: string; nombre: string } | null;
    articles_count?: number;
};

export type KnowledgeArticle = {
    id: string;
    titulo: string;
    slug: string;
    resumen?: string | null;
    contenido: string;
    tipo: string;
    visibilidad: string;
    estatus: string;
    prioridad: number;
    tags?: string[] | null;
    category_id?: string | null;
    cliente_id?: string | null;
    proyecto_id?: string | null;
    proyecto_modulo_id?: string | null;
    fuente_ticket_id?: string | null;
    published_at?: string | null;
    archived_at?: string | null;
    updated_at?: string | null;
    category?: { id: string; nombre: string } | null;
    cliente?: { id: string; nombre: string | null; razon_social?: string | null } | null;
    proyecto?: { id: string; nombre: string } | null;
    modulo?: { id: string; nombre: string } | null;
    fuente_ticket?: { id: string; folio: string; titulo: string } | null;
    creado_por?: { name: string } | null;
    actualizado_por?: { name: string } | null;
    publicado_por?: { name: string } | null;
    pivot?: { tipo_relacion: string; notas?: string | null };
    tickets?: Array<{ id: string; folio: string; titulo: string; pivot?: { tipo_relacion: string; notas?: string | null } }>;
    versions?: KnowledgeArticleVersion[];
};

export type KnowledgeArticleVersion = {
    id: string;
    version: number;
    titulo: string;
    resumen?: string | null;
    contenido: string;
    estatus?: string | null;
    visibilidad?: string | null;
    change_summary?: string | null;
    created_at: string;
    changed_by?: { name: string } | null;
};

export type KnowledgeFormValues = {
    titulo: string;
    resumen: string;
    contenido: string;
    category_id: string;
    cliente_id: string;
    proyecto_id: string;
    proyecto_modulo_id: string;
    tipo: string;
    visibilidad: string;
    estatus: string;
    prioridad: string;
    tags: string;
    change_summary: string;
};

export type KnowledgeOptionProps = {
    categories: KnowledgeCategory[];
    clientes: Array<{ id: string; nombre: string | null; razon_social?: string | null }>;
    proyectos: Array<{ id: string; client_id: string; nombre: string }>;
    modulos: Array<{ id: string; project_id: string; nombre: string }>;
    tipos: string[];
    visibilidades: string[];
    estatuses: string[];
};
