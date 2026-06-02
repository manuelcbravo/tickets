import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import { Bot, CheckCircle2, ClipboardList, FileText, Lightbulb, ShieldAlert, Sparkles, XCircle } from 'lucide-react';
import type { LucideIcon } from 'lucide-react';
import type React from 'react';
import { useEffect, useMemo, useState } from 'react';
import { toast } from 'sonner';
import { route } from 'ziggy-js';
import { CrudFormDialog } from '@/components/crud-form-dialog';
import { FormTextareaField } from '@/components/form-textarea-field';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, KnowledgeArticle, SharedData, TicketAiAction, TicketAiAnalysis, TicketAiConfig } from '@/types';

type TicketAiShow = {
    id: string;
    folio: string;
    titulo: string;
    descripcion: string;
    requires_code_change: boolean;
    requires_quote: boolean;
    cliente?: { nombre: string | null; razon_social: string | null } | null;
    proyecto?: { nombre: string } | null;
    modulo?: { nombre: string } | null;
    responsable?: { name: string } | null;
    tipo?: { nombre: string } | null;
    estado?: { nombre: string } | null;
    prioridad?: { nombre: string } | null;
    impacto?: { nombre: string } | null;
    urgencia?: { nombre: string } | null;
    riesgo?: { nombre: string } | null;
    knowledge_articles: KnowledgeArticle[];
    ai_analyses: TicketAiAnalysis[];
    ai_actions: TicketAiAction[];
};

const breadcrumbs = (ticket: TicketAiShow): BreadcrumbItem[] => [
    { title: 'Tickets', href: route('tickets.index') },
    { title: ticket.folio, href: route('tickets.show', ticket.id) },
    { title: 'IA asistente', href: route('tickets.ai.show', ticket.id) },
];

