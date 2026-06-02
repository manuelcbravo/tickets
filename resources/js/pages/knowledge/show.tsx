import { Head, Link, router, usePage } from '@inertiajs/react';
import { Archive, Pencil, Send } from 'lucide-react';
import { route } from 'ziggy-js';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, KnowledgeArticle, SharedData } from '@/types';

export default function KnowledgeShow({ article }: { article: KnowledgeArticle }) {
    const permissions = usePage<SharedData>().props.auth.permissions ?? [];
    const canManage = permissions.includes('knowledge.manage');
    const canPublish = permissions.includes('knowledge.publish');
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Base de conocimiento', href: route('knowledge.index') },
        { title: article.titulo, href: route('knowledge.show', article.id) },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={article.titulo} />
            <div className="space-y-4 rounded-xl p-4">
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
                    <div className="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <div className="flex flex-wrap gap-2">
                                <Badge>{article.estatus}</Badge>
                                <Badge variant={article.visibilidad === 'publica' ? 'secondary' : 'outline'}>{article.visibilidad}</Badge>
                                <Badge variant="outline">{article.tipo.replaceAll('_', ' ')}</Badge>
                            </div>
                            <h1 className="mt-3 text-xl font-semibold">{article.titulo}</h1>
                            <p className="text-sm text-muted-foreground">{article.resumen ?? 'Sin resumen'}</p>
                        </div>
                        <div className="flex flex-wrap gap-2">
                            {canManage && <Button asChild variant="outline"><Link href={route('knowledge.edit', article.id)}><Pencil className="size-4" /> Editar</Link></Button>}
                            {canPublish && article.estatus !== 'publicado' && <Button onClick={() => publish(article)}><Send className="size-4" /> Publicar</Button>}
                            {canManage && article.estatus !== 'archivado' && <Button variant="outline" onClick={() => router.patch(route('knowledge.archive', article.id), {}, { preserveScroll: true })}><Archive className="size-4" /> Archivar</Button>}
                        </div>
                    </div>
                </div>

                <div className="grid gap-4 lg:grid-cols-3">
                    <Card className="rounded-lg lg:col-span-2">
                        <CardHeader><CardTitle>Contenido</CardTitle></CardHeader>
                        <CardContent>
                            <div className="whitespace-pre-line text-sm leading-6">{article.contenido}</div>
                        </CardContent>
                    </Card>
                    <Card className="rounded-lg">
                        <CardHeader><CardTitle>Contexto</CardTitle></CardHeader>
                        <CardContent className="space-y-3">
                            <Info label="Categoria" value={article.category?.nombre} />
                            <Info label="Cliente" value={article.cliente?.nombre ?? article.cliente?.razon_social} />
                            <Info label="Proyecto" value={article.proyecto?.nombre} />
                            <Info label="Modulo" value={article.modulo?.nombre} />
                            <Info label="Autor" value={article.creado_por?.name} />
                            <Info label="Publicado por" value={article.publicado_por?.name} />
                            <Info label="Publicado" value={article.published_at ? new Date(article.published_at).toLocaleString('es-MX') : null} />
                            {article.fuente_ticket && (
                                <Button asChild variant="outline" className="w-full"><Link href={route('tickets.show', article.fuente_ticket.id)}>Ticket fuente {article.fuente_ticket.folio}</Link></Button>
                            )}
                        </CardContent>
                    </Card>
                </div>

                <div className="grid gap-4 lg:grid-cols-2">
                    <Card className="rounded-lg">
                        <CardHeader><CardTitle>Tickets relacionados</CardTitle></CardHeader>
                        <CardContent className="space-y-2">
                            {!article.tickets?.length ? <p className="text-sm text-muted-foreground">Sin tickets relacionados.</p> : article.tickets.map((ticket) => (
                                <div key={ticket.id} className="rounded-md border p-3 text-sm">
                                    <Badge variant="outline">{ticket.pivot?.tipo_relacion ?? 'relacionado'}</Badge>
                                    <Link className="ml-2 font-medium text-primary hover:underline" href={route('tickets.show', ticket.id)}>{ticket.folio} · {ticket.titulo}</Link>
                                </div>
                            ))}
                        </CardContent>
                    </Card>
                    <Card className="rounded-lg">
                        <CardHeader><CardTitle>Versiones</CardTitle><CardDescription>Historico simple previo a cambios relevantes.</CardDescription></CardHeader>
                        <CardContent className="space-y-2">
                            {!article.versions?.length ? <p className="text-sm text-muted-foreground">Sin versiones guardadas.</p> : article.versions.map((version) => (
                                <div key={version.id} className="rounded-md border p-3 text-sm">
                                    <p className="font-medium">Version {version.version} · {version.titulo}</p>
                                    <p className="text-muted-foreground">{version.change_summary ?? 'Sin resumen de cambio.'}</p>
                                    <p className="text-xs text-muted-foreground">{version.changed_by?.name ?? 'Sistema'} · {new Date(version.created_at).toLocaleString('es-MX')}</p>
                                </div>
                            ))}
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppLayout>
    );
}

function Info({ label, value }: { label: string; value?: string | null }) {
    return <div className="rounded-md border p-3"><p className="text-xs text-muted-foreground">{label}</p><p className="text-sm font-medium">{value || '-'}</p></div>;
}

function publish(article: KnowledgeArticle) {
    if (article.visibilidad === 'publica' && !window.confirm('Este articulo sera publico. Confirma que debe publicarse.')) {
        return;
    }

    router.patch(route('knowledge.publish', article.id), {}, { preserveScroll: true });
}
