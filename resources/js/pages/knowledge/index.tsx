import { Head, Link, router, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import { Archive, Eye, History, MoreHorizontal, Paperclip, Pencil, Plus, Search, Send, Ticket, Trash2, XCircle } from 'lucide-react';
import { useEffect, useState } from 'react';
import { route } from 'ziggy-js';
import { ConfirmDeleteDialog } from '@/components/confirm-delete-dialog';
import { DataTable, type DataTableColumn } from '@/components/data-table';
import { ModuleHeader } from '@/components/module-header';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, KnowledgeArticle, KnowledgeOptionProps, SharedData } from '@/types';

type PaginatedArticles = {
    data: KnowledgeArticle[];
    links: { url: string | null; label: string; active: boolean }[];
    from: number | null;
    to: number | null;
    total: number;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Base de conocimiento', href: route('knowledge.index') },
];

export default function KnowledgeIndex({
    articles,
    filters,
    metrics,
    categories,
    clientes,
    proyectos,
    modulos,
    tipos,
    visibilidades,
    estatuses,
}: KnowledgeOptionProps & {
    articles: PaginatedArticles;
    filters: Record<string, string | null>;
    metrics: Record<string, number>;
}) {
    const { flash } = usePage<SharedData>().props;

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const [deleteTarget, setDeleteTarget] = useState<KnowledgeArticle | null>(null);
    const [localFilters, setLocalFilters] = useState({
        search: filters.search ?? '',
        category_id: filters.category_id ?? 'todos',
        cliente_id: filters.cliente_id ?? 'todos',
        proyecto_id: filters.proyecto_id ?? 'todos',
        proyecto_modulo_id: filters.proyecto_modulo_id ?? 'todos',
        tipo: filters.tipo ?? 'todos',
        visibilidad: filters.visibilidad ?? 'todos',
        estatus: filters.estatus ?? 'todos',
    });
    const permissions = usePage<SharedData>().props.auth.permissions ?? [];
    const canCreate = permissions.includes('knowledge.create');
    const canManage = permissions.includes('knowledge.manage');
    const canDelete = permissions.includes('knowledge.delete');
    const canPublish = permissions.includes('knowledge.publish');

    const columns: DataTableColumn<KnowledgeArticle>[] = [
        { key: 'titulo', header: 'Titulo', cell: (row) => <Link className="font-medium text-primary hover:underline" href={route('knowledge.show', row.id)}>{row.titulo}</Link> },
        { key: 'category', header: 'Categoria', cell: (row) => row.category?.nombre ?? '-' },
        { key: 'scope', header: 'Cliente/Proyecto', cell: (row) => row.proyecto?.nombre ?? row.cliente?.nombre ?? row.cliente?.razon_social ?? '-' },
        { key: 'tipo', header: 'Tipo', cell: (row) => <Badge variant="outline">{labelize(row.tipo)}</Badge> },
        { key: 'visibilidad', header: 'Visibilidad', cell: (row) => <Badge variant={row.visibilidad === 'publica' ? 'secondary' : 'outline'}>{row.visibilidad}</Badge> },
        { key: 'estatus', header: 'Estatus', cell: (row) => <Badge variant={row.estatus === 'publicado' ? 'default' : row.estatus === 'archivado' ? 'destructive' : 'secondary'}>{row.estatus}</Badge> },
        { key: 'updated_at', header: 'Actualizado', cell: (row) => row.updated_at ? new Date(row.updated_at).toLocaleDateString('es-MX') : '-' },
        {
            key: 'actions',
            header: 'Acciones',
            className: 'w-20',
            cell: (row) => {
                const articleDetail = route('knowledge.show', row.id);

                return (
                    <DropdownMenu>
                        <DropdownMenuTrigger asChild><Button variant="ghost" size="icon" className="size-8"><MoreHorizontal className="size-4" /></Button></DropdownMenuTrigger>
                        <DropdownMenuContent align="end">
                            <DropdownMenuItem asChild><Link href={articleDetail}><Eye className="mr-2 size-4" /> Ver</Link></DropdownMenuItem>
                            {canManage && <DropdownMenuItem asChild><Link href={route('knowledge.edit', row.id)}><Pencil className="mr-2 size-4" /> Editar</Link></DropdownMenuItem>}
                            <DropdownMenuItem asChild><Link href={`${articleDetail}#tickets-relacionados`}><Ticket className="mr-2 size-4" /> Tickets relacionados</Link></DropdownMenuItem>
                            <DropdownMenuItem asChild><Link href={`${articleDetail}#versiones`}><History className="mr-2 size-4" /> Versiones</Link></DropdownMenuItem>
                            <DropdownMenuItem asChild><Link href={`${articleDetail}#archivos`}><Paperclip className="mr-2 size-4" /> Archivos</Link></DropdownMenuItem>
                            {canPublish && row.estatus !== 'publicado' && <DropdownMenuItem onClick={() => publish(row)}><Send className="mr-2 size-4" /> Publicar</DropdownMenuItem>}
                            {canManage && row.estatus !== 'archivado' && <DropdownMenuItem onClick={() => router.patch(route('knowledge.archive', row.id), {}, { preserveScroll: true })}><Archive className="mr-2 size-4" /> Archivar</DropdownMenuItem>}
                            {canDelete && <><DropdownMenuSeparator /><DropdownMenuItem variant="destructive" onClick={() => setDeleteTarget(row)}><Trash2 className="mr-2 size-4" /> Eliminar</DropdownMenuItem></>}
                        </DropdownMenuContent>
                    </DropdownMenu>
                );
            },
        },
    ];

    const applyFilters = () => {
        router.get(route('knowledge.index'), normalizeFilters(localFilters), { preserveState: true, preserveScroll: true });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Base de conocimiento" />
            <div className="space-y-4 rounded-xl p-4">
                <ModuleHeader title="Base de conocimiento" description="Documenta soluciones, procedimientos, respuestas frecuentes y aprendizajes derivados de tickets. Su objetivo es reducir trabajo repetitivo y servir como contexto para soporte e IA.">
                    <div className="flex gap-2">
                        {canManage && <Button asChild variant="outline"><Link href={route('knowledge.categories.index')}>Categorias</Link></Button>}
                        {canCreate && <Button asChild><Link href={route('knowledge.create')}><Plus className="size-4" /> Nuevo articulo</Link></Button>}
                    </div>
                </ModuleHeader>

                <div className="grid gap-3 md:grid-cols-4 xl:grid-cols-7">
                    <Metric title="Total" value={metrics.total} />
                    <Metric title="Publicados" value={metrics.published} />
                    <Metric title="Borradores" value={metrics.drafts} />
                    <Metric title="Internos" value={metrics.internal} />
                    <Metric title="Publicos" value={metrics.public} />
                    <Metric title="Tickets doc." value={metrics.documentedTickets} />
                    <Metric title="Cerrados sin doc." value={metrics.closedWithoutDocumentation} />
                </div>

                <div className="grid gap-3 md:grid-cols-4 xl:grid-cols-8">
                    <Input className="md:col-span-2" value={localFilters.search} onChange={(event) => setLocalFilters({ ...localFilters, search: event.target.value })} placeholder="Titulo, resumen, contenido o tags..." />
                    <FilterSelect value={localFilters.category_id} onChange={(value) => setLocalFilters({ ...localFilters, category_id: value })} options={categories.map((item) => ({ value: item.id, label: item.nombre }))} placeholder="Categoria" />
                    <FilterSelect value={localFilters.cliente_id} onChange={(value) => setLocalFilters({ ...localFilters, cliente_id: value })} options={clientes.map((item) => ({ value: item.id, label: item.nombre ?? item.razon_social ?? item.id }))} placeholder="Cliente" />
                    <FilterSelect value={localFilters.proyecto_id} onChange={(value) => setLocalFilters({ ...localFilters, proyecto_id: value })} options={proyectos.map((item) => ({ value: item.id, label: item.nombre }))} placeholder="Proyecto" />
                    <FilterSelect value={localFilters.proyecto_modulo_id} onChange={(value) => setLocalFilters({ ...localFilters, proyecto_modulo_id: value })} options={modulos.map((item) => ({ value: item.id, label: item.nombre }))} placeholder="Modulo" />
                    <FilterSelect value={localFilters.tipo} onChange={(value) => setLocalFilters({ ...localFilters, tipo: value })} options={tipos.map((item) => ({ value: item, label: labelize(item) }))} placeholder="Tipo" />
                    <FilterSelect value={localFilters.visibilidad} onChange={(value) => setLocalFilters({ ...localFilters, visibilidad: value })} options={visibilidades.map((item) => ({ value: item, label: item }))} placeholder="Visibilidad" />
                    <FilterSelect value={localFilters.estatus} onChange={(value) => setLocalFilters({ ...localFilters, estatus: value })} options={estatuses.map((item) => ({ value: item, label: item }))} placeholder="Estatus" />
                    <div className="flex gap-2">
                        <Button type="button" onClick={applyFilters}><Search className="size-4" /> Filtrar</Button>
                        <Button type="button" variant="outline" onClick={() => router.get(route('knowledge.index'))}><XCircle className="size-4" /> Limpiar</Button>
                    </div>
                </div>

                <DataTable columns={columns} data={articles.data} showSearch={false} emptyMessage="No hay articulos con los filtros actuales." />

                <div className="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <p className="text-sm text-muted-foreground">Mostrando {articles.from ?? 0}-{articles.to ?? 0} de {articles.total}</p>
                    <div className="flex flex-wrap gap-1">
                        {articles.links.map((link, index) => (
                            <Button key={`${link.label}-${index}`} variant={link.active ? 'default' : 'outline'} size="sm" disabled={!link.url} onClick={() => link.url && router.get(link.url, {}, { preserveScroll: true })}>
                                <span dangerouslySetInnerHTML={{ __html: link.label }} />
                            </Button>
                        ))}
                    </div>
                </div>
            </div>

            <ConfirmDeleteDialog open={deleteTarget !== null} onOpenChange={(open) => !open && setDeleteTarget(null)} title="Eliminar articulo" entityLabel="el articulo" itemName={deleteTarget?.titulo} onConfirm={() => {
                if (!deleteTarget) return;
                router.delete(route('knowledge.destroy', deleteTarget.id), { onSuccess: () => setDeleteTarget(null) });
            }} />
        </AppLayout>
    );

    function publish(article: KnowledgeArticle) {
        if (article.visibilidad === 'publica' && !window.confirm('Este articulo sera publico. Confirma que debe publicarse.')) {
            return;
        }

        router.patch(route('knowledge.publish', article.id), {}, { preserveScroll: true });
    }
}

function Metric({ title, value }: { title: string; value: number }) {
    return (
        <Card className="rounded-lg">
            <CardHeader className="p-3 pb-1"><CardTitle className="text-sm">{title}</CardTitle><CardDescription>Knowledge</CardDescription></CardHeader>
            <CardContent className="p-3 pt-0"><p className="text-2xl font-semibold">{value}</p></CardContent>
        </Card>
    );
}

function FilterSelect({ value, onChange, options, placeholder }: { value: string; onChange: (value: string) => void; options: { value: string; label: string }[]; placeholder: string }) {
    return (
        <Select value={value} onValueChange={onChange}>
            <SelectTrigger className="w-full"><SelectValue placeholder={placeholder} /></SelectTrigger>
            <SelectContent>
                <SelectItem value="todos">Todos</SelectItem>
                {options.map((option) => <SelectItem key={option.value} value={option.value}>{option.label}</SelectItem>)}
            </SelectContent>
        </Select>
    );
}

function normalizeFilters(filters: Record<string, string>) {
    return Object.fromEntries(Object.entries(filters).filter(([, value]) => value !== '' && value !== 'todos'));
}

const labelize = (value: string) => value.replaceAll('_', ' ');