export default function TicketAiShow({ ticket, aiConfig }: { ticket: TicketAiShow; aiConfig: TicketAiConfig }) {
    const { flash, auth } = usePage<SharedData>().props;
    const [applyOpen, setApplyOpen] = useState(false);
    const [rejectOpen, setRejectOpen] = useState(false);
    const latest = ticket.ai_analyses[0] ?? null;
    const canAnalyze = auth.permissions?.some((permission) => ['tickets.ai', 'tickets.ai.analyze'].includes(permission)) ?? false;
    const canApply = auth.permissions?.some((permission) => ['tickets.ai', 'tickets.ai.apply'].includes(permission)) ?? false;

    const analyzeForm = useForm({ analysis_type: 'full', include_knowledge: true, include_comments: true });
    const applyForm = useForm({
        apply_type: true,
        apply_priority: true,
        apply_impact: true,
        apply_urgency: true,
        apply_risk: true,
        apply_difficulty: true,
        apply_flags: true,
        create_checklist: true,
        create_internal_comment: false,
        create_customer_reply_draft: false,
    });
    const rejectForm = useForm({ reason: '' });

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const usedArticles = useMemo(() => {
        const ids = latest?.raw_response?.metadata?.used_knowledge_article_ids ?? [];
        return ticket.knowledge_articles.filter((article) => ids.includes(article.id));
    }, [latest, ticket.knowledge_articles]);

    const runAnalyze = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        analyzeForm.post(route('tickets.ai.analyze', ticket.id), { preserveScroll: true });
    };

    const submitApply = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        if (!latest) return;
        applyForm.patch(route('tickets.ai.analysis.apply', [ticket.id, latest.id]), {
            preserveScroll: true,
            onSuccess: () => setApplyOpen(false),
        });
    };

    const submitReject = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        if (!latest) return;
        rejectForm.patch(route('tickets.ai.analysis.reject', [ticket.id, latest.id]), {
            preserveScroll: true,
            onSuccess: () => setRejectOpen(false),
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs(ticket)}>
            <Head title={`${ticket.folio} - IA asistente`} />
            <div className="space-y-4 rounded-xl p-4">
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
                    <div className="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <div className="flex flex-wrap gap-2">
                                <Badge variant="outline">{ticket.folio}</Badge>
                                <Badge>{ticket.estado?.nombre ?? '-'}</Badge>
                                <Badge variant={aiConfig.configured ? 'default' : 'destructive'}>{aiConfig.configured ? 'IA lista' : 'IA no configurada'}</Badge>
                                <Badge variant="outline">{aiConfig.model}</Badge>
                            </div>
                            <h1 className="mt-3 text-xl font-semibold">IA asistente</h1>
                            <p className="text-sm text-muted-foreground">{ticket.titulo}</p>
                        </div>
                        <Button asChild variant="outline"><Link href={route('tickets.show', ticket.id)}>Volver al ticket</Link></Button>
                    </div>
                </div>

                {!aiConfig.configured && (
                    <Card className="rounded-lg border-destructive/40">
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2"><ShieldAlert className="size-5" /> Configuracion pendiente</CardTitle>
                            <CardDescription>Define OPENAI_API_KEY y activa OPENAI_TICKETS_ENABLED para ejecutar analisis. El modulo permanece disponible sin romper el ticket.</CardDescription>
                        </CardHeader>
                    </Card>
                )}

                <Card className="rounded-lg">
                    <CardHeader>
                        <CardTitle>Ejecutar analisis</CardTitle>
                        <CardDescription>La IA solo sugiere. Un usuario humano decide que aplicar.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <form onSubmit={runAnalyze} className="grid gap-3 md:grid-cols-[220px_1fr_auto] md:items-end">
                            <div className="space-y-2">
                                <span className="text-sm font-medium">Tipo</span>
                                <Select value={analyzeForm.data.analysis_type} onValueChange={(value) => analyzeForm.setData('analysis_type', value)}>
                                    <SelectTrigger><SelectValue /></SelectTrigger>
                                    <SelectContent>
                                        {['full', 'summary', 'classification', 'missing_information', 'reply', 'checklist', 'knowledge_lookup'].map((type) => <SelectItem key={type} value={type}>{type}</SelectItem>)}
                                    </SelectContent>
                                </Select>
                            </div>
                            <div className="flex flex-wrap gap-4">
                                <label className="flex items-center gap-2 text-sm"><Checkbox checked={analyzeForm.data.include_knowledge} onCheckedChange={(value) => analyzeForm.setData('include_knowledge', Boolean(value))} /> Incluir conocimiento</label>
                                <label className="flex items-center gap-2 text-sm"><Checkbox checked={analyzeForm.data.include_comments} onCheckedChange={(value) => analyzeForm.setData('include_comments', Boolean(value))} /> Incluir comentarios</label>
                            </div>
                            <Button type="submit" disabled={!canAnalyze || analyzeForm.processing}><Sparkles className="size-4" /> Analizar ticket</Button>
                        </form>
                    </CardContent>
                </Card>

                {latest ? (
                    <div className="grid gap-4 xl:grid-cols-3">
                        <Card className="rounded-lg xl:col-span-2">
                            <CardHeader className="flex flex-row items-start justify-between space-y-0">
                                <div>
                                    <CardTitle>Ultimo analisis</CardTitle>
                                    <CardDescription>{latest.user?.name ?? 'Sistema'} · {formatDate(latest.executed_at ?? latest.created_at)}</CardDescription>
                                </div>
                                <div className="flex flex-wrap gap-2">
                                    <Badge variant={statusVariant(latest.status)}>{latest.status}</Badge>
                                    <Badge variant="outline">{confidence(latest.confidence)}</Badge>
                                </div>
                            </CardHeader>
                            <CardContent className="space-y-4">
                                {latest.error_message && <p className="rounded-md border border-destructive/40 p-3 text-sm text-destructive">{latest.error_message}</p>}
                                <InfoBlock icon={FileText} title="Resumen" text={latest.summary} />
                                <InfoBlock icon={Lightbulb} title="Problema detectado" text={latest.detected_problem} />
                                <div className="grid gap-3 md:grid-cols-2">
                                    <Suggestion label="Tipo" value={latest.suggested_type?.nombre} />
                                    <Suggestion label="Prioridad" value={latest.suggested_priority?.nombre} />
                                    <Suggestion label="Impacto" value={latest.suggested_impact?.nombre} />
                                    <Suggestion label="Urgencia" value={latest.suggested_urgency?.nombre} />
                                    <Suggestion label="Riesgo" value={latest.suggested_risk?.nombre} />
                                    <Suggestion label="Dificultad" value={latest.suggested_difficulty} />
                                </div>
                                <div className="flex flex-wrap gap-2">
                                    <Badge variant={latest.requires_code_change ? 'secondary' : 'outline'}>Cambio de codigo: {latest.requires_code_change ? 'Sugerido' : 'No sugerido'}</Badge>
                                    <Badge variant={latest.requires_quote ? 'secondary' : 'outline'}>Cotizacion: {latest.requires_quote ? 'Sugerida' : 'No sugerida'}</Badge>
                                    <Badge variant={latest.can_answer_directly ? 'secondary' : 'outline'}>Respuesta directa: {latest.can_answer_directly ? 'Posible' : 'Requiere revision'}</Badge>
                                </div>
                                <InfoBlock icon={Bot} title="Respuesta sugerida" text={latest.suggested_reply} />
                                <div className="flex flex-wrap gap-2">
                                    {canApply && latest.status === 'completed' && <Button onClick={() => setApplyOpen(true)}><CheckCircle2 className="size-4" /> Aplicar seleccion</Button>}
                                    {canApply && latest.status === 'completed' && <Button variant="outline" onClick={() => setRejectOpen(true)}><XCircle className="size-4" /> Rechazar</Button>}
                                </div>
                            </CardContent>
                        </Card>

                        <div className="space-y-4">
                            <ListCard title="Informacion faltante" empty="Sin faltantes sugeridos." items={(latest.missing_information ?? []).map((item) => `${item.label ?? item.key}${item.required ? ' (requerido)' : ''}${item.reason ? `: ${item.reason}` : ''}`)} />
                            <ListCard title="Checklist sugerido" empty="Sin checklist sugerido." items={(latest.suggested_checklist ?? []).map((item) => `${item.title ?? '-'}${item.required ? ' (requerido)' : ''}${item.description ? `: ${item.description}` : ''}`)} />
                            <Card className="rounded-lg">
                                <CardHeader><CardTitle>Conocimiento usado</CardTitle></CardHeader>
                                <CardContent className="space-y-2">
                                    {usedArticles.length === 0 ? <p className="text-sm text-muted-foreground">No se usaron articulos como contexto.</p> : usedArticles.map((article) => (
                                        <Link key={article.id} className="block rounded-md border p-3 text-sm font-medium text-primary hover:underline" href={route('knowledge.show', article.id)}>{article.titulo}</Link>
                                    ))}
                                </CardContent>
                            </Card>
                        </div>
                    </div>
                ) : (
                    <Card className="rounded-lg">
                        <CardContent className="p-6 text-sm text-muted-foreground">Aun no hay analisis de IA para este ticket.</CardContent>
                    </Card>
                )}

                <Card className="rounded-lg">
                    <CardHeader><CardTitle>Historial IA</CardTitle></CardHeader>
                    <CardContent className="space-y-2">
                        {ticket.ai_analyses.length === 0 ? <p className="text-sm text-muted-foreground">Sin analisis.</p> : ticket.ai_analyses.map((analysis) => (
                            <div key={analysis.id} className="flex flex-col gap-2 rounded-md border p-3 text-sm md:flex-row md:items-center md:justify-between">
                                <div>
                                    <p className="font-medium">{analysis.analysis_type}</p>
                                    <p className="text-muted-foreground">{formatDate(analysis.executed_at ?? analysis.created_at)} · {analysis.user?.name ?? 'Sistema'}</p>
                                </div>
                                <div className="flex gap-2">
                                    <Badge variant={statusVariant(analysis.status)}>{analysis.status}</Badge>
                                    <Badge variant="outline">{confidence(analysis.confidence)}</Badge>
                                </div>
                            </div>
                        ))}
                    </CardContent>
                </Card>

                <Card className="rounded-lg">
                    <CardHeader><CardTitle>Acciones sugeridas</CardTitle></CardHeader>
                    <CardContent className="space-y-2">
                        {ticket.ai_actions.length === 0 ? <p className="text-sm text-muted-foreground">Sin acciones.</p> : ticket.ai_actions.map((action) => (
                            <div key={action.id} className="flex flex-col gap-2 rounded-md border p-3 text-sm md:flex-row md:items-center md:justify-between">
                                <div>
                                    <p className="font-medium">{action.title ?? action.type}</p>
                                    <p className="text-muted-foreground">{action.type} · {formatDate(action.created_at)}</p>
                                </div>
                                <Badge variant={statusVariant(action.status)}>{action.status}</Badge>
                            </div>
                        ))}
                    </CardContent>
                </Card>
            </div>

            <CrudFormDialog open={applyOpen} onOpenChange={setApplyOpen} title="Aplicar sugerencias IA" description="Elige explicitamente que cambios aplicar. La IA no cierra tickets ni responde automaticamente." processing={applyForm.processing} submitLabel="Aplicar seleccion" onSubmit={submitApply}>
                {[
                    ['apply_type', 'Tipo'],
                    ['apply_priority', 'Prioridad'],
                    ['apply_impact', 'Impacto'],
                    ['apply_urgency', 'Urgencia'],
                    ['apply_risk', 'Riesgo'],
                    ['apply_difficulty', 'Dificultad'],
                    ['apply_flags', 'Flags codigo/cotizacion'],
                    ['create_checklist', 'Crear checklist sugerido'],
                    ['create_internal_comment', 'Guardar resumen como comentario interno'],
                    ['create_customer_reply_draft', 'Guardar respuesta sugerida como borrador interno'],
                ].map(([field, label]) => (
                    <label key={field} className="flex items-center gap-2 text-sm">
                        <Checkbox checked={Boolean(applyForm.data[field as keyof typeof applyForm.data])} onCheckedChange={(value) => applyForm.setData(field as keyof typeof applyForm.data, Boolean(value))} />
                        {label}
                    </label>
                ))}
            </CrudFormDialog>

            <CrudFormDialog open={rejectOpen} onOpenChange={setRejectOpen} title="Rechazar sugerencia IA" description="Opcionalmente registra el motivo para auditoria." processing={rejectForm.processing} submitLabel="Rechazar" onSubmit={submitReject}>
                <FormTextareaField id="ai-reject-reason" label="Motivo" value={rejectForm.data.reason} error={rejectForm.errors.reason} onChange={(event) => rejectForm.setData('reason', event.target.value)} />
            </CrudFormDialog>
        </AppLayout>
    );
}

