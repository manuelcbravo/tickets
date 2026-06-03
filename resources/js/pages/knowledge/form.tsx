import { Link, router, useForm } from '@inertiajs/react';
import { Paperclip } from 'lucide-react';
import type React from 'react';
import { useMemo, useState } from 'react';
import { route } from 'ziggy-js';
import { FilePickerDialog } from '@/components/file-picker-dialog';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { LoadingSubmitButton } from '@/components/loading-submit-button';
import { Button } from '@/components/ui/button';
import { Field, FieldError } from '@/components/ui/field';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import type { KnowledgeArticle, KnowledgeFormValues, KnowledgeOptionProps } from '@/types';

type ArticleFile = { id: string; original_name: string; path: string; url: string; mime_type: string | null; size: number };

type KnowledgeFormProps = KnowledgeOptionProps & {
    article?: KnowledgeArticle;
    defaults?: Partial<KnowledgeFormValues>;
    submitUrl: string;
    submitLabel: string;
    method?: 'post' | 'put';
    files?: ArticleFile[];
};

const none = 'none';

const defaultValues: KnowledgeFormValues = {
    titulo: '',
    resumen: '',
    contenido: '',
    category_id: none,
    cliente_id: none,
    proyecto_id: none,
    proyecto_modulo_id: none,
    tipo: 'procedimiento',
    visibilidad: 'interna',
    estatus: 'borrador',
    prioridad: '0',
    tags: '',
    change_summary: '',
};

