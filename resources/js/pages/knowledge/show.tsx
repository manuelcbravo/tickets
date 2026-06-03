import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import { Archive, Paperclip, Pencil, RotateCcw, Send, Trash2, X } from 'lucide-react';
import type React from 'react';
import { useState } from 'react';
import { route } from 'ziggy-js';
import { FilePickerDialog } from '@/components/file-picker-dialog';
import { FormTextareaField } from '@/components/form-textarea-field';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, KnowledgeArticle, KnowledgeArticleVersion, SharedData } from '@/types';

type ArticleFile = { id: string; original_name: string; path: string; url: string; mime_type: string | null; size: number };
type AvailableTicket = { id: string; folio: string; titulo: string };

const TIPOS_RELACION = ['solucion', 'relacionado', 'referencia', 'creado_desde_ticket', 'respuesta_sugerida'] as const;

export default function KnowledgeShow({ article, files = [], availableTickets = [] }: { article: KnowledgeArticle; files?: ArticleFile[]; availableTickets?: AvailableTicket[] }) {
    const permissions = usePage<SharedData>().props.auth.permissions ?? [];
    const canManage = permissions.includes('knowledge.manage');
    const canPublish = permissions.includes('knowledge.publish');
    const canLinkTickets = permissions.includes('knowledge.manage') || permissions.includes('knowledge.link');
    const [filesOpen, setFilesOpen] = useState(false);
    const [linkTicketOpen, setLinkTicketOpen] = useState(false);
    const [selectedVersion, setSelectedVersion] = useState<KnowledgeArticleVersion | null>(null);
    const [ticketFilter, setTicketFilter] = useState('');
    const linkForm = useForm({ ticket_id: '', tipo_relacion: 'relacionado', notas: '' });

    const filteredTickets = availableTickets.filter((t) =>
        `${t.folio} ${t.titulo}`.toLowerCase().includes(ticketFilter.toLowerCase()),
    );

    const submitLinkTicket = (e: React.FormEvent) => {
        e.preventDefault();
        linkForm.post(route('knowledge.tickets.store', article.id), {
            preserveScroll: true,
            onSuccess: () => {
                setLinkTicketOpen(false);
                linkForm.reset();
                setTicketFilter('');
            },
        });
    };
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
                            <Button variant="outline" onClick={() => setFilesOpen(true)}><Paperclip className="size-4" /> Archivos {files.length > 0 && `(${files.length})`}</Button>
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
                    <Card id="tickets-relacionados" className="rounded-lg">
                        <CardHeader>
                            <div className="flex items-center justify-between">
                                <CardTitle>Tickets relacionados</CardTitle>
                                {canLinkTickets && <Button size="sm" variant="outline" onClick={() => setLinkTicketOpen(true)}>Vincular ticket</Button>}
                            </div>
                        </CardHeader>
                        <CardContent className="space-y-2">
                            {!article.tickets?.length ? <p className="text-sm text-muted-foreground">Sin tickets relacionados.</p> : article.tickets.map((ticket) => (
                                <div key={ticket.id} className="flex items-center justify-between rounded-md border p-3 text-sm">
                                    <div className="min-w-0">
                                        <Badge variant="outline">{ticket.pivot?.tipo_relacion ?? 'relacionado'}</Badge>
                                        <Link className="ml-2 font-medium text-primary hover:underline" href={route('tickets.show', ticket.id)}>{ticket.folio} · {ticket.titulo}</Link>
                                    </div>
                                    {canLinkTickets && (
                                        <Button variant="ghost" size="icon" className="ml-2 shrink-0 text-muted-foreground hover:text-destructive" onClick={() => router.delete(route('knowledge.tickets.destroy', [article.id, ticket.id]), { preserveScroll: true })}>
                                            <X className="size-4" />
                                        </Button>
                                    )}
                                </div>
                            ))}
                        </CardContent>
                    </Card>
                    <Card id="versiones" className="rounded-lg">
                        <CardHeader><CardTitle>Versiones</CardTitle><CardDescription>Historico simple previo a cambios relevantes.</CardDescription></CardHeader>
                        <CardContent className="space-y-2">
                            {!article.versions?.length ? <p className="text-sm text-muted-foreground">Sin versiones guardadas.</p> : article.versions.map((version) => (
                                <div key={version.id} className="rounded-md border p-3 text-sm">
                                    <div className="flex items-start justify-between gap-2">
                                        <div className="min-w-0">
                                            <p className="font-medium">Version {version.version} · {version.titulo}</p>
                                            <p className="text-muted-foreground">{version.change_summary ?? 'Sin resumen de cambio.'}</p>
                                            <p className="text-xs text-muted-foreground">{version.changed_by?.name ?? 'Sistema'} · {new Date(version.created_at).toLocaleString('es-MX')}</p>
                                        </div>
                                        <div className="flex shrink-0 gap-1">
                                            <Button size="sm" variant="ghost" onClick={() => setSelectedVersion(version)}>Ver</Button>
                                            {canManage && (
                                                <Button size="sm" variant="ghost" className="text-muted-foreground hover:text-primary" onClick={() => {
                                                    if (window.confirm(`¿Restaurar el articulo a la version ${version.version}? El estado actual se guardara como una nueva version.`)) {
                                                        router.post(route('knowledge.versions.restore', [article.id, version.id]), {}, { preserveScroll: true });
                                                    }
                                                }}>
                                                    <RotateCcw className="size-3.5" />
                                                </Button>
                                            )}
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </CardContent>
                    </Card>
                </div>

                <Card id="archivos" className="rounded-lg">
                    <CardHeader>
                        <div className="flex items-center justify-between">
                            <CardTitle className="flex items-center gap-2"><Paperclip className="size-4" /> Archivos adjuntos</CardTitle>
                            {canManage && <Button size="sm" variant="outline" onClick={() => setFilesOpen(true)}>Subir archivo</Button>}
                        </div>
                    </CardHeader>
                    <CardContent>
                        {files.length === 0 ? (
                            <p className="text-sm text-muted-foreground">Sin archivos adjuntos.</p>
                        ) : (
                            <div className="grid grid-cols-2 gap-2 sm:grid-cols-3 md:grid-cols-4">
                                {files.map((file) => (
                                    <a
                                        key={file.id}
                                        href={file.url}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="group flex flex-col overflow-hidden rounded-md border border-border hover:border-primary/60 transition"
                                    >
                                        {file.mime_type?.startsWith('image/') ? (
                                            <img src={file.url} alt={file.original_name} className="h-28 w-full object-cover" />
                                        ) : (
                                            <div className="flex h-28 w-full items-center justify-center bg-muted/30">
                                                <Paperclip className="size-8 text-muted-foreground" />
                                            </div>
                                        )}
                                        <div className="space-y-0.5 p-2 text-[11px]">
                                            <p className="truncate font-medium">{file.original_name}</p>
                                            <p className="text-muted-foreground">{(file.size / 1024).toFixed(0)} KB</p>
                                        </div>
                                    </a>
                                ))}
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>

            {/* Dialog: vincular ticket */}
            <Dialog open={linkTicketOpen} onOpenChange={(open) => { setLinkTicketOpen(open); if (!open) { linkForm.reset(); setTicketFilter(''); } }}>
                <DialogContent className="max-w-lg">
                    <DialogHeader>
                        <DialogTitle>Vincular ticket</DialogTitle>
                        <DialogDescription>Selecciona un ticket y el tipo de relacion con este articulo.</DialogDescription>
                    </DialogHeader>
                    <form onSubmit={submitLinkTicket} className="space-y-4">
                        <div className="space-y-1.5">
                            <Label>Ticket</Label>
                            <Input placeholder="Buscar por folio o titulo..." value={ticketFilter} onChange={(e) => setTicketFilter(e.target.value)} />
                            <div className="max-h-48 overflow-y-auto rounded-md border">
                                {filteredTickets.length === 0 ? (
                                    <p className="p-3 text-sm text-muted-foreground">Sin tickets disponibles.</p>
                                ) : filteredTickets.map((t) => (
                                    <button
                                        key={t.id}
                                        type="button"
                                        className={`w-full px-3 py-2 text-left text-sm hover:bg-muted transition ${linkForm.data.ticket_id === t.id ? 'bg-primary/10 font-medium' : ''}`}
                                        onClick={() => linkForm.setData('ticket_id', t.id)}
                                    >
                                        <span className="font-mono text-xs text-muted-foreground">{t.folio}</span> {t.titulo}
                                    </button>
                                ))}
                            </div>
                            {linkForm.errors.ticket_id && <p className="text-xs text-destructive">{linkForm.errors.ticket_id}</p>}
                        </div>
                        <div className="space-y-1.5">
                            <Label>Tipo de relacion</Label>
                            <Select value={linkForm.data.tipo_relacion} onValueChange={(v) => linkForm.setData('tipo_relacion', v)}>
                                <SelectTrigger><SelectValue /></SelectTrigger>
                                <SelectContent>
                                    {TIPOS_RELACION.map((t) => <SelectItem key={t} value={t}>{t.replaceAll('_', ' ')}</SelectItem>)}
                                </SelectContent>
                            </Select>
                            {linkForm.errors.tipo_relacion && <p className="text-xs text-destructive">{linkForm.errors.tipo_relacion}</p>}
                        </div>
                        <FormTextareaField id="link-notas" label="Notas (opcional)" value={linkForm.data.notas} error={linkForm.errors.notas} rows={2} onChange={(e) => linkForm.setData('notas', e.target.value)} />
                        <DialogFooter>
                            <Button type="button" variant="outline" onClick={() => setLinkTicketOpen(false)}>Cancelar</Button>
                            <Button type="submit" disabled={!linkForm.data.ticket_id || linkForm.processing}>Vincular</Button>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>

            {/* Dialog: ver version */}
            <Dialog open={!!selectedVersion} onOpenChange={(open) => { if (!open) setSelectedVersion(null); }}>
                <DialogContent className="max-w-2xl">
                    <DialogHeader>
                        <DialogTitle>Version {selectedVersion?.version} · {selectedVersion?.titulo}</DialogTitle>
                        <DialogDescription>
                            {selectedVersion?.changed_by?.name ?? 'Sistema'} · {selectedVersion ? new Date(selectedVersion.created_at).toLocaleString('es-MX') : ''}
                            {selectedVersion?.change_summary && ` · ${selectedVersion.change_summary}`}
                        </DialogDescription>
                    </DialogHeader>
                    {selectedVersion && (
                        <div className="space-y-3 max-h-[60vh] overflow-y-auto">
                            {selectedVersion.resumen && (
                                <div className="rounded-md border p-3">
                                    <p className="text-xs text-muted-foreground mb-1">Resumen</p>
                                    <p className="text-sm">{selectedVersion.resumen}</p>
                                </div>
                            )}
                            <div className="rounded-md border p-3">
                                <p className="text-xs text-muted-foreground mb-1">Contenido</p>
                                <div className="whitespace-pre-line text-sm leading-6">{selectedVersion.contenido}</div>
                            </div>
                        </div>
                    )}
                    <DialogFooter>
                        <Button variant="outline" onClick={() => setSelectedVersion(null)}>Cerrar</Button>
                        {canManage && selectedVersion && (
                            <Button variant="secondary" onClick={() => {
                                if (window.confirm(`¿Restaurar el articulo a la version ${selectedVersion.version}? El estado actual se guardara como una nueva version.`)) {
                                    router.post(route('knowledge.versions.restore', [article.id, selectedVersion.id]), {}, { preserveScroll: true, onSuccess: () => setSelectedVersion(null) });
                                }
                            }}>
                                <RotateCcw className="size-4" /> Restaurar esta version
                            </Button>
                        )}
                    </DialogFooter>
                </DialogContent>
            </Dialog>

            <FilePickerDialog
                open={filesOpen}
                onOpenChange={setFilesOpen}
                title={`Archivos · ${article.titulo}`}
                description="Sube archivos relacionados a este articulo. Imagenes, PDF, documentos, hojas de calculo, texto, CSV y ZIP."
                storedFiles={files}
                tableId="knowledge_articles"
                relatedUuid={article.id}
                accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx,.xls,.xlsx,.txt,.csv,.zip"
                maxSizeHint="Maximo 10MB"
                onDownloadStoredFile={(file) => window.open(file.url, '_blank', 'noopener,noreferrer')}
                onDeleteStoredFile={canManage ? (fileId) => router.delete(route('files.destroy', fileId), { data: { related_table: 'knowledge_articles', related_uuid: article.id }, preserveScroll: true }) : undefined}
            />
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