function InfoBlock({ icon: Icon, title, text }: { icon: LucideIcon; title: string; text?: string | null }) {
    return (
        <div className="rounded-md border p-3">
            <div className="mb-2 flex items-center gap-2 text-sm font-medium"><Icon className="size-4" /> {title}</div>
            <p className="whitespace-pre-line text-sm text-muted-foreground">{text || '-'}</p>
        </div>
    );
}

function Suggestion({ label, value }: { label: string; value?: string | null }) {
    return <div className="rounded-md border p-3"><p className="text-xs text-muted-foreground">{label}</p><p className="text-sm font-medium">{value || '-'}</p></div>;
}

function ListCard({ title, empty, items }: { title: string; empty: string; items: string[] }) {
    return (
        <Card className="rounded-lg">
            <CardHeader><CardTitle className="flex items-center gap-2"><ClipboardList className="size-5" /> {title}</CardTitle></CardHeader>
            <CardContent className="space-y-2">
                {items.length === 0 ? <p className="text-sm text-muted-foreground">{empty}</p> : items.map((item, index) => <div key={`${item}-${index}`} className="rounded-md border p-2 text-sm">{item}</div>)}
            </CardContent>
        </Card>
    );
}

function confidence(value?: string | number | null) {
    if (value === null || value === undefined || value === '') return 'Sin confianza';
    return `${Math.round(Number(value) * 100)}%`;
}

function formatDate(value?: string | null) {
    return value ? new Date(value).toLocaleString('es-MX') : '-';
}

function statusVariant(status: string): 'default' | 'secondary' | 'destructive' | 'outline' {
    if (['failed', 'rejected'].includes(status)) return 'destructive';
    if (['completed', 'applied', 'approved'].includes(status)) return 'default';
    if (['processing', 'pending_review'].includes(status)) return 'secondary';
    return 'outline';
}