export function KnowledgeForm({
    article,
    defaults,
    submitUrl,
    submitLabel,
    method = 'post',
    categories,
    clientes,
    proyectos,
    modulos,
    tipos,
    visibilidades,
    estatuses,
    files = [],
}: KnowledgeFormProps) {
    const [filesOpen, setFilesOpen] = useState(false);
    const form = useForm<KnowledgeFormValues>({
        ...defaultValues,
        tipo: tipos[0] ?? defaultValues.tipo,
        visibilidad: visibilidades[0] ?? defaultValues.visibilidad,
        estatus: estatuses[0] ?? defaultValues.estatus,
        ...defaults,
        ...(article ? {
            titulo: article.titulo,
            resumen: article.resumen ?? '',
            contenido: article.contenido,
            category_id: article.category_id ?? none,
            cliente_id: article.cliente_id ?? none,
            proyecto_id: article.proyecto_id ?? none,
            proyecto_modulo_id: article.proyecto_modulo_id ?? none,
            tipo: article.tipo,
            visibilidad: article.visibilidad,
            estatus: article.estatus,
            prioridad: String(article.prioridad ?? 0),
            tags: (article.tags ?? []).join(', '),
            change_summary: '',
        } : {}),
    });

    const filteredProjects = useMemo(
        () => form.data.cliente_id === none ? proyectos : proyectos.filter((project) => project.client_id === form.data.cliente_id),
        [form.data.cliente_id, proyectos],
    );
    const filteredModules = useMemo(
        () => form.data.proyecto_id === none ? [] : modulos.filter((module) => module.project_id === form.data.proyecto_id),
        [form.data.proyecto_id, modulos],
    );

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        form.transform((data) => ({
            ...data,
            category_id: normalize(data.category_id),
            cliente_id: normalize(data.cliente_id),
            proyecto_id: normalize(data.proyecto_id),
            proyecto_modulo_id: normalize(data.proyecto_modulo_id),
            prioridad: data.prioridad || '0',
        }));

        if (method === 'put') {
            form.put(submitUrl);
            return;
        }

        form.post(submitUrl);
    };

    return (
        <form className="space-y-6" onSubmit={submit}>
            <div className="grid gap-4 md:grid-cols-2">
                <div className="md:col-span-2">
                    <FormInputField id="knowledge-title" label="Titulo" value={form.data.titulo} error={form.errors.titulo} onChange={(event) => form.setData('titulo', event.target.value)} />
                </div>
                <div className="md:col-span-2">
                    <FormTextareaField id="knowledge-summary" label="Resumen" value={form.data.resumen} error={form.errors.resumen} onChange={(event) => form.setData('resumen', event.target.value)} />
                </div>
                <div className="md:col-span-2">
                    <FormTextareaField id="knowledge-content" label="Contenido" value={form.data.contenido} error={form.errors.contenido} rows={14} onChange={(event) => form.setData('contenido', event.target.value)} />
                </div>
                <SelectField label="Categoria" value={form.data.category_id} error={form.errors.category_id} onChange={(value) => form.setData('category_id', value)} options={[{ value: none, label: 'Sin categoria' }, ...categories.map((category) => ({ value: category.id, label: category.nombre }))]} />
                <SelectField label="Tipo" value={form.data.tipo} error={form.errors.tipo} onChange={(value) => form.setData('tipo', value)} options={tipos.map((item) => ({ value: item, label: labelize(item) }))} />
                <SelectField label="Visibilidad" value={form.data.visibilidad} error={form.errors.visibilidad} onChange={(value) => form.setData('visibilidad', value)} options={visibilidades.map((item) => ({ value: item, label: labelize(item) }))} />
                <SelectField label="Estatus" value={form.data.estatus} error={form.errors.estatus} onChange={(value) => form.setData('estatus', value)} options={estatuses.map((item) => ({ value: item, label: labelize(item) }))} />
                <SelectField label="Cliente" value={form.data.cliente_id} error={form.errors.cliente_id} onChange={(value) => {
                    form.setData((data) => ({ ...data, cliente_id: value, proyecto_id: none, proyecto_modulo_id: none }));
                }} options={[{ value: none, label: 'Sin cliente' }, ...clientes.map((cliente) => ({ value: cliente.id, label: cliente.nombre ?? cliente.razon_social ?? cliente.id }))]} />
                <SelectField label="Proyecto" value={form.data.proyecto_id} error={form.errors.proyecto_id} onChange={(value) => {
                    form.setData((data) => ({ ...data, proyecto_id: value, proyecto_modulo_id: none }));
                }} options={[{ value: none, label: 'Sin proyecto' }, ...filteredProjects.map((project) => ({ value: project.id, label: project.nombre }))]} />
                <SelectField label="Modulo" value={form.data.proyecto_modulo_id} error={form.errors.proyecto_modulo_id} onChange={(value) => form.setData('proyecto_modulo_id', value)} options={[{ value: none, label: 'Sin modulo' }, ...filteredModules.map((module) => ({ value: module.id, label: module.nombre }))]} />
                <FormInputField id="knowledge-priority" label="Prioridad" type="number" min="0" value={form.data.prioridad} error={form.errors.prioridad} onChange={(event) => form.setData('prioridad', event.target.value)} />
                <div className="md:col-span-2">
                    <FormInputField id="knowledge-tags" label="Tags" value={form.data.tags} error={form.errors.tags} placeholder="bug, reportes, despliegue" onChange={(event) => form.setData('tags', event.target.value)} />
                </div>
                {article && (
                    <div className="md:col-span-2">
                        <FormTextareaField id="knowledge-change-summary" label="Resumen del cambio" value={form.data.change_summary} error={form.errors.change_summary} onChange={(event) => form.setData('change_summary', event.target.value)} />
                    </div>
                )}
            </div>

            {article && (
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4 space-y-3">
                    <div className="flex items-center justify-between">
                        <div className="flex items-center gap-2">
                            <Paperclip className="size-4 text-muted-foreground" />
                            <span className="text-sm font-medium">Archivos adjuntos {files.length > 0 && `(${files.length})`}</span>
                        </div>
                        <Button type="button" size="sm" variant="outline" onClick={() => setFilesOpen(true)}>Subir archivo</Button>
                    </div>
                    {files.length === 0 ? (
                        <p className="text-sm text-muted-foreground">Sin archivos adjuntos. Puedes subir imagenes, PDFs, documentos, etc.</p>
                    ) : (
                        <div className="grid grid-cols-2 gap-2 sm:grid-cols-3 md:grid-cols-4">
                            {files.map((file) => (
                                <div key={file.id} className="flex flex-col overflow-hidden rounded-md border border-border">
                                    {file.mime_type?.startsWith('image/') ? (
                                        <img src={file.url} alt={file.original_name} className="h-20 w-full object-cover" />
                                    ) : (
                                        <div className="flex h-20 w-full items-center justify-center bg-muted/30">
                                            <Paperclip className="size-6 text-muted-foreground" />
                                        </div>
                                    )}
                                    <div className="p-2 text-[11px]">
                                        <p className="truncate font-medium">{file.original_name}</p>
                                        <p className="text-muted-foreground">{(file.size / 1024).toFixed(0)} KB</p>
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}
                </div>
            )}

            <div className="flex justify-end gap-2">
                <Button asChild variant="outline"><Link href={route('knowledge.index')}>Cancelar</Link></Button>
                <LoadingSubmitButton label={submitLabel} processing={form.processing} />
            </div>

            {article && (
                <FilePickerDialog
                    open={filesOpen}
                    onOpenChange={setFilesOpen}
                    title={`Archivos · ${article.titulo}`}
                    description="Sube archivos relacionados a este articulo."
                    storedFiles={files}
                    tableId="knowledge_articles"
                    relatedUuid={article.id}
                    accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx,.xls,.xlsx,.txt,.csv,.zip"
                    maxSizeHint="Maximo 10MB"
                    onDownloadStoredFile={(file) => window.open(file.url, '_blank', 'noopener,noreferrer')}
                    onDeleteStoredFile={(fileId) => router.delete(route('files.destroy', fileId), { data: { related_table: 'knowledge_articles', related_uuid: article.id }, preserveScroll: true })}
                />
            )}
        </form>
    );
}

function SelectField({ label, value, options, error, onChange }: { label: string; value: string; options: { value: string; label: string }[]; error?: string; onChange: (value: string) => void }) {
    return (
        <Field>
            <Label>{label}</Label>
            <Select value={value} onValueChange={onChange}>
                <SelectTrigger className="w-full"><SelectValue placeholder={label} /></SelectTrigger>
                <SelectContent>{options.map((option) => <SelectItem key={option.value} value={option.value}>{option.label}</SelectItem>)}</SelectContent>
            </Select>
            {error && <FieldError>{error}</FieldError>}
        </Field>
    );
}

const normalize = (value: string) => value === none || value === '' ? null : value;
const labelize = (value: string) => value.replaceAll('_', ' ');
