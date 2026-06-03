import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import { AlertTriangle, BookOpen, Bot, CheckCircle2, CircleDollarSign, Clock, Code2, Download, ExternalLink, FileArchive, FolderKanban, GitBranch, Link2, Mail, MessageSquareText, Pencil, Plus, RefreshCcw, Rocket, ShieldCheck, Sparkles, Stethoscope, Trash2, UserRound, XCircle } from 'lucide-react';
import type React from 'react';
import { useEffect, useState } from 'react';
import { toast } from 'sonner';
import { route } from 'ziggy-js';
import { CrudFormDialog } from '@/components/crud-form-dialog';
import { FilePickerDialog } from '@/components/file-picker-dialog';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Field, FieldError } from '@/components/ui/field';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, CatalogOption, KnowledgeArticle, SharedData, TicketAiAction, TicketAiAnalysis, TicketAiConfig, TicketChecklistItem, TicketMissingInformationItem, TicketOptionProps, TicketRelation, TicketSla, TicketTiempo, UserOption } from '@/types';

type TicketShow = {
    id: string;
    folio: string;
    titulo: string;
    descripcion: string;
    dificultad: string | null;
    fecha_objetivo: string | null;
    tiempo_estimado_min: number | null;
    tiempo_real_min: number;
    priority_score: number | null;
    triage_notes: string | null;
    missing_information: TicketMissingInformationItem[] | null;
    triage_completed_at: string | null;
    prioritized_at: string | null;
    requires_code_change: boolean;
    requires_quote: boolean;
    quote_status?: string | null;
    is_internal: boolean;
    resolution: string | null;
    closed_at: string | null;
    resuelto_at: string | null;
    cliente?: { id?: string; nombre: string | null; razon_social: string | null } | null;
    proyecto?: { id?: string; nombre: string; billing_status?: string | null; saldo_pendiente?: string | number | null; saldo_vencido?: string | number | null; ultimo_pago_at?: string | null; proximo_vencimiento_at?: string | null } | null;
    modulo?: { nombre: string } | null;
    contacto?: { nombre: string; email: string | null } | null;
    ambiente?: { nombre: string; url: string | null } | null;
    responsable?: { id: number; name: string } | null;
    triage_by?: { name: string } | null;
    prioritized_by?: { name: string } | null;
    tipo?: CatalogOption | null;
    estado?: CatalogOption | null;
    prioridad?: CatalogOption | null;
    impacto?: CatalogOption | null;
    urgencia?: CatalogOption | null;
    riesgo?: CatalogOption | null;
    mensajes: TicketMessage[];
    adjuntos: TicketAttachment[];
    historial: TicketLog[];
    checklist_items: TicketChecklistItem[];
    relaciones_origen: TicketRelation[];
    tiempos: TicketTiempo[];
    sla?: TicketSla | null;
    knowledge_articles: KnowledgeArticle[];
    ai_analyses: TicketAiAnalysis[];
    ai_actions: TicketAiAction[];
    development_status?: string | null;
    has_code_changes: boolean;
    development_tasks: TicketDevelopmentTask[];
    proyecto_actividades: ProyectoActividad[];
    development_links: TicketDevelopmentLink[];
    releases: TicketRelease[];
    qa_status?: string | null;
    qa_approved_at?: string | null;
    validated_at?: string | null;
    reopen_count: number;
    qa_approved_by?: { name: string } | null;
    validated_by?: { name: string } | null;
    test_cases: TicketTestCase[];
    test_results: TicketTestResult[];
    test_evidences: TicketTestEvidence[];
    validations: TicketValidation[];
    reopen_logs: TicketReopenLog[];
    cotizacion_principal?: TicketQuote | null;
    cotizaciones: TicketQuote[];
    billing_warning_acknowledged_at?: string | null;
    notification_logs: TicketNotificationLog[];
    webhook_events: TicketWebhookEvent[];
    external_messages: TicketExternalMessage[];
};

type TicketMessage = {
    id: string;
    mensaje: string;
    es_interno: boolean;
    es_respuesta_cliente: boolean;
    created_at: string;
    usuario?: { name: string } | null;
};

type TicketAttachment = {
    id: string;
    nombre_original: string;
    ruta: string;
    url: string;
    mime_type: string | null;
    size: number;
    created_at: string;
    usuario?: { name: string } | null;
};

type TicketLog = {
    id: string;
    accion: string;
    campo: string | null;
    valor_anterior: string | null;
    valor_nuevo: string | null;
    descripcion: string | null;
    created_at: string;
    usuario?: { name: string } | null;
};

type TicketRepository = {
    id: string;
    proyecto_id: string;
    nombre: string;
    url: string;
    rama_principal: string;
    activo: boolean;
};

type TicketDevelopmentTask = {
    id: string;
    titulo: string;
    descripcion: string | null;
    tipo: string;
    estado: string;
    prioridad: string | null;
    branch_name: string | null;
    pull_request_url: string | null;
    commit_hash: string | null;
    estimacion_min: number | null;
    tiempo_real_min: number;
    reviewed_at: string | null;
    repositorio?: { id: string; nombre: string; url: string } | null;
    asignado_a?: { id: number; name: string } | null;
    reviewed_by?: { id: number; name: string } | null;
};

type ProyectoActividad = {
    id: string;
    titulo: string;
    tipo: string;
    estado: string;
    prioridad: string;
    fecha_limite: string | null;
    minutos_estimados: number | null;
    minutos_reales: number;
    proyecto?: { id: string; nombre: string } | null;
    responsable?: { id: number; name: string } | null;
    pivot?: { tipo_relacion?: string | null } | null;
};

type TicketDevelopmentLink = {
    id: string;
    tipo: string;
    titulo: string | null;
    url: string | null;
    referencia: string | null;
    created_at: string;
    created_by?: { name: string } | null;
};

type TicketRelease = {
    id: string;
    nombre: string;
    version: string | null;
    estado: string;
    scheduled_at: string | null;
    released_at: string | null;
    ambiente?: { nombre: string } | null;
};

type TicketTestCase = {
    id: string;
    titulo: string;
    descripcion: string | null;
    pasos: string | null;
    resultado_esperado: string | null;
    tipo: string;
    prioridad: string | null;
    activo: boolean;
};

type TicketTestResult = {
    id: string;
    titulo: string;
    pasos: string | null;
    resultado_esperado: string | null;
    resultado_obtenido: string | null;
    status: string;
    notas: string | null;
    executed_at: string | null;
    test_case?: { id: string; titulo: string } | null;
    development_task?: { id: string; titulo: string } | null;
    executed_by?: { name: string } | null;
};

type TicketTestEvidence = {
    id: string;
    titulo: string | null;
    descripcion: string | null;
    tipo: string | null;
    url: string | null;
    created_at: string;
    test_result?: { id: string; titulo: string } | null;
    adjunto?: { id: string; nombre_original: string; url: string } | null;
    uploaded_by?: { name: string } | null;
};

type TicketValidation = {
    id: string;
    tipo: string;
    status: string;
    comentario: string | null;
    validated_at: string | null;
    validated_by?: { name: string } | null;
};

type TicketReopenLog = {
    id: string;
    reason: string;
    root_cause: string | null;
    notes: string | null;
    created_at: string;
    previous_closed_at: string | null;
    reopened_by?: { name: string } | null;
};

type TicketQuote = {
    id: string;
    folio: string;
    titulo: string;
    estado: string;
    total: string | number;
    pivot?: { tipo_relacion?: string | null } | null;
};

type QaOptions = {
    testCaseTypes: string[];
    testResultStatuses: string[];
    evidenceTypes: string[];
    validationTypes: string[];
    rootCauses: string[];
    requiresQa: boolean;
    closeBlockers: string[];
};

type QuoteOptions = {
    relatedQuotes: TicketQuote[];
};

type IntegrationOptions = {
    mailEnabled: boolean;
};

type BillingOptions = {
    overdueCharges: {
        id: string;
        folio: string;
        concepto: string;
        fecha_vencimiento: string;
        saldo: string | number;
    }[];
};

type TicketNotificationLog = {
    id: string;
    channel: string;
    direction: string;
    recipient: string | null;
    subject: string | null;
    status: string;
    sent_at: string | null;
    created_at: string;
};

type TicketWebhookEvent = {
    id: string;
    provider: string;
    event_type: string | null;
    external_id: string | null;
    status: string;
    created_at: string;
};

type TicketExternalMessage = {
    id: string;
    channel: string;
    direction: string;
    sender: string | null;
    recipient: string | null;
    message: string | null;
    created_at: string;
};

export default function TicketsShow({ ticket, estados, users, contactos, knowledgeArticles, aiConfig, repositories, developmentTaskOptions, qaOptions, quoteOptions, integrationOptions, billingOptions }: TicketOptionProps & { ticket: TicketShow; knowledgeArticles: KnowledgeArticle[]; aiConfig: TicketAiConfig; repositories: TicketRepository[]; developmentTaskOptions: { types: string[]; statuses: string[] }; qaOptions: QaOptions; quoteOptions: QuoteOptions; integrationOptions: IntegrationOptions; billingOptions: BillingOptions }) {
    const [commentOpen, setCommentOpen] = useState(false);
    const [assignOpen, setAssignOpen] = useState(false);
    const [statusOpen, setStatusOpen] = useState(false);
    const [closeOpen, setCloseOpen] = useState(false);
    const [reopenOpen, setReopenOpen] = useState(false);
    const [filesOpen, setFilesOpen] = useState(false);
    const [timeOpen, setTimeOpen] = useState(false);
    const [editTime, setEditTime] = useState<TicketTiempo | null>(null);
    const [knowledgeOpen, setKnowledgeOpen] = useState(false);
    const [taskOpen, setTaskOpen] = useState(false);
    const [editTask, setEditTask] = useState<TicketDevelopmentTask | null>(null);
    const [linkOpen, setLinkOpen] = useState(false);
    const [testCaseOpen, setTestCaseOpen] = useState(false);
    const [editTestCase, setEditTestCase] = useState<TicketTestCase | null>(null);
    const [testResultOpen, setTestResultOpen] = useState(false);
    const [editTestResult, setEditTestResult] = useState<TicketTestResult | null>(null);
    const [evidenceOpen, setEvidenceOpen] = useState(false);
    const [validationOpen, setValidationOpen] = useState(false);
    const [emailOpen, setEmailOpen] = useState(false);
    const { flash, auth } = usePage<SharedData>().props;
    const canManage = auth.permissions?.includes('tickets.manage') ?? false;
    const canAssign = auth.permissions?.includes('tickets.assign') ?? false;
    const canClose = auth.permissions?.includes('tickets.close') ?? false;
    const canTriage = (auth.permissions?.includes('tickets.triage') || auth.permissions?.includes('tickets.manage')) ?? false;
    const canViewTime = (auth.permissions?.includes('tickets.time.view') || auth.permissions?.includes('tickets.time.manage')) ?? false;
    const canManageTime = auth.permissions?.includes('tickets.time.manage') ?? false;
    const canManageSla = auth.permissions?.includes('tickets.sla.manage') ?? false;
    const canViewKnowledge = (auth.permissions?.includes('knowledge.view') || auth.permissions?.includes('knowledge.manage')) ?? false;
    const canCreateKnowledge = (auth.permissions?.includes('knowledge.create') || auth.permissions?.includes('tickets.manage')) ?? false;
    const canLinkKnowledge = (auth.permissions?.includes('knowledge.link') || auth.permissions?.includes('tickets.manage')) ?? false;
    const canViewAi = auth.permissions?.some((permission) => ['tickets.ai', 'tickets.ai.view'].includes(permission)) ?? false;
    const canAnalyzeAi = auth.permissions?.some((permission) => ['tickets.ai', 'tickets.ai.analyze'].includes(permission)) ?? false;
    const canViewDevelopment = auth.permissions?.some((permission) => ['tickets.development.view', 'tickets.development.manage', 'development.view', 'development.manage'].includes(permission)) ?? false;
    const canManageDevelopment = auth.permissions?.some((permission) => ['tickets.development.manage', 'development.manage'].includes(permission)) ?? false;
    const canViewQa = auth.permissions?.some((permission) => ['tickets.qa.view', 'tickets.qa.manage'].includes(permission)) ?? false;
    const canManageQa = auth.permissions?.includes('tickets.qa.manage') ?? false;
    const canApproveQa = auth.permissions?.some((permission) => ['tickets.qa.approve', 'tickets.qa.manage'].includes(permission)) ?? false;
    const canRejectQa = auth.permissions?.some((permission) => ['tickets.qa.reject', 'tickets.qa.manage'].includes(permission)) ?? false;
    const canEvidenceQa = auth.permissions?.some((permission) => ['tickets.qa.evidence', 'tickets.qa.manage'].includes(permission)) ?? false;
    const canQuote = auth.permissions?.some((permission) => ['tickets.quote', 'quotes.create', 'quotes.manage'].includes(permission)) ?? false;
    const canViewTicketNotifications = auth.permissions?.some((permission) => ['tickets.notifications.view', 'tickets.notifications.manage'].includes(permission)) ?? false;
    const canManageTicketNotifications = auth.permissions?.includes('tickets.notifications.manage') ?? false;

    const commentForm = useForm({ mensaje: '', es_interno: true, es_respuesta_cliente: false });
    const assignForm = useForm({ responsable_id: ticket.responsable ? String(ticket.responsable.id) : '' });
    const statusForm = useForm({ estado_id: ticket.estado ? String(ticket.estado.id) : '' });
    const closeForm = useForm({ resolution: ticket.resolution ?? '', force_close: false, force_reason: '' });
    const reopenForm = useForm({ reason: '', root_cause: '', notes: '' });
    const knowledgeForm = useForm({ knowledge_article_id: '', tipo_relacion: 'relacionado', notas: '' });
    const emailForm = useForm({
        contacto_id: ticket.contacto?.email ? (contactos.find((contacto) => contacto.email === ticket.contacto?.email)?.id ?? '') : '',
        recipient: ticket.contacto?.email ?? '',
        subject: `Actualizacion ${ticket.folio} - ${ticket.titulo}`,
        message: '',
        save_as_public_comment: false,
    });
    const billingWarningForm = useForm({ notes: '' });
    const timeForm = useForm({
        descripcion: '',
        minutos: '',
        fecha: new Date().toISOString().slice(0, 10),
        es_facturable: false,
        iniciado_at: '',
        terminado_at: '',
    });
    const taskForm = useForm({
        proyecto_id: ticket.proyecto ? ticket.proyecto.id ?? '' : '',
        repositorio_id: '',
        asignado_a_id: '',
        titulo: '',
        descripcion: '',
        tipo: 'bugfix',
        estado: 'pendiente',
        prioridad: '',
        branch_name: '',
        pull_request_url: '',
        commit_hash: '',
        estimacion_min: '',
        tiempo_real_min: '0',
    });
    const linkForm = useForm({
        development_task_id: '',
        tipo: 'pull_request',
        titulo: '',
        url: '',
        referencia: '',
    });
    const testCaseForm = useForm({
        titulo: '',
        descripcion: '',
        pasos: '',
        resultado_esperado: '',
        tipo: 'manual',
        prioridad: '',
        activo: true,
    });
    const testResultForm = useForm({
        test_case_id: '',
        development_task_id: '',
        titulo: '',
        pasos: '',
        resultado_esperado: '',
        resultado_obtenido: '',
        status: 'pendiente',
        notas: '',
    });
    const evidenceForm = useForm({
        test_result_id: '',
        adjunto_id: '',
        titulo: '',
        descripcion: '',
        tipo: 'captura',
        url: '',
    });
    const validationForm = useForm({
        tipo: 'qa',
        status: 'pendiente',
        comentario: '',
    });

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Tickets', href: route('tickets.index') },
        { title: ticket.folio, href: route('tickets.show', ticket.id) },
    ];

    const submitComment = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        commentForm.post(route('tickets.messages.store', ticket.id), {
            preserveScroll: true,
            onSuccess: () => {
                setCommentOpen(false);
                commentForm.reset();
            },
        });
    };

    const uploadFiles = (files: File[]) => {
        files.forEach((file) => {
            router.post(route('tickets.attachments.store', ticket.id), { archivo: file }, {
                forceFormData: true,
                preserveScroll: true,
                onError: () => toast.error(`No se pudo subir ${file.name}`),
            });
        });
    };

    const openTimeDialog = (tiempo?: TicketTiempo) => {
        setEditTime(tiempo ?? null);
        timeForm.setData({
            descripcion: tiempo?.descripcion ?? '',
            minutos: tiempo ? String(tiempo.minutos) : '',
            fecha: tiempo?.fecha ? tiempo.fecha.slice(0, 10) : new Date().toISOString().slice(0, 10),
            es_facturable: tiempo?.es_facturable ?? false,
            iniciado_at: tiempo?.iniciado_at ? tiempo.iniciado_at.slice(0, 16) : '',
            terminado_at: tiempo?.terminado_at ? tiempo.terminado_at.slice(0, 16) : '',
        });
        timeForm.clearErrors();
        setTimeOpen(true);
    };

    const submitTime = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        const options = {
            preserveScroll: true,
            onSuccess: () => {
                setTimeOpen(false);
                setEditTime(null);
                timeForm.reset();
            },
        };

        if (editTime) {
            timeForm.patch(route('tickets.times.update', [ticket.id, editTime.id]), options);
            return;
        }

        timeForm.post(route('tickets.times.store', ticket.id), options);
    };

    const totals = ticket.tiempos.reduce(
        (acc, tiempo) => {
            acc.total += tiempo.minutos;
            if (tiempo.es_facturable) acc.facturable += tiempo.minutos;
            else acc.noFacturable += tiempo.minutos;
            return acc;
        },
        { total: 0, facturable: 0, noFacturable: 0 },
    );

    const submitKnowledgeLink = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        knowledgeForm.post(route('tickets.knowledge.link', ticket.id), {
            preserveScroll: true,
            onSuccess: () => {
                setKnowledgeOpen(false);
                knowledgeForm.reset();
            },
        });
    };

    const openTaskDialog = (task?: TicketDevelopmentTask) => {
        setEditTask(task ?? null);
        taskForm.clearErrors();
        taskForm.setData({
            proyecto_id: ticket.proyecto?.id ?? '',
            repositorio_id: task?.repositorio?.id ?? '',
            asignado_a_id: task?.asignado_a ? String(task.asignado_a.id) : '',
            titulo: task?.titulo ?? '',
            descripcion: task?.descripcion ?? '',
            tipo: task?.tipo ?? 'bugfix',
            estado: task?.estado ?? 'pendiente',
            prioridad: task?.prioridad ?? '',
            branch_name: task?.branch_name ?? '',
            pull_request_url: task?.pull_request_url ?? '',
            commit_hash: task?.commit_hash ?? '',
            estimacion_min: task?.estimacion_min ? String(task.estimacion_min) : '',
            tiempo_real_min: task ? String(task.tiempo_real_min) : '0',
        });
        setTaskOpen(true);
    };

    const submitTask = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        const options = {
            preserveScroll: true,
            onSuccess: () => {
                setTaskOpen(false);
                setEditTask(null);
                taskForm.reset();
            },
        };

        if (editTask) {
            taskForm.patch(route('tickets.development.tasks.update', [ticket.id, editTask.id]), options);
            return;
        }

        taskForm.post(route('tickets.development.tasks.store', ticket.id), options);
    };

    const submitDevelopmentLink = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        linkForm.post(route('tickets.development.links.store', ticket.id), {
            preserveScroll: true,
            onSuccess: () => {
                setLinkOpen(false);
                linkForm.reset();
            },
        });
    };

    const openTestCaseDialog = (testCase?: TicketTestCase) => {
        setEditTestCase(testCase ?? null);
        testCaseForm.clearErrors();
        testCaseForm.setData({
            titulo: testCase?.titulo ?? '',
            descripcion: testCase?.descripcion ?? '',
            pasos: testCase?.pasos ?? '',
            resultado_esperado: testCase?.resultado_esperado ?? '',
            tipo: testCase?.tipo ?? 'manual',
            prioridad: testCase?.prioridad ?? '',
            activo: testCase?.activo ?? true,
        });
        setTestCaseOpen(true);
    };

    const submitTestCase = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        const options = {
            preserveScroll: true,
            onSuccess: () => {
                setTestCaseOpen(false);
                setEditTestCase(null);
                testCaseForm.reset();
            },
        };

        if (editTestCase) {
            testCaseForm.patch(route('tickets.qa.test-cases.update', [ticket.id, editTestCase.id]), options);
            return;
        }

        testCaseForm.post(route('tickets.qa.test-cases.store', ticket.id), options);
    };

    const openTestResultDialog = (result?: TicketTestResult) => {
        setEditTestResult(result ?? null);
        testResultForm.clearErrors();
        testResultForm.setData({
            test_case_id: result?.test_case?.id ?? '',
            development_task_id: result?.development_task?.id ?? '',
            titulo: result?.titulo ?? '',
            pasos: result?.pasos ?? '',
            resultado_esperado: result?.resultado_esperado ?? '',
            resultado_obtenido: result?.resultado_obtenido ?? '',
            status: result?.status ?? 'pendiente',
            notas: result?.notas ?? '',
        });
        setTestResultOpen(true);
    };

    const submitTestResult = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        const options = {
            preserveScroll: true,
            onSuccess: () => {
                setTestResultOpen(false);
                setEditTestResult(null);
                testResultForm.reset();
            },
        };

        if (editTestResult) {
            testResultForm.patch(route('tickets.qa.test-results.update', [ticket.id, editTestResult.id]), options);
            return;
        }

        testResultForm.post(route('tickets.qa.test-results.store', ticket.id), options);
    };

    const submitEvidence = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        evidenceForm.post(route('tickets.qa.evidences.store', ticket.id), {
            preserveScroll: true,
            onSuccess: () => {
                setEvidenceOpen(false);
                evidenceForm.reset();
            },
        });
    };

    const submitValidation = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        validationForm.post(route('tickets.qa.validations.store', ticket.id), {
            preserveScroll: true,
            onSuccess: () => {
                setValidationOpen(false);
                validationForm.reset();
            },
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`${ticket.folio} - ${ticket.titulo}`} />
            <div className="space-y-4 rounded-xl p-4">
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
                    <div className="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <div className="flex flex-wrap items-center gap-2">
                                <Badge variant="outline">{ticket.folio}</Badge>
                                <Badge>{ticket.estado?.nombre ?? '-'}</Badge>
                                <Badge variant={ticket.prioridad?.nombre?.startsWith('P0') ? 'destructive' : 'secondary'}>{ticket.prioridad?.nombre ?? '-'}</Badge>
                                <Badge variant="outline">{ticket.tipo?.nombre ?? '-'}</Badge>
                            </div>
                            <h1 className="mt-3 text-xl font-semibold">{ticket.titulo}</h1>
                            <p className="text-sm text-muted-foreground">
                                {ticket.cliente?.nombre ?? ticket.cliente?.razon_social ?? '-'} · {ticket.proyecto?.nombre ?? 'Sin proyecto'} · Responsable: {ticket.responsable?.name ?? 'Sin asignar'}
                            </p>
                        </div>
                        <div className="flex flex-wrap gap-2">
                            <Button asChild variant="outline"><Link href={route('tickets.index')}>Volver</Link></Button>
                            {canManage && <Button asChild variant="outline"><Link href={route('tickets.edit', ticket.id)}><Pencil className="size-4" /> Editar</Link></Button>}
                            {canClose && !ticket.closed_at && <Button onClick={() => setCloseOpen(true)}><XCircle className="size-4" /> Cerrar</Button>}
                            {canClose && ticket.closed_at && <Button onClick={() => setReopenOpen(true)}><RefreshCcw className="size-4" /> Reabrir</Button>}
                        </div>
                    </div>
                </div>

                {(canTriage || canAssign || canManage) && (
                    <Card className="rounded-lg">
                        <CardHeader><CardTitle>Acciones de seguimiento</CardTitle><CardDescription>Operaciones contextuales del flujo del ticket.</CardDescription></CardHeader>
                        <CardContent className="flex flex-wrap gap-2">
                            {canTriage && <Button asChild variant="outline"><Link href={route('tickets.triage.show', ticket.id)}><Stethoscope className="size-4" /> Triage</Link></Button>}
                            {canAssign && <Button variant="outline" onClick={() => setAssignOpen(true)}><UserRound className="size-4" /> Asignar</Button>}
                            {canManage && <Button variant="outline" onClick={() => setStatusOpen(true)}><RefreshCcw className="size-4" /> Cambiar estado</Button>}
                        </CardContent>
                    </Card>
                )}

                {Number(ticket.proyecto?.saldo_vencido ?? 0) > 0 && (
                    <Card className="rounded-lg border-destructive/40 bg-destructive/5">
                        <CardContent className="space-y-3 p-4">
                            <div className="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                                <div className="flex gap-3">
                                    <AlertTriangle className="mt-0.5 size-5 text-destructive" />
                                    <div>
                                        <p className="font-medium">Este proyecto tiene pagos vencidos.</p>
                                        <p className="text-sm text-muted-foreground">Revisa cobranza antes de continuar. Esta alerta no bloquea la atencion del ticket.</p>
                                    </div>
                                </div>
                                <div className="flex flex-wrap gap-2">
                                    {ticket.proyecto?.id && <Button asChild variant="outline"><Link href={route('proyectos.show', ticket.proyecto.id)}>Ver cobranza</Link></Button>}
                                    {canManage && !ticket.billing_warning_acknowledged_at && (
                                        <Button
                                            variant="outline"
                                            onClick={() => billingWarningForm.patch(route('tickets.billing-warning.acknowledge', ticket.id), { preserveScroll: true })}
                                            disabled={billingWarningForm.processing}
                                        >
                                            Reconocer alerta
                                        </Button>
                                    )}
                                </div>
                            </div>
                            <div className="grid gap-3 text-sm md:grid-cols-4">
                                <Info label="Saldo vencido" value={formatCurrency(ticket.proyecto?.saldo_vencido ?? 0)} />
                                <Info label="Saldo pendiente" value={formatCurrency(ticket.proyecto?.saldo_pendiente ?? 0)} />
                                <Info label="Ultimo pago" value={ticket.proyecto?.ultimo_pago_at ? new Date(ticket.proyecto.ultimo_pago_at).toLocaleDateString('es-MX') : null} />
                                <Info label="Proximo vencimiento" value={ticket.proyecto?.proximo_vencimiento_at ? new Date(ticket.proyecto.proximo_vencimiento_at).toLocaleDateString('es-MX') : null} />
                            </div>
                            {billingOptions.overdueCharges.length > 0 && (
                                <div className="grid gap-2">
                                    {billingOptions.overdueCharges.map((charge) => (
                                        <div key={charge.id} className="flex flex-col justify-between gap-1 rounded-md border bg-background p-3 text-sm md:flex-row md:items-center">
                                            <span className="font-medium">{charge.folio} - {charge.concepto}</span>
                                            <span className="text-muted-foreground">Vence {new Date(charge.fecha_vencimiento).toLocaleDateString('es-MX')} - {formatCurrency(charge.saldo)}</span>
                                        </div>
                                    ))}
                                </div>
                            )}
                        </CardContent>
                    </Card>
                )}

                <div className="grid gap-4 lg:grid-cols-3">
                    <Card className="rounded-lg lg:col-span-2">
                        <CardHeader><CardTitle>Informacion general</CardTitle></CardHeader>
                        <CardContent className="space-y-4">
                            <p className="whitespace-pre-line text-sm">{ticket.descripcion}</p>
                            <div className="grid gap-3 md:grid-cols-2">
                                <Info label="Impacto" value={ticket.impacto?.nombre} />
                                <Info label="Urgencia" value={ticket.urgencia?.nombre} />
                                <Info label="Riesgo" value={ticket.riesgo?.nombre} />
                                <Info label="Dificultad" value={ticket.dificultad} />
                                <Info label="Fecha objetivo" value={ticket.fecha_objetivo ? new Date(ticket.fecha_objetivo).toLocaleString('es-MX') : null} />
                                <Info label="Tiempo estimado" value={ticket.tiempo_estimado_min ? `${ticket.tiempo_estimado_min} min` : null} />
                                <Info label="Tiempo real" value={`${ticket.tiempo_real_min} min`} />
                                <Info label="Modulo" value={ticket.modulo?.nombre} />
                                <Info label="Ambiente" value={ticket.ambiente?.nombre} />
                                <Info label="Contacto" value={ticket.contacto?.nombre} />
                            </div>
                            <div className="flex flex-wrap gap-2">
                                <Badge variant={ticket.requires_code_change ? 'secondary' : 'outline'}>Codigo: {ticket.requires_code_change ? 'Si' : 'No'}</Badge>
                                <Badge variant={ticket.requires_quote ? 'secondary' : 'outline'}>Cotizacion: {ticket.requires_quote ? 'Si' : 'No'}</Badge>
                                <Badge variant={ticket.is_internal ? 'secondary' : 'outline'}>{ticket.is_internal ? 'Interno' : 'Publico'}</Badge>
                            </div>
                            {ticket.resolution && (
                                <div className="rounded-md border p-3">
                                    <p className="text-sm font-medium">Resolucion</p>
                                    <p className="whitespace-pre-line text-sm text-muted-foreground">{ticket.resolution}</p>
                                </div>
                            )}
                        </CardContent>
                    </Card>

                    <Card className="rounded-lg">
                        <CardHeader>
                            <CardTitle>Adjuntos</CardTitle>
                            <CardDescription>{ticket.adjuntos.length} archivos</CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-3">
                            <Button className="w-full" onClick={() => setFilesOpen(true)}><FileArchive className="size-4" /> Gestionar adjuntos</Button>
                            {ticket.adjuntos.slice(0, 5).map((file) => (
                                <div key={file.id} className="flex items-center justify-between rounded-md border p-2 text-sm">
                                    <div className="min-w-0">
                                        <p className="truncate font-medium">{file.nombre_original}</p>
                                        <p className="text-xs text-muted-foreground">{file.usuario?.name ?? '-'} · {(file.size / 1024).toFixed(0)} KB</p>
                                    </div>
                                    <Button asChild variant="ghost" size="icon-sm"><a href={route('tickets.attachments.download', [ticket.id, file.id])}><Download className="size-4" /></a></Button>
                                </div>
                            ))}
                        </CardContent>
                    </Card>

                    <Card className="rounded-lg">
                        <CardHeader>
                            <CardTitle>Triage</CardTitle>
                            <CardDescription>Clasificacion y prioridad final.</CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-3">
                            <Info label="Score" value={ticket.priority_score !== null ? String(ticket.priority_score) : null} />
                            <Info label="Triaged by" value={ticket.triage_by?.name} />
                            <Info label="Triaged at" value={ticket.triage_completed_at ? new Date(ticket.triage_completed_at).toLocaleString('es-MX') : null} />
                            <Info label="Priorizado by" value={ticket.prioritized_by?.name} />
                            {ticket.triage_notes && <Info label="Notas" value={ticket.triage_notes} />}
                            {(ticket.missing_information ?? []).filter((item) => item.required && !item.completed).length > 0 && (
                                <Badge variant="destructive">Informacion requerida faltante</Badge>
                            )}
                        </CardContent>
                    </Card>
                </div>

                <Card className="rounded-lg">
                    <CardHeader className="flex flex-row items-center justify-between space-y-0">
                        <div><CardTitle>Comentarios</CardTitle><CardDescription>Conversacion interna y publica preparada para portal futuro.</CardDescription></div>
                        <Button onClick={() => setCommentOpen(true)}><MessageSquareText className="size-4" /> Agregar comentario</Button>
                    </CardHeader>
                    <CardContent className="space-y-3">
                        {ticket.mensajes.length === 0 ? <p className="text-sm text-muted-foreground">Sin comentarios.</p> : ticket.mensajes.map((message) => (
                            <div key={message.id} className={`rounded-md border p-3 ${message.es_interno ? 'bg-muted/40' : 'bg-card'}`}>
                                <div className="mb-2 flex flex-wrap items-center gap-2">
                                    <span className="text-sm font-medium">{message.usuario?.name ?? 'Sistema'}</span>
                                    <Badge variant={message.es_interno ? 'secondary' : 'outline'}>{message.es_interno ? 'Interno' : 'Publico'}</Badge>
                                    <span className="text-xs text-muted-foreground">{new Date(message.created_at).toLocaleString('es-MX')}</span>
                                </div>
                                <p className="whitespace-pre-line text-sm">{message.mensaje}</p>
                            </div>
                        ))}
                    </CardContent>
                </Card>

                <div className="grid gap-4 lg:grid-cols-2">
                    <Card className="rounded-lg">
                        <CardHeader><CardTitle>Checklist</CardTitle></CardHeader>
                        <CardContent className="space-y-2">
                            {ticket.checklist_items.length === 0 ? <p className="text-sm text-muted-foreground">Sin checklist.</p> : ticket.checklist_items.map((item) => (
                                <div key={item.id} className="flex items-center justify-between rounded-md border p-3 text-sm">
                                    <span>{item.titulo}</span>
                                    <Badge variant={item.completado ? 'secondary' : 'outline'}>{item.completado ? 'Completo' : item.requerido ? 'Requerido' : 'Pendiente'}</Badge>
                                </div>
                            ))}
                        </CardContent>
                    </Card>

                    <Card className="rounded-lg">
                        <CardHeader><CardTitle>Relaciones</CardTitle></CardHeader>
                        <CardContent className="space-y-2">
                            {ticket.relaciones_origen.length === 0 ? <p className="text-sm text-muted-foreground">Sin relaciones.</p> : ticket.relaciones_origen.map((relation) => (
                                <div key={relation.id} className="rounded-md border p-3 text-sm">
                                    <Badge variant="outline">{relation.tipo}</Badge>
                                    <Link className="ml-2 font-medium text-primary hover:underline" href={route('tickets.show', relation.related_ticket?.id)}>
                                        {relation.related_ticket?.folio} · {relation.related_ticket?.titulo}
                                    </Link>
                                </div>
                            ))}
                        </CardContent>
                    </Card>
                </div>

                <div className="grid gap-4 lg:grid-cols-2">
                    <Card className="rounded-lg">
                        <CardHeader className="flex flex-row items-start justify-between space-y-0">
                            <div>
                                <CardTitle>Tiempos</CardTitle>
                                <CardDescription>Total {formatMinutes(totals.total)} · Facturable {formatMinutes(totals.facturable)} · No facturable {formatMinutes(totals.noFacturable)}</CardDescription>
                            </div>
                            {canManageTime && <Button onClick={() => openTimeDialog()}><Plus className="size-4" /> Agregar tiempo</Button>}
                        </CardHeader>
                        <CardContent className="space-y-3">
                            {!canViewTime ? (
                                <p className="text-sm text-muted-foreground">No tienes permiso para ver tiempos.</p>
                            ) : ticket.tiempos.length === 0 ? (
                                <p className="text-sm text-muted-foreground">Sin tiempos registrados.</p>
                            ) : ticket.tiempos.map((tiempo) => (
                                <div key={tiempo.id} className="flex flex-col gap-2 rounded-md border p-3 text-sm md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <p className="font-medium">{tiempo.descripcion}</p>
                                        <p className="text-xs text-muted-foreground">{tiempo.usuario?.name ?? '-'} · {new Date(tiempo.fecha).toLocaleDateString('es-MX')} · {formatMinutes(tiempo.minutos)}</p>
                                    </div>
                                    <div className="flex items-center gap-2">
                                        <Badge variant={tiempo.es_facturable ? 'secondary' : 'outline'}>{tiempo.es_facturable ? 'Facturable' : 'No facturable'}</Badge>
                                        {canManageTime && (
                                            <>
                                                <Button variant="ghost" size="icon-sm" onClick={() => openTimeDialog(tiempo)}><Pencil className="size-4" /></Button>
                                                <Button variant="ghost" size="icon-sm" onClick={() => router.delete(route('tickets.times.destroy', [ticket.id, tiempo.id]), { preserveScroll: true })}><Trash2 className="size-4" /></Button>
                                            </>
                                        )}
                                    </div>
                                </div>
                            ))}
                        </CardContent>
                    </Card>

                    <Card className="rounded-lg">
                        <CardHeader className="flex flex-row items-start justify-between space-y-0">
                            <div>
                                <CardTitle>SLA</CardTitle>
                                <CardDescription>{ticket.sla?.politica?.nombre ?? 'Sin politica SLA asignada'}</CardDescription>
                            </div>
                            {ticket.sla && <Badge variant={slaVariant(ticket.sla.estado_sla)}>{ticket.sla.estado_sla}</Badge>}
                        </CardHeader>
                        <CardContent className="space-y-3">
                            {ticket.sla ? (
                                <>
                                    <div className="grid gap-3 md:grid-cols-2">
                                        <Info label="Vence primera respuesta" value={formatDateTime(ticket.sla.vence_primera_respuesta_at)} />
                                        <Info label="Primera respuesta" value={formatDateTime(ticket.sla.primera_respuesta_at)} />
                                        <Info label="Cumplimiento primera respuesta" value={formatBoolean(ticket.sla.primera_respuesta_cumplida)} />
                                        <Info label="Vence resolucion" value={formatDateTime(ticket.sla.vence_resolucion_at)} />
                                        <Info label="Resolucion registrada" value={formatDateTime(ticket.sla.resuelto_at)} />
                                        <Info label="Cumplimiento resolucion" value={formatBoolean(ticket.sla.resolucion_cumplida)} />
                                    </div>
                                    {canManageSla && <Button variant="outline" onClick={() => router.patch(route('tickets.sla.recalculate', ticket.id), {}, { preserveScroll: true })}><RefreshCcw className="size-4" /> Recalcular SLA</Button>}
                                </>
                            ) : (
                                <p className="text-sm text-muted-foreground">Este ticket no tiene SLA calculado. Revisa la politica default y la prioridad.</p>
                            )}
                        </CardContent>
                    </Card>
                </div>

                {ticket.proyecto_actividades.length > 0 && (
                    <Card className="rounded-lg">
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2"><FolderKanban className="size-5" /> Actividades de proyecto relacionadas</CardTitle>
                            <CardDescription>Relacion ligera entre este ticket y la planeacion interna del proyecto.</CardDescription>
                        </CardHeader>
                        <CardContent className="grid gap-3 md:grid-cols-2 xl:grid-cols-3">
                            {ticket.proyecto_actividades.map((activity) => (
                                <Link key={activity.id} href={activity.proyecto ? route('proyectos.show', activity.proyecto.id) : '#'} className="rounded-md border p-3 text-sm hover:bg-muted/40">
                                    <div className="flex items-start justify-between gap-2">
                                        <span className="font-medium">{activity.titulo}</span>
                                        <Badge variant="outline">{activity.pivot?.tipo_relacion ?? 'relacionado'}</Badge>
                                    </div>
                                    <div className="mt-2 flex flex-wrap gap-1">
                                        <Badge variant="outline">{activity.tipo}</Badge>
                                        <Badge variant={activity.estado === 'terminada' ? 'default' : activity.estado === 'bloqueada' ? 'destructive' : 'secondary'}>{activity.estado}</Badge>
                                        <Badge variant={activity.prioridad === 'critica' ? 'destructive' : 'outline'}>{activity.prioridad}</Badge>
                                    </div>
                                    <p className="mt-2 text-xs text-muted-foreground">
                                        {activity.proyecto?.nombre ?? 'Sin proyecto'} - {activity.responsable?.name ?? 'Sin responsable'}
                                    </p>
                                    <p className="text-xs text-muted-foreground">
                                        Estimado {formatMinutes(activity.minutos_estimados ?? 0)} - Real {formatMinutes(activity.minutos_reales)}
                                    </p>
                                </Link>
                            ))}
                        </CardContent>
                    </Card>
                )}

                {canViewDevelopment && (
                    <Card className="rounded-lg">
                        <CardHeader className="flex flex-row items-start justify-between space-y-0">
                            <div>
                                <CardTitle className="flex items-center gap-2"><Code2 className="size-5" /> Desarrollo</CardTitle>
                                <CardDescription>Trazabilidad tecnica sin integracion automatica con repositorios externos.</CardDescription>
                            </div>
                            <div className="flex flex-wrap gap-2">
                                {canManageDevelopment && <Button variant="outline" onClick={() => setLinkOpen(true)}><Link2 className="size-4" /> Agregar enlace</Button>}
                                {canManageDevelopment && <Button onClick={() => openTaskDialog()}><Plus className="size-4" /> Crear tarea</Button>}
                            </div>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            <div className="grid gap-3 md:grid-cols-4">
                                <Info label="Estado tecnico" value={ticket.development_status ?? 'sin_desarrollo'} />
                                <Info label="Cambios de codigo" value={ticket.has_code_changes ? 'Si' : 'No'} />
                                <Info label="Proyecto" value={ticket.proyecto?.nombre} />
                                <Info label="Repositorio principal" value={repositories[0]?.nombre ?? null} />
                            </div>

                            <div className="space-y-2">
                                <div className="flex items-center gap-2 text-sm font-medium"><GitBranch className="size-4" /> Tareas tecnicas</div>
                                {ticket.development_tasks.length === 0 ? (
                                    <p className="rounded-md border p-3 text-sm text-muted-foreground">Sin tareas tecnicas registradas.</p>
                                ) : ticket.development_tasks.map((task) => (
                                    <div key={task.id} className="rounded-md border p-3 text-sm">
                                        <div className="flex flex-col gap-2 lg:flex-row lg:items-start lg:justify-between">
                                            <div className="space-y-2">
                                                <div className="flex flex-wrap items-center gap-2">
                                                    <span className="font-medium">{task.titulo}</span>
                                                    <Badge variant="outline">{task.tipo}</Badge>
                                                    <Badge variant={developmentStatusVariant(task.estado)}>{task.estado}</Badge>
                                                </div>
                                                <div className="grid gap-2 text-muted-foreground md:grid-cols-2 xl:grid-cols-4">
                                                    <span>Repo: {task.repositorio?.nombre ?? '-'}</span>
                                                    <span>Rama: {task.branch_name ?? '-'}</span>
                                                    <span>Asignado: {task.asignado_a?.name ?? '-'}</span>
                                                    <span>Estimacion: {task.estimacion_min ? formatMinutes(task.estimacion_min) : '-'}</span>
                                                </div>
                                                <div className="flex flex-wrap gap-2">
                                                    {task.pull_request_url && <a className="inline-flex items-center gap-1 text-primary hover:underline" href={task.pull_request_url} target="_blank" rel="noreferrer">PR <ExternalLink className="size-3" /></a>}
                                                    {task.commit_hash && <Badge variant="outline">{task.commit_hash}</Badge>}
                                                </div>
                                            </div>
                                            {canManageDevelopment && (
                                                <div className="flex gap-2">
                                                    <Button variant="outline" size="sm" onClick={() => openTaskDialog(task)}><Pencil className="size-4" /> Editar</Button>
                                                    <Button variant="ghost" size="icon-sm" onClick={() => router.delete(route('tickets.development.tasks.destroy', [ticket.id, task.id]), { preserveScroll: true })}><Trash2 className="size-4" /></Button>
                                                </div>
                                            )}
                                        </div>
                                    </div>
                                ))}
                            </div>

                            <div className="grid gap-4 lg:grid-cols-2">
                                <div className="space-y-2">
                                    <div className="text-sm font-medium">Enlaces tecnicos</div>
                                    {ticket.development_links.length === 0 ? (
                                        <p className="rounded-md border p-3 text-sm text-muted-foreground">Sin enlaces tecnicos.</p>
                                    ) : ticket.development_links.map((link) => (
                                        <div key={link.id} className="flex items-center justify-between rounded-md border p-3 text-sm">
                                            <div className="min-w-0">
                                                <div className="flex flex-wrap gap-2">
                                                    <Badge variant="outline">{link.tipo}</Badge>
                                                    <span className="font-medium">{link.titulo || link.referencia || link.url}</span>
                                                </div>
                                                {link.url && <a className="mt-1 inline-flex items-center gap-1 text-primary hover:underline" href={link.url} target="_blank" rel="noreferrer">Abrir enlace <ExternalLink className="size-3" /></a>}
                                                <p className="text-xs text-muted-foreground">{link.created_by?.name ?? 'Sistema'} · {new Date(link.created_at).toLocaleDateString('es-MX')}</p>
                                            </div>
                                            {canManageDevelopment && <Button variant="ghost" size="icon-sm" onClick={() => router.delete(route('tickets.development.links.destroy', [ticket.id, link.id]), { preserveScroll: true })}><Trash2 className="size-4" /></Button>}
                                        </div>
                                    ))}
                                </div>

                                <div className="space-y-2">
                                    <div className="flex items-center gap-2 text-sm font-medium"><Rocket className="size-4" /> Releases relacionados</div>
                                    {ticket.releases.length === 0 ? (
                                        <p className="rounded-md border p-3 text-sm text-muted-foreground">Sin releases relacionados.</p>
                                    ) : ticket.releases.map((release) => (
                                        <div key={release.id} className="rounded-md border p-3 text-sm">
                                            <div className="flex flex-wrap items-center justify-between gap-2">
                                                <Link className="font-medium text-primary hover:underline" href={route('development.releases.show', release.id)}>{release.nombre}</Link>
                                                <Badge variant={release.estado === 'liberado' ? 'default' : 'secondary'}>{release.estado}</Badge>
                                            </div>
                                            <p className="text-xs text-muted-foreground">
                                                {release.version ?? 'Sin version'} · {release.ambiente?.nombre ?? 'Sin ambiente'} · {release.released_at ? `Liberado ${new Date(release.released_at).toLocaleDateString('es-MX')}` : 'Pendiente'}
                                            </p>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                )}

                {canViewQa && (
                    <Card className="rounded-lg">
                        <CardHeader className="flex flex-row items-start justify-between space-y-0">
                            <div>
                                <CardTitle className="flex items-center gap-2"><ShieldCheck className="size-5" /> QA</CardTitle>
                                <CardDescription>Pruebas, evidencias, validaciones y reaperturas del ticket.</CardDescription>
                            </div>
                            <div className="flex flex-wrap gap-2">
                                {canManageQa && <Button variant="outline" onClick={() => router.post(route('tickets.qa.test-cases.generate', ticket.id), {}, { preserveScroll: true })}><CheckCircle2 className="size-4" /> Generar casos</Button>}
                                {canManageQa && <Button onClick={() => openTestCaseDialog()}><Plus className="size-4" /> Caso QA</Button>}
                                {canClose && !ticket.closed_at && <Button variant="destructive" onClick={() => setCloseOpen(true)}><XCircle className="size-4" /> Cerrar ticket</Button>}
                            </div>
                        </CardHeader>
                        <CardContent className="space-y-5">
                            <div className="grid gap-3 md:grid-cols-3 xl:grid-cols-6">
                                <Info label="Estado QA" value={ticket.qa_status ?? 'pendiente'} />
                                <Info label="Requiere QA" value={qaOptions.requiresQa ? 'Si' : 'No'} />
                                <Info label="QA aprobado por" value={ticket.qa_approved_by?.name} />
                                <Info label="Aprobado QA" value={formatDateTime(ticket.qa_approved_at)} />
                                <Info label="Validado por" value={ticket.validated_by?.name} />
                                <Info label="Reaperturas" value={String(ticket.reopen_count ?? 0)} />
                            </div>

                            {qaOptions.closeBlockers.length > 0 && (
                                <div className="rounded-md border border-destructive/40 bg-destructive/5 p-3">
                                    <p className="text-sm font-medium text-destructive">Cierre bloqueado o requiere justificacion</p>
                                    <ul className="mt-2 list-disc space-y-1 pl-5 text-sm text-muted-foreground">
                                        {qaOptions.closeBlockers.map((blocker) => <li key={blocker}>{blocker}</li>)}
                                    </ul>
                                </div>
                            )}

                            <div className="space-y-2">
                                <div className="flex items-center justify-between gap-2">
                                    <p className="text-sm font-medium">Casos de prueba</p>
                                    {canManageQa && <Button variant="outline" size="sm" onClick={() => openTestCaseDialog()}><Plus className="size-4" /> Agregar</Button>}
                                </div>
                                {ticket.test_cases.length === 0 ? (
                                    <p className="rounded-md border p-3 text-sm text-muted-foreground">Sin casos de prueba.</p>
                                ) : ticket.test_cases.map((testCase) => (
                                    <div key={testCase.id} className="rounded-md border p-3 text-sm">
                                        <div className="flex flex-col gap-2 md:flex-row md:items-start md:justify-between">
                                            <div className="space-y-1">
                                                <div className="flex flex-wrap items-center gap-2">
                                                    <span className="font-medium">{testCase.titulo}</span>
                                                    <Badge variant="outline">{testCase.tipo}</Badge>
                                                    <Badge variant={testCase.activo ? 'secondary' : 'outline'}>{testCase.activo ? 'Activo' : 'Inactivo'}</Badge>
                                                </div>
                                                {testCase.resultado_esperado && <p className="text-muted-foreground">Esperado: {testCase.resultado_esperado}</p>}
                                            </div>
                                            {canManageQa && (
                                                <div className="flex gap-2">
                                                    <Button variant="outline" size="sm" onClick={() => openTestCaseDialog(testCase)}><Pencil className="size-4" /> Editar</Button>
                                                    <Button variant="ghost" size="icon-sm" onClick={() => router.delete(route('tickets.qa.test-cases.destroy', [ticket.id, testCase.id]), { preserveScroll: true })}><Trash2 className="size-4" /></Button>
                                                </div>
                                            )}
                                        </div>
                                    </div>
                                ))}
                            </div>

                            <div className="space-y-2">
                                <div className="flex items-center justify-between gap-2">
                                    <p className="text-sm font-medium">Resultados de prueba</p>
                                    {canManageQa && <Button variant="outline" size="sm" onClick={() => openTestResultDialog()}><Plus className="size-4" /> Registrar resultado</Button>}
                                </div>
                                {ticket.test_results.length === 0 ? (
                                    <p className="rounded-md border p-3 text-sm text-muted-foreground">Sin resultados registrados.</p>
                                ) : ticket.test_results.map((result) => (
                                    <div key={result.id} className="rounded-md border p-3 text-sm">
                                        <div className="flex flex-col gap-2 md:flex-row md:items-start md:justify-between">
                                            <div className="space-y-1">
                                                <div className="flex flex-wrap items-center gap-2">
                                                    <span className="font-medium">{result.titulo}</span>
                                                    <Badge variant={qaStatusVariant(result.status)}>{result.status}</Badge>
                                                    {result.test_case && <Badge variant="outline">{result.test_case.titulo}</Badge>}
                                                </div>
                                                <p className="text-xs text-muted-foreground">{result.executed_by?.name ?? 'Sin ejecutar'} · {formatDateTime(result.executed_at) ?? 'Pendiente'}</p>
                                                {result.resultado_obtenido && <p className="text-muted-foreground">Obtenido: {result.resultado_obtenido}</p>}
                                            </div>
                                            <div className="flex flex-wrap gap-2">
                                                {canApproveQa && result.status !== 'aprobado' && <Button variant="outline" size="sm" onClick={() => router.patch(route('tickets.qa.test-results.approve', [ticket.id, result.id]), {}, { preserveScroll: true })}><CheckCircle2 className="size-4" /> Aprobar</Button>}
                                                {canManageQa && <Button variant="outline" size="sm" onClick={() => openTestResultDialog(result)}><Pencil className="size-4" /> Editar</Button>}
                                                {canManageQa && <Button variant="ghost" size="icon-sm" onClick={() => router.delete(route('tickets.qa.test-results.destroy', [ticket.id, result.id]), { preserveScroll: true })}><Trash2 className="size-4" /></Button>}
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>

                            <div className="grid gap-4 lg:grid-cols-2">
                                <div className="space-y-2">
                                    <div className="flex items-center justify-between gap-2">
                                        <p className="text-sm font-medium">Evidencias</p>
                                        {canEvidenceQa && <Button variant="outline" size="sm" onClick={() => setEvidenceOpen(true)}><Plus className="size-4" /> Agregar</Button>}
                                    </div>
                                    {ticket.test_evidences.length === 0 ? (
                                        <p className="rounded-md border p-3 text-sm text-muted-foreground">Sin evidencias QA.</p>
                                    ) : ticket.test_evidences.map((evidence) => (
                                        <div key={evidence.id} className="flex items-center justify-between rounded-md border p-3 text-sm">
                                            <div className="min-w-0">
                                                <div className="flex flex-wrap gap-2">
                                                    <Badge variant="outline">{evidence.tipo ?? 'evidencia'}</Badge>
                                                    <span className="font-medium">{evidence.titulo || evidence.adjunto?.nombre_original || evidence.url || 'Evidencia'}</span>
                                                </div>
                                                {evidence.adjunto && <a className="text-primary hover:underline" href={route('tickets.attachments.download', [ticket.id, evidence.adjunto.id])}>Descargar adjunto</a>}
                                                {evidence.url && <a className="block text-primary hover:underline" href={evidence.url} target="_blank" rel="noreferrer">Abrir enlace</a>}
                                                <p className="text-xs text-muted-foreground">{evidence.uploaded_by?.name ?? 'Sistema'} · {new Date(evidence.created_at).toLocaleDateString('es-MX')}</p>
                                            </div>
                                            {canEvidenceQa && <Button variant="ghost" size="icon-sm" onClick={() => router.delete(route('tickets.qa.evidences.destroy', [ticket.id, evidence.id]), { preserveScroll: true })}><Trash2 className="size-4" /></Button>}
                                        </div>
                                    ))}
                                </div>

                                <div className="space-y-2">
                                    <div className="flex items-center justify-between gap-2">
                                        <p className="text-sm font-medium">Validaciones</p>
                                        {canManageQa && <Button variant="outline" size="sm" onClick={() => setValidationOpen(true)}><Plus className="size-4" /> Crear</Button>}
                                    </div>
                                    {ticket.validations.length === 0 ? (
                                        <p className="rounded-md border p-3 text-sm text-muted-foreground">Sin validaciones.</p>
                                    ) : ticket.validations.map((validation) => (
                                        <div key={validation.id} className="rounded-md border p-3 text-sm">
                                            <div className="flex flex-col gap-2 md:flex-row md:items-start md:justify-between">
                                                <div>
                                                    <div className="flex flex-wrap gap-2">
                                                        <Badge variant="outline">{validation.tipo}</Badge>
                                                        <Badge variant={qaStatusVariant(validation.status)}>{validation.status}</Badge>
                                                    </div>
                                                    <p className="mt-1 text-muted-foreground">{validation.comentario ?? 'Sin comentario'}</p>
                                                    <p className="text-xs text-muted-foreground">{validation.validated_by?.name ?? 'Pendiente'} · {formatDateTime(validation.validated_at) ?? '-'}</p>
                                                </div>
                                                <div className="flex gap-2">
                                                    {canApproveQa && validation.status !== 'aprobado' && <Button variant="outline" size="sm" onClick={() => router.patch(route('tickets.qa.validations.approve', [ticket.id, validation.id]), {}, { preserveScroll: true })}>Aprobar</Button>}
                                                    {canRejectQa && validation.status !== 'rechazado' && <Button variant="outline" size="sm" onClick={() => router.patch(route('tickets.qa.validations.reject', [ticket.id, validation.id]), { comentario: validation.comentario || 'Validacion rechazada manualmente.' }, { preserveScroll: true })}>Rechazar</Button>}
                                                </div>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            <div className="space-y-2">
                                <p className="text-sm font-medium">Reaperturas</p>
                                {ticket.reopen_logs.length === 0 ? (
                                    <p className="rounded-md border p-3 text-sm text-muted-foreground">Sin reaperturas registradas.</p>
                                ) : ticket.reopen_logs.map((log) => (
                                    <div key={log.id} className="rounded-md border p-3 text-sm">
                                        <div className="flex flex-wrap gap-2">
                                            <Badge variant="outline">{log.root_cause ?? 'sin_causa'}</Badge>
                                            <span className="font-medium">{log.reopened_by?.name ?? 'Sistema'}</span>
                                            <span className="text-muted-foreground">{new Date(log.created_at).toLocaleString('es-MX')}</span>
                                        </div>
                                        <p className="mt-2 whitespace-pre-line text-muted-foreground">{log.reason}</p>
                                        {log.notes && <p className="mt-1 whitespace-pre-line text-xs text-muted-foreground">{log.notes}</p>}
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>
                )}

                <Card className="rounded-lg">
                    <CardHeader className="flex flex-row items-start justify-between space-y-0">
                        <div>
                            <CardTitle className="flex items-center gap-2"><CircleDollarSign className="size-5" /> Cotizacion / alcance</CardTitle>
                            <CardDescription>Control comercial para tickets fuera de soporte o sujetos a aprobacion.</CardDescription>
                        </div>
                        <div className="flex flex-wrap gap-2">
                            {canQuote && !ticket.requires_quote && <Button variant="outline" onClick={() => router.patch(route('tickets.quote.mark-required', ticket.id), {}, { preserveScroll: true })}>Marcar requiere cotizacion</Button>}
                            {canQuote && <Button asChild><Link href={route('tickets.quote.create', ticket.id)}><Plus className="size-4" /> Crear cotizacion</Link></Button>}
                            {ticket.cotizacion_principal && <Button asChild variant="outline"><Link href={route('quotes.show', ticket.cotizacion_principal.id)}>Ver principal</Link></Button>}
                        </div>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        <div className="grid gap-3 md:grid-cols-4">
                            <Info label="Requiere cotizacion" value={ticket.requires_quote ? 'Si' : 'No'} />
                            <Info label="Estado cotizacion" value={ticket.quote_status ?? (ticket.requires_quote ? 'pendiente' : 'no_requiere')} />
                            <Info label="Cotizacion principal" value={ticket.cotizacion_principal?.folio} />
                            <Info label="Total principal" value={ticket.cotizacion_principal ? formatCurrency(ticket.cotizacion_principal.total) : null} />
                        </div>
                        {quoteOptions.relatedQuotes.length > 0 && (
                            <p className="text-xs text-muted-foreground">
                                {quoteOptions.relatedQuotes.length} cotizaciones del cliente/proyecto disponibles para consulta.
                            </p>
                        )}
                        {ticket.requires_quote && ticket.quote_status !== 'aprobado' && ticket.quote_status !== 'convertido' && (
                            <div className="rounded-md border border-amber-300 bg-amber-50 p-3 text-sm text-amber-900">
                                Este ticket requiere cotizacion y no debe avanzar directo a desarrollo sin aprobacion comercial.
                            </div>
                        )}
                        {ticket.cotizaciones.length === 0 ? (
                            <p className="rounded-md border p-3 text-sm text-muted-foreground">Sin cotizaciones relacionadas.</p>
                        ) : ticket.cotizaciones.map((quote) => (
                            <div key={`${quote.id}-${quote.pivot?.tipo_relacion ?? 'relacionado'}`} className="flex flex-col gap-2 rounded-md border p-3 text-sm md:flex-row md:items-center md:justify-between">
                                <div>
                                    <div className="flex flex-wrap gap-2">
                                        <Badge variant="outline">{quote.pivot?.tipo_relacion ?? 'relacionado'}</Badge>
                                        <Badge variant={quoteStatusVariant(quote.estado)}>{quote.estado}</Badge>
                                    </div>
                                    <Link className="mt-2 block font-medium text-primary hover:underline" href={route('quotes.show', quote.id)}>{quote.folio} - {quote.titulo}</Link>
                                </div>
                                <span className="font-medium">{formatCurrency(quote.total)}</span>
                            </div>
                        ))}
                    </CardContent>
                </Card>

                {canViewTicketNotifications && (
                    <Card className="rounded-lg">
                        <CardHeader className="flex flex-row items-start justify-between space-y-0">
                            <div>
                                <CardTitle className="flex items-center gap-2"><Mail className="size-5" /> Comunicacion / integraciones</CardTitle>
                                <CardDescription>Notificaciones, mensajes externos y webhooks relacionados con el ticket.</CardDescription>
                            </div>
                            {canManageTicketNotifications && <Button onClick={() => setEmailOpen(true)}><Mail className="size-4" /> Enviar correo</Button>}
                        </CardHeader>
                        <CardContent className="grid gap-4 xl:grid-cols-3">
                            <MiniTimeline title="Notificaciones" empty="Sin notificaciones." rows={ticket.notification_logs.map((log) => ({
                                id: log.id,
                                title: log.subject ?? log.channel,
                                meta: `${log.channel} / ${log.status}`,
                                date: log.sent_at ?? log.created_at,
                                href: route('notifications.logs.show', log.id),
                            }))} />
                            <MiniTimeline title="Webhooks" empty="Sin webhooks." rows={ticket.webhook_events.map((event) => ({
                                id: event.id,
                                title: `${event.provider} ${event.event_type ?? ''}`.trim(),
                                meta: event.status,
                                date: event.created_at,
                                href: route('integrations.webhooks.show', event.id),
                            }))} />
                            <MiniTimeline title="Mensajes externos" empty="Sin mensajes externos." rows={ticket.external_messages.map((message) => ({
                                id: message.id,
                                title: `${message.channel} / ${message.direction}`,
                                meta: message.sender ?? message.recipient ?? '-',
                                date: message.created_at,
                                href: route('integrations.messages.show', message.id),
                            }))} />
                            {!integrationOptions.mailEnabled && (
                                <div className="rounded-md border border-amber-300 bg-amber-50 p-3 text-sm text-amber-900 xl:col-span-3">
                                    El envio de correo esta desactivado en configuracion; los intentos se registraran como fallidos.
                                </div>
                            )}
                        </CardContent>
                    </Card>
                )}

                <Card className="rounded-lg">
                    <CardHeader className="flex flex-row items-start justify-between space-y-0">
                        <div>
                            <CardTitle>Base de conocimiento</CardTitle>
                            <CardDescription>Articulos relacionados, soluciones y referencias del ticket.</CardDescription>
                        </div>
                        <div className="flex flex-wrap gap-2">
                            {canViewKnowledge && <Button asChild variant="outline"><Link href={route('knowledge.index', { search: ticket.titulo })}><BookOpen className="size-4" /> Buscar</Link></Button>}
                            {canLinkKnowledge && <Button variant="outline" onClick={() => setKnowledgeOpen(true)}><Link2 className="size-4" /> Relacionar</Button>}
                            {canCreateKnowledge && <Button asChild><Link href={route('tickets.knowledge.create', ticket.id)}><Plus className="size-4" /> Crear desde ticket</Link></Button>}
                        </div>
                    </CardHeader>
                    <CardContent className="space-y-3">
                        {ticket.knowledge_articles.length === 0 ? <p className="text-sm text-muted-foreground">Sin articulos relacionados.</p> : ticket.knowledge_articles.map((article) => (
                            <div key={`${article.id}-${article.pivot?.tipo_relacion ?? 'relacionado'}`} className="flex flex-col gap-2 rounded-md border p-3 text-sm md:flex-row md:items-center md:justify-between">
                                <div>
                                    <div className="flex flex-wrap gap-2">
                                        <Badge variant="outline">{article.pivot?.tipo_relacion ?? 'relacionado'}</Badge>
                                        <Badge variant={article.estatus === 'publicado' ? 'default' : 'secondary'}>{article.estatus}</Badge>
                                        <Badge variant={article.visibilidad === 'publica' ? 'secondary' : 'outline'}>{article.visibilidad}</Badge>
                                    </div>
                                    <Link className="mt-2 block font-medium text-primary hover:underline" href={route('knowledge.show', article.id)}>{article.titulo}</Link>
                                </div>
                                {canLinkKnowledge && <Button variant="ghost" size="icon-sm" onClick={() => router.delete(route('tickets.knowledge.unlink', [ticket.id, article.id]), { preserveScroll: true })}><Trash2 className="size-4" /></Button>}
                            </div>
                        ))}
                    </CardContent>
                </Card>

                {canViewAi && (
                    <Card className="rounded-lg">
                        <CardHeader className="flex flex-row items-start justify-between space-y-0">
                            <div>
                                <CardTitle className="flex items-center gap-2"><Bot className="size-5" /> IA asistente</CardTitle>
                                <CardDescription>
                                    {aiConfig.configured ? `Modelo ${aiConfig.model}` : 'IA desactivada o sin API key. El ticket no se rompe.'}
                                </CardDescription>
                            </div>
                            <div className="flex flex-wrap gap-2">
                                <Button asChild variant="outline"><Link href={route('tickets.ai.show', ticket.id)}><Bot className="size-4" /> Abrir panel</Link></Button>
                                {canAnalyzeAi && (
                                    <Button
                                        onClick={() => router.post(route('tickets.ai.analyze', ticket.id), { analysis_type: 'full', include_knowledge: true, include_comments: true }, { preserveScroll: true })}
                                    >
                                        <Sparkles className="size-4" /> Analizar
                                    </Button>
                                )}
                            </div>
                        </CardHeader>
                        <CardContent className="space-y-3">
                            {ticket.ai_analyses.length === 0 ? (
                                <p className="text-sm text-muted-foreground">Sin analisis de IA registrados.</p>
                            ) : (
                                <div className="rounded-md border p-3 text-sm">
                                    <div className="mb-2 flex flex-wrap gap-2">
                                        <Badge variant={ticket.ai_analyses[0].status === 'failed' ? 'destructive' : 'secondary'}>{ticket.ai_analyses[0].status}</Badge>
                                        <Badge variant="outline">{ticket.ai_analyses[0].confidence ? `${Math.round(Number(ticket.ai_analyses[0].confidence) * 100)}% confianza` : 'Sin confianza'}</Badge>
                                    </div>
                                    <p className="font-medium">{ticket.ai_analyses[0].summary ?? 'Analisis sin resumen.'}</p>
                                    {ticket.ai_analyses[0].error_message && <p className="mt-2 text-destructive">{ticket.ai_analyses[0].error_message}</p>}
                                    <p className="mt-2 text-xs text-muted-foreground">{ticket.ai_actions.length} acciones sugeridas registradas.</p>
                                </div>
                            )}
                        </CardContent>
                    </Card>
                )}

                <Card className="rounded-lg">
                    <CardHeader><CardTitle>Historial</CardTitle></CardHeader>
                    <CardContent className="space-y-3">
                        {ticket.historial.map((log) => (
                            <div key={log.id} className="flex gap-3 border-l pl-3">
                                <Clock className="mt-0.5 size-4 text-muted-foreground" />
                                <div>
                                    <p className="text-sm font-medium">{log.accion}</p>
                                    <p className="text-sm text-muted-foreground">{log.descripcion ?? `${log.campo ?? ''}: ${log.valor_anterior ?? '-'} -> ${log.valor_nuevo ?? '-'}`}</p>
                                    <p className="text-xs text-muted-foreground">{log.usuario?.name ?? 'Sistema'} · {new Date(log.created_at).toLocaleString('es-MX')}</p>
                                </div>
                            </div>
                        ))}
                    </CardContent>
                </Card>
            </div>

            <CrudFormDialog open={commentOpen} onOpenChange={setCommentOpen} title="Agregar comentario" description="Registra una respuesta interna o publica." processing={commentForm.processing} onSubmit={submitComment} submitLabel="Guardar comentario">
                <FormTextareaField id="comment-message" label="Mensaje" value={commentForm.data.mensaje} error={commentForm.errors.mensaje} onChange={(event) => commentForm.setData('mensaje', event.target.value)} />
                <label className="flex items-center gap-2 text-sm"><Checkbox checked={commentForm.data.es_interno} onCheckedChange={(value) => commentForm.setData('es_interno', Boolean(value))} /> Comentario interno</label>
                <label className="flex items-center gap-2 text-sm"><Checkbox checked={commentForm.data.es_respuesta_cliente} onCheckedChange={(value) => commentForm.setData('es_respuesta_cliente', Boolean(value))} /> Es respuesta del cliente</label>
            </CrudFormDialog>

            <SimpleSelectDialog open={assignOpen} setOpen={setAssignOpen} title="Asignar responsable" label="Responsable" form={assignForm} field="responsable_id" options={users.map(toUserOption)} submitLabel="Asignar" onSubmit={() => assignForm.patch(route('tickets.assign', ticket.id), { preserveScroll: true, onSuccess: () => setAssignOpen(false) })} />
            <SimpleSelectDialog open={statusOpen} setOpen={setStatusOpen} title="Cambiar estado" label="Estado" form={statusForm} field="estado_id" options={estados.map(toCatalogOption)} submitLabel="Cambiar estado" onSubmit={() => statusForm.patch(route('tickets.status.update', ticket.id), { preserveScroll: true, onSuccess: () => setStatusOpen(false) })} />

            <CrudFormDialog open={closeOpen} onOpenChange={setCloseOpen} title="Cerrar ticket" description="La resolucion es obligatoria. Si QA bloquea el cierre, se requiere justificacion." processing={closeForm.processing} submitLabel="Cerrar ticket" onSubmit={(event) => { event.preventDefault(); closeForm.patch(route('tickets.close', ticket.id), { preserveScroll: true, onSuccess: () => setCloseOpen(false) }); }}>
                {qaOptions.closeBlockers.length > 0 && (
                    <div className="rounded-md border border-destructive/40 bg-destructive/5 p-3 text-sm">
                        <p className="font-medium text-destructive">Faltantes de cierre</p>
                        <ul className="mt-2 list-disc space-y-1 pl-5 text-muted-foreground">
                            {qaOptions.closeBlockers.map((blocker) => <li key={blocker}>{blocker}</li>)}
                        </ul>
                    </div>
                )}
                <FormTextareaField id="resolution" label="Resolucion" value={closeForm.data.resolution} error={closeForm.errors.resolution} onChange={(event) => closeForm.setData('resolution', event.target.value)} />
                {canManage && qaOptions.closeBlockers.length > 0 && (
                    <>
                        <label className="flex items-center gap-2 text-sm"><Checkbox checked={closeForm.data.force_close} onCheckedChange={(value) => closeForm.setData('force_close', Boolean(value))} /> Forzar cierre con justificacion</label>
                        <FormTextareaField id="force-reason" label="Justificacion de cierre forzado" value={closeForm.data.force_reason} error={closeForm.errors.force_reason} onChange={(event) => closeForm.setData('force_reason', event.target.value)} />
                    </>
                )}
            </CrudFormDialog>

            <CrudFormDialog open={reopenOpen} onOpenChange={setReopenOpen} title="Reabrir ticket" description="Registra el motivo de reapertura." processing={reopenForm.processing} submitLabel="Reabrir ticket" onSubmit={(event) => { event.preventDefault(); reopenForm.patch(route('tickets.reopen', ticket.id), { preserveScroll: true, onSuccess: () => setReopenOpen(false) }); }}>
                <FormTextareaField id="reopen-reason" label="Motivo" value={reopenForm.data.reason} error={reopenForm.errors.reason} onChange={(event) => reopenForm.setData('reason', event.target.value)} />
                <Field>
                    <Label>Causa raiz</Label>
                    <Select value={reopenForm.data.root_cause || 'none'} onValueChange={(value) => reopenForm.setData('root_cause', value === 'none' ? '' : value)}>
                        <SelectTrigger className="w-full"><SelectValue placeholder="Selecciona causa" /></SelectTrigger>
                        <SelectContent>
                            <SelectItem value="none">Sin causa</SelectItem>
                            {qaOptions.rootCauses.map((cause) => <SelectItem key={cause} value={cause}>{cause}</SelectItem>)}
                        </SelectContent>
                    </Select>
                    {reopenForm.errors.root_cause && <FieldError>{reopenForm.errors.root_cause}</FieldError>}
                </Field>
                <FormTextareaField id="reopen-notes" label="Notas" value={reopenForm.data.notes} error={reopenForm.errors.notes} onChange={(event) => reopenForm.setData('notes', event.target.value)} />
            </CrudFormDialog>

            <CrudFormDialog open={timeOpen} onOpenChange={setTimeOpen} title={editTime ? 'Editar tiempo' : 'Agregar tiempo'} description="Registra minutos reales invertidos en este ticket." processing={timeForm.processing} submitLabel={editTime ? 'Actualizar tiempo' : 'Guardar tiempo'} onSubmit={submitTime}>
                <FormTextareaField id="time-description" label="Descripcion" value={timeForm.data.descripcion} error={timeForm.errors.descripcion} onChange={(event) => timeForm.setData('descripcion', event.target.value)} />
                <div className="grid gap-3 md:grid-cols-3">
                    <FormInputField id="time-minutes" label="Minutos" type="number" min="1" value={timeForm.data.minutos} error={timeForm.errors.minutos} onChange={(event) => timeForm.setData('minutos', event.target.value)} />
                    <FormInputField id="time-date" label="Fecha" type="date" value={timeForm.data.fecha} error={timeForm.errors.fecha} onChange={(event) => timeForm.setData('fecha', event.target.value)} />
                    <label className="mt-6 flex items-center gap-2 text-sm"><Checkbox checked={timeForm.data.es_facturable} onCheckedChange={(value) => timeForm.setData('es_facturable', Boolean(value))} /> Facturable</label>
                </div>
                <div className="grid gap-3 md:grid-cols-2">
                    <FormInputField id="time-started" label="Inicio" type="datetime-local" value={timeForm.data.iniciado_at} error={timeForm.errors.iniciado_at} onChange={(event) => timeForm.setData('iniciado_at', event.target.value)} />
                    <FormInputField id="time-ended" label="Fin" type="datetime-local" value={timeForm.data.terminado_at} error={timeForm.errors.terminado_at} onChange={(event) => timeForm.setData('terminado_at', event.target.value)} />
                </div>
            </CrudFormDialog>

            <CrudFormDialog open={knowledgeOpen} onOpenChange={setKnowledgeOpen} title="Relacionar articulo" description="Agrega una solucion, referencia o respuesta sugerida al ticket." processing={knowledgeForm.processing} submitLabel="Relacionar" onSubmit={submitKnowledgeLink}>
                <Field>
                    <Label>Articulo</Label>
                    <Select value={knowledgeForm.data.knowledge_article_id} onValueChange={(value) => knowledgeForm.setData('knowledge_article_id', value)}>
                        <SelectTrigger className="w-full"><SelectValue placeholder="Selecciona articulo" /></SelectTrigger>
                        <SelectContent>{knowledgeArticles.map((article) => <SelectItem key={article.id} value={article.id}>{article.titulo}</SelectItem>)}</SelectContent>
                    </Select>
                    {knowledgeForm.errors.knowledge_article_id && <FieldError>{knowledgeForm.errors.knowledge_article_id}</FieldError>}
                </Field>
                <Field>
                    <Label>Tipo de relacion</Label>
                    <Select value={knowledgeForm.data.tipo_relacion} onValueChange={(value) => knowledgeForm.setData('tipo_relacion', value)}>
                        <SelectTrigger className="w-full"><SelectValue placeholder="Tipo" /></SelectTrigger>
                        <SelectContent>{['solucion', 'relacionado', 'referencia', 'respuesta_sugerida'].map((type) => <SelectItem key={type} value={type}>{type}</SelectItem>)}</SelectContent>
                    </Select>
                    {knowledgeForm.errors.tipo_relacion && <FieldError>{knowledgeForm.errors.tipo_relacion}</FieldError>}
                </Field>
                <FormTextareaField id="knowledge-link-notes" label="Notas" value={knowledgeForm.data.notas} error={knowledgeForm.errors.notas} onChange={(event) => knowledgeForm.setData('notas', event.target.value)} />
            </CrudFormDialog>

            <CrudFormDialog open={taskOpen} onOpenChange={setTaskOpen} title={editTask ? 'Editar tarea tecnica' : 'Crear tarea tecnica'} description="Registra trabajo tecnico ligado al ticket. No crea ramas ni PRs automaticamente." processing={taskForm.processing} submitLabel={editTask ? 'Guardar tarea' : 'Crear tarea'} onSubmit={submitTask}>
                <div className="grid gap-4 md:grid-cols-2">
                    <FormInputField id="dev-task-title" label="Titulo" value={taskForm.data.titulo} error={taskForm.errors.titulo} onChange={(event) => taskForm.setData('titulo', event.target.value)} />
                    <Field>
                        <Label>Asignado a</Label>
                        <Select value={taskForm.data.asignado_a_id || 'none'} onValueChange={(value) => taskForm.setData('asignado_a_id', value === 'none' ? '' : value)}>
                            <SelectTrigger className="w-full"><SelectValue placeholder="Sin asignar" /></SelectTrigger>
                            <SelectContent>
                                <SelectItem value="none">Sin asignar</SelectItem>
                                {users.map((user) => <SelectItem key={user.id} value={String(user.id)}>{user.name}</SelectItem>)}
                            </SelectContent>
                        </Select>
                        {taskForm.errors.asignado_a_id && <FieldError>{taskForm.errors.asignado_a_id}</FieldError>}
                    </Field>
                    <Field>
                        <Label>Tipo</Label>
                        <Select value={taskForm.data.tipo} onValueChange={(value) => taskForm.setData('tipo', value)}>
                            <SelectTrigger className="w-full"><SelectValue /></SelectTrigger>
                            <SelectContent>{developmentTaskOptions.types.map((option) => <SelectItem key={option} value={option}>{option}</SelectItem>)}</SelectContent>
                        </Select>
                        {taskForm.errors.tipo && <FieldError>{taskForm.errors.tipo}</FieldError>}
                    </Field>
                    <Field>
                        <Label>Estado</Label>
                        <Select value={taskForm.data.estado} onValueChange={(value) => taskForm.setData('estado', value)}>
                            <SelectTrigger className="w-full"><SelectValue /></SelectTrigger>
                            <SelectContent>{developmentTaskOptions.statuses.map((option) => <SelectItem key={option} value={option}>{option}</SelectItem>)}</SelectContent>
                        </Select>
                        {taskForm.errors.estado && <FieldError>{taskForm.errors.estado}</FieldError>}
                    </Field>
                    <Field>
                        <Label>Repositorio</Label>
                        <Select value={taskForm.data.repositorio_id || 'none'} onValueChange={(value) => taskForm.setData('repositorio_id', value === 'none' ? '' : value)}>
                            <SelectTrigger className="w-full"><SelectValue placeholder="Sin repositorio" /></SelectTrigger>
                            <SelectContent>
                                <SelectItem value="none">Sin repositorio</SelectItem>
                                {repositories.map((repository) => <SelectItem key={repository.id} value={repository.id}>{repository.nombre}</SelectItem>)}
                            </SelectContent>
                        </Select>
                        {taskForm.errors.repositorio_id && <FieldError>{taskForm.errors.repositorio_id}</FieldError>}
                    </Field>
                    <FormInputField id="dev-task-priority" label="Prioridad tecnica" value={taskForm.data.prioridad} error={taskForm.errors.prioridad} onChange={(event) => taskForm.setData('prioridad', event.target.value)} />
                    <FormInputField id="dev-task-branch" label="Rama" value={taskForm.data.branch_name} error={taskForm.errors.branch_name} onChange={(event) => taskForm.setData('branch_name', event.target.value)} />
                    <FormInputField id="dev-task-pr" label="Pull request URL" value={taskForm.data.pull_request_url} error={taskForm.errors.pull_request_url} onChange={(event) => taskForm.setData('pull_request_url', event.target.value)} />
                    <FormInputField id="dev-task-commit" label="Commit hash" value={taskForm.data.commit_hash} error={taskForm.errors.commit_hash} onChange={(event) => taskForm.setData('commit_hash', event.target.value)} />
                    <FormInputField id="dev-task-estimate" label="Estimacion (min)" type="number" min="0" value={taskForm.data.estimacion_min} error={taskForm.errors.estimacion_min} onChange={(event) => taskForm.setData('estimacion_min', event.target.value)} />
                    {editTask && <FormInputField id="dev-task-real-time" label="Tiempo real (min)" type="number" min="0" value={taskForm.data.tiempo_real_min} error={taskForm.errors.tiempo_real_min} onChange={(event) => taskForm.setData('tiempo_real_min', event.target.value)} />}
                    <div className="md:col-span-2">
                        <FormTextareaField id="dev-task-description" label="Descripcion" value={taskForm.data.descripcion} error={taskForm.errors.descripcion} onChange={(event) => taskForm.setData('descripcion', event.target.value)} />
                    </div>
                </div>
            </CrudFormDialog>

            <CrudFormDialog open={linkOpen} onOpenChange={setLinkOpen} title="Agregar enlace tecnico" description="Registra rama, PR, commit, documento, log o evidencia tecnica." processing={linkForm.processing} submitLabel="Agregar enlace" onSubmit={submitDevelopmentLink}>
                <div className="grid gap-4 md:grid-cols-2">
                    <Field>
                        <Label>Tipo</Label>
                        <Select value={linkForm.data.tipo} onValueChange={(value) => linkForm.setData('tipo', value)}>
                            <SelectTrigger className="w-full"><SelectValue /></SelectTrigger>
                            <SelectContent>{['branch', 'commit', 'pull_request', 'merge_request', 'issue', 'documentacion', 'deploy', 'log', 'otro'].map((option) => <SelectItem key={option} value={option}>{option}</SelectItem>)}</SelectContent>
                        </Select>
                        {linkForm.errors.tipo && <FieldError>{linkForm.errors.tipo}</FieldError>}
                    </Field>
                    <Field>
                        <Label>Tarea relacionada</Label>
                        <Select value={linkForm.data.development_task_id || 'none'} onValueChange={(value) => linkForm.setData('development_task_id', value === 'none' ? '' : value)}>
                            <SelectTrigger className="w-full"><SelectValue placeholder="Sin tarea" /></SelectTrigger>
                            <SelectContent>
                                <SelectItem value="none">Sin tarea</SelectItem>
                                {ticket.development_tasks.map((task) => <SelectItem key={task.id} value={task.id}>{task.titulo}</SelectItem>)}
                            </SelectContent>
                        </Select>
                        {linkForm.errors.development_task_id && <FieldError>{linkForm.errors.development_task_id}</FieldError>}
                    </Field>
                    <FormInputField id="dev-link-title" label="Titulo" value={linkForm.data.titulo} error={linkForm.errors.titulo} onChange={(event) => linkForm.setData('titulo', event.target.value)} />
                    <FormInputField id="dev-link-reference" label="Referencia" value={linkForm.data.referencia} error={linkForm.errors.referencia} onChange={(event) => linkForm.setData('referencia', event.target.value)} />
                    <div className="md:col-span-2">
                        <FormInputField id="dev-link-url" label="URL" value={linkForm.data.url} error={linkForm.errors.url} onChange={(event) => linkForm.setData('url', event.target.value)} />
                    </div>
                </div>
            </CrudFormDialog>

            <CrudFormDialog open={testCaseOpen} onOpenChange={setTestCaseOpen} title={editTestCase ? 'Editar caso QA' : 'Crear caso QA'} description="Documenta una prueba manual del ticket." processing={testCaseForm.processing} submitLabel={editTestCase ? 'Guardar caso' : 'Crear caso'} onSubmit={submitTestCase}>
                <div className="grid gap-4 md:grid-cols-2">
                    <FormInputField id="test-case-title" label="Titulo" value={testCaseForm.data.titulo} error={testCaseForm.errors.titulo} onChange={(event) => testCaseForm.setData('titulo', event.target.value)} />
                    <Field>
                        <Label>Tipo</Label>
                        <Select value={testCaseForm.data.tipo} onValueChange={(value) => testCaseForm.setData('tipo', value)}>
                            <SelectTrigger className="w-full"><SelectValue /></SelectTrigger>
                            <SelectContent>{qaOptions.testCaseTypes.map((type) => <SelectItem key={type} value={type}>{type}</SelectItem>)}</SelectContent>
                        </Select>
                        {testCaseForm.errors.tipo && <FieldError>{testCaseForm.errors.tipo}</FieldError>}
                    </Field>
                    <FormInputField id="test-case-priority" label="Prioridad" value={testCaseForm.data.prioridad} error={testCaseForm.errors.prioridad} onChange={(event) => testCaseForm.setData('prioridad', event.target.value)} />
                    <label className="mt-6 flex items-center gap-2 text-sm"><Checkbox checked={testCaseForm.data.activo} onCheckedChange={(value) => testCaseForm.setData('activo', Boolean(value))} /> Activo</label>
                    <div className="md:col-span-2">
                        <FormTextareaField id="test-case-description" label="Descripcion" value={testCaseForm.data.descripcion} error={testCaseForm.errors.descripcion} onChange={(event) => testCaseForm.setData('descripcion', event.target.value)} />
                    </div>
                    <div className="md:col-span-2">
                        <FormTextareaField id="test-case-steps" label="Pasos" value={testCaseForm.data.pasos} error={testCaseForm.errors.pasos} onChange={(event) => testCaseForm.setData('pasos', event.target.value)} />
                    </div>
                    <div className="md:col-span-2">
                        <FormTextareaField id="test-case-expected" label="Resultado esperado" value={testCaseForm.data.resultado_esperado} error={testCaseForm.errors.resultado_esperado} onChange={(event) => testCaseForm.setData('resultado_esperado', event.target.value)} />
                    </div>
                </div>
            </CrudFormDialog>

            <CrudFormDialog open={testResultOpen} onOpenChange={setTestResultOpen} title={editTestResult ? 'Editar resultado QA' : 'Registrar resultado QA'} description="Registra ejecucion y resultado de una prueba." processing={testResultForm.processing} submitLabel={editTestResult ? 'Guardar resultado' : 'Registrar resultado'} onSubmit={submitTestResult}>
                <div className="grid gap-4 md:grid-cols-2">
                    <Field>
                        <Label>Caso relacionado</Label>
                        <Select value={testResultForm.data.test_case_id || 'none'} onValueChange={(value) => testResultForm.setData('test_case_id', value === 'none' ? '' : value)}>
                            <SelectTrigger className="w-full"><SelectValue placeholder="Sin caso" /></SelectTrigger>
                            <SelectContent>
                                <SelectItem value="none">Sin caso</SelectItem>
                                {ticket.test_cases.map((testCase) => <SelectItem key={testCase.id} value={testCase.id}>{testCase.titulo}</SelectItem>)}
                            </SelectContent>
                        </Select>
                        {testResultForm.errors.test_case_id && <FieldError>{testResultForm.errors.test_case_id}</FieldError>}
                    </Field>
                    <Field>
                        <Label>Tarea tecnica</Label>
                        <Select value={testResultForm.data.development_task_id || 'none'} onValueChange={(value) => testResultForm.setData('development_task_id', value === 'none' ? '' : value)}>
                            <SelectTrigger className="w-full"><SelectValue placeholder="Sin tarea" /></SelectTrigger>
                            <SelectContent>
                                <SelectItem value="none">Sin tarea</SelectItem>
                                {ticket.development_tasks.map((task) => <SelectItem key={task.id} value={task.id}>{task.titulo}</SelectItem>)}
                            </SelectContent>
                        </Select>
                        {testResultForm.errors.development_task_id && <FieldError>{testResultForm.errors.development_task_id}</FieldError>}
                    </Field>
                    <FormInputField id="test-result-title" label="Titulo" value={testResultForm.data.titulo} error={testResultForm.errors.titulo} onChange={(event) => testResultForm.setData('titulo', event.target.value)} />
                    <Field>
                        <Label>Estado</Label>
                        <Select value={testResultForm.data.status} onValueChange={(value) => testResultForm.setData('status', value)}>
                            <SelectTrigger className="w-full"><SelectValue /></SelectTrigger>
                            <SelectContent>{qaOptions.testResultStatuses.map((status) => <SelectItem key={status} value={status}>{status}</SelectItem>)}</SelectContent>
                        </Select>
                        {testResultForm.errors.status && <FieldError>{testResultForm.errors.status}</FieldError>}
                    </Field>
                    <div className="md:col-span-2">
                        <FormTextareaField id="test-result-steps" label="Pasos" value={testResultForm.data.pasos} error={testResultForm.errors.pasos} onChange={(event) => testResultForm.setData('pasos', event.target.value)} />
                    </div>
                    <FormTextareaField id="test-result-expected" label="Resultado esperado" value={testResultForm.data.resultado_esperado} error={testResultForm.errors.resultado_esperado} onChange={(event) => testResultForm.setData('resultado_esperado', event.target.value)} />
                    <FormTextareaField id="test-result-obtained" label="Resultado obtenido" value={testResultForm.data.resultado_obtenido} error={testResultForm.errors.resultado_obtenido} onChange={(event) => testResultForm.setData('resultado_obtenido', event.target.value)} />
                    <div className="md:col-span-2">
                        <FormTextareaField id="test-result-notes" label="Notas" value={testResultForm.data.notas} error={testResultForm.errors.notas} onChange={(event) => testResultForm.setData('notas', event.target.value)} />
                    </div>
                </div>
            </CrudFormDialog>

            <CrudFormDialog open={evidenceOpen} onOpenChange={setEvidenceOpen} title="Agregar evidencia QA" description="Relaciona un adjunto existente o agrega un enlace/nota de evidencia." processing={evidenceForm.processing} submitLabel="Agregar evidencia" onSubmit={submitEvidence}>
                <div className="grid gap-4 md:grid-cols-2">
                    <Field>
                        <Label>Resultado relacionado</Label>
                        <Select value={evidenceForm.data.test_result_id || 'none'} onValueChange={(value) => evidenceForm.setData('test_result_id', value === 'none' ? '' : value)}>
                            <SelectTrigger className="w-full"><SelectValue placeholder="Sin resultado" /></SelectTrigger>
                            <SelectContent>
                                <SelectItem value="none">Sin resultado</SelectItem>
                                {ticket.test_results.map((result) => <SelectItem key={result.id} value={result.id}>{result.titulo}</SelectItem>)}
                            </SelectContent>
                        </Select>
                        {evidenceForm.errors.test_result_id && <FieldError>{evidenceForm.errors.test_result_id}</FieldError>}
                    </Field>
                    <Field>
                        <Label>Adjunto existente</Label>
                        <Select value={evidenceForm.data.adjunto_id || 'none'} onValueChange={(value) => evidenceForm.setData('adjunto_id', value === 'none' ? '' : value)}>
                            <SelectTrigger className="w-full"><SelectValue placeholder="Sin adjunto" /></SelectTrigger>
                            <SelectContent>
                                <SelectItem value="none">Sin adjunto</SelectItem>
                                {ticket.adjuntos.map((file) => <SelectItem key={file.id} value={file.id}>{file.nombre_original}</SelectItem>)}
                            </SelectContent>
                        </Select>
                        {evidenceForm.errors.adjunto_id && <FieldError>{evidenceForm.errors.adjunto_id}</FieldError>}
                    </Field>
                    <FormInputField id="qa-evidence-title" label="Titulo" value={evidenceForm.data.titulo} error={evidenceForm.errors.titulo} onChange={(event) => evidenceForm.setData('titulo', event.target.value)} />
                    <Field>
                        <Label>Tipo</Label>
                        <Select value={evidenceForm.data.tipo || 'otro'} onValueChange={(value) => evidenceForm.setData('tipo', value)}>
                            <SelectTrigger className="w-full"><SelectValue /></SelectTrigger>
                            <SelectContent>{qaOptions.evidenceTypes.map((type) => <SelectItem key={type} value={type}>{type}</SelectItem>)}</SelectContent>
                        </Select>
                        {evidenceForm.errors.tipo && <FieldError>{evidenceForm.errors.tipo}</FieldError>}
                    </Field>
                    <div className="md:col-span-2">
                        <FormInputField id="qa-evidence-url" label="URL" value={evidenceForm.data.url} error={evidenceForm.errors.url} onChange={(event) => evidenceForm.setData('url', event.target.value)} />
                    </div>
                    <div className="md:col-span-2">
                        <FormTextareaField id="qa-evidence-description" label="Descripcion" value={evidenceForm.data.descripcion} error={evidenceForm.errors.descripcion} onChange={(event) => evidenceForm.setData('descripcion', event.target.value)} />
                    </div>
                </div>
            </CrudFormDialog>

            <CrudFormDialog open={validationOpen} onOpenChange={setValidationOpen} title="Crear validacion" description="Registra validacion interna, QA, soporte o cliente." processing={validationForm.processing} submitLabel="Guardar validacion" onSubmit={submitValidation}>
                <div className="grid gap-4 md:grid-cols-2">
                    <Field>
                        <Label>Tipo</Label>
                        <Select value={validationForm.data.tipo} onValueChange={(value) => validationForm.setData('tipo', value)}>
                            <SelectTrigger className="w-full"><SelectValue /></SelectTrigger>
                            <SelectContent>{qaOptions.validationTypes.map((type) => <SelectItem key={type} value={type}>{type}</SelectItem>)}</SelectContent>
                        </Select>
                        {validationForm.errors.tipo && <FieldError>{validationForm.errors.tipo}</FieldError>}
                    </Field>
                    <Field>
                        <Label>Estado</Label>
                        <Select value={validationForm.data.status} onValueChange={(value) => validationForm.setData('status', value)}>
                            <SelectTrigger className="w-full"><SelectValue /></SelectTrigger>
                            <SelectContent>{['pendiente', 'aprobado', 'rechazado'].map((status) => <SelectItem key={status} value={status}>{status}</SelectItem>)}</SelectContent>
                        </Select>
                        {validationForm.errors.status && <FieldError>{validationForm.errors.status}</FieldError>}
                    </Field>
                    <div className="md:col-span-2">
                        <FormTextareaField id="qa-validation-comment" label="Comentario" value={validationForm.data.comentario} error={validationForm.errors.comentario} onChange={(event) => validationForm.setData('comentario', event.target.value)} />
                    </div>
                </div>
            </CrudFormDialog>

            <CrudFormDialog open={emailOpen} onOpenChange={setEmailOpen} title="Enviar correo" description="El correo requiere confirmacion humana y queda registrado en notificaciones." processing={emailForm.processing} submitLabel="Enviar correo" onSubmit={(event) => {
                event.preventDefault();
                emailForm.post(route('tickets.notifications.email', ticket.id), { preserveScroll: true, onSuccess: () => setEmailOpen(false) });
            }}>
                <div className="grid gap-4 md:grid-cols-2">
                    <Field>
                        <Label>Contacto</Label>
                        <Select value={emailForm.data.contacto_id || 'manual'} onValueChange={(value) => {
                            if (value === 'manual') {
                                emailForm.setData((data) => ({ ...data, contacto_id: '', recipient: '' }));
                                return;
                            }
                            const contacto = contactos.find((item) => item.id === value);
                            emailForm.setData((data) => ({ ...data, contacto_id: value, recipient: contacto?.email ?? '' }));
                        }}>
                            <SelectTrigger className="w-full"><SelectValue placeholder="Contacto" /></SelectTrigger>
                            <SelectContent>
                                <SelectItem value="manual">Manual</SelectItem>
                                {contactos.filter((contacto) => contacto.client_id === ticket.cliente?.id || contacto.email).map((contacto) => <SelectItem key={contacto.id} value={contacto.id}>{contacto.nombre} {contacto.email ? `(${contacto.email})` : ''}</SelectItem>)}
                            </SelectContent>
                        </Select>
                        {emailForm.errors.contacto_id && <FieldError>{emailForm.errors.contacto_id}</FieldError>}
                    </Field>
                    <FormInputField id="email-recipient" label="Destinatario" type="email" value={emailForm.data.recipient} error={emailForm.errors.recipient} onChange={(event) => emailForm.setData('recipient', event.target.value)} />
                    <div className="md:col-span-2"><FormInputField id="email-subject" label="Asunto" value={emailForm.data.subject} error={emailForm.errors.subject} onChange={(event) => emailForm.setData('subject', event.target.value)} /></div>
                    <div className="md:col-span-2"><FormTextareaField id="email-message" label="Mensaje" value={emailForm.data.message} error={emailForm.errors.message} onChange={(event) => emailForm.setData('message', event.target.value)} /></div>
                    <label className="flex items-center gap-2 text-sm md:col-span-2"><Checkbox checked={emailForm.data.save_as_public_comment} onCheckedChange={(value) => emailForm.setData('save_as_public_comment', Boolean(value))} /> Guardar como comentario publico si se envia correctamente</label>
                </div>
            </CrudFormDialog>

            <FilePickerDialog
                open={filesOpen}
                onOpenChange={setFilesOpen}
                title={`Adjuntos · ${ticket.folio}`}
                description="Sube evidencia del ticket. Se permiten imagenes, PDF, documentos, hojas de calculo, texto, CSV y ZIP."
                storedFiles={ticket.adjuntos.map((file) => ({ id: file.id, original_name: file.nombre_original, path: file.ruta, url: file.url, mime_type: file.mime_type, size: file.size }))}
                onUpload={uploadFiles}
                onDeleteStoredFile={(fileId) => router.delete(route('tickets.attachments.destroy', [ticket.id, fileId]), { preserveScroll: true })}
                onDownloadStoredFile={(file) => window.open(route('tickets.attachments.download', [ticket.id, file.id]), '_blank', 'noopener,noreferrer')}
                accept=".jpg,.jpeg,.png,.webp,.pdf,.doc,.docx,.xls,.xlsx,.txt,.csv,.zip"
                maxSizeHint="Maximo 10MB"
            />
        </AppLayout>
    );
}

function Info({ label, value }: { label: string; value?: string | null }) {
    return <div className="rounded-md border p-3"><p className="text-xs text-muted-foreground">{label}</p><p className="text-sm font-medium">{value || '-'}</p></div>;
}

function MiniTimeline({ title, empty, rows }: { title: string; empty: string; rows: { id: string; title: string; meta: string; date: string; href: string }[] }) {
    return (
        <div className="space-y-2">
            <h3 className="text-sm font-medium">{title}</h3>
            {rows.length === 0 ? (
                <p className="rounded-md border p-3 text-sm text-muted-foreground">{empty}</p>
            ) : rows.slice(0, 5).map((row) => (
                <Link key={row.id} href={row.href} className="block rounded-md border p-3 text-sm hover:bg-muted/40">
                    <div className="flex items-start justify-between gap-2">
                        <span className="font-medium">{row.title}</span>
                        <Badge variant="outline">{row.meta}</Badge>
                    </div>
                    <p className="mt-1 text-xs text-muted-foreground">{new Date(row.date).toLocaleString('es-MX')}</p>
                </Link>
            ))}
        </div>
    );
}

function formatMinutes(minutes: number) {
    if (minutes < 60) return `${minutes} min`;
    const hours = Math.floor(minutes / 60);
    const rest = minutes % 60;
    return rest > 0 ? `${hours} h ${rest} min` : `${hours} h`;
}

function formatDateTime(value?: string | null) {
    return value ? new Date(value).toLocaleString('es-MX') : null;
}

function formatBoolean(value?: boolean | null) {
    if (value === null || value === undefined) return 'Pendiente';
    return value ? 'Cumplido' : 'Incumplido';
}

function slaVariant(status?: string | null): 'default' | 'secondary' | 'destructive' | 'outline' {
    if (status === 'vencido' || status === 'incumplido') return 'destructive';
    if (status === 'en_riesgo') return 'secondary';
    if (status === 'cumplido' || status === 'en_tiempo') return 'default';
    return 'outline';
}

function developmentStatusVariant(status?: string | null): 'default' | 'secondary' | 'destructive' | 'outline' {
    if (status === 'rechazado' || status === 'cancelado') return 'destructive';
    if (status === 'deployado' || status === 'mergeado' || status === 'listo_para_release') return 'default';
    if (status === 'en_desarrollo' || status === 'pr_abierto' || status === 'en_revision' || status === 'aprobado') return 'secondary';
    return 'outline';
}

function qaStatusVariant(status?: string | null): 'default' | 'secondary' | 'destructive' | 'outline' {
    if (status === 'rechazado' || status === 'fallido' || status === 'bloqueado') return 'destructive';
    if (status === 'aprobado' || status === 'no_aplica') return 'default';
    if (status === 'en_pruebas') return 'secondary';
    return 'outline';
}

function quoteStatusVariant(status?: string | null): 'default' | 'secondary' | 'destructive' | 'outline' {
    if (status === 'rechazada_cliente' || status === 'cancelada') return 'destructive';
    if (status === 'aprobada_cliente' || status === 'convertida') return 'default';
    if (status === 'aprobada_internamente' || status === 'enviada') return 'secondary';
    return 'outline';
}

function formatCurrency(value?: string | number | null) {
    return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(Number(value ?? 0));
}

function SimpleSelectDialog({ open, setOpen, title, label, form, field, options, submitLabel, onSubmit }: { open: boolean; setOpen: (open: boolean) => void; title: string; label: string; form: ReturnType<typeof useForm<Record<string, string>>>; field: string; options: { value: string; label: string }[]; submitLabel: string; onSubmit: () => void }) {
    return (
        <CrudFormDialog open={open} onOpenChange={setOpen} title={title} description={label} processing={form.processing} submitLabel={submitLabel} onSubmit={(event) => { event.preventDefault(); onSubmit(); }}>
            <Field>
                <Label>{label}</Label>
                <Select value={form.data[field]} onValueChange={(value) => form.setData(field, value)}>
                    <SelectTrigger className="w-full"><SelectValue placeholder={label} /></SelectTrigger>
                    <SelectContent>{options.map((option) => <SelectItem key={option.value} value={option.value}>{option.label}</SelectItem>)}</SelectContent>
                </Select>
                {form.errors[field] && <FieldError>{form.errors[field]}</FieldError>}
            </Field>
        </CrudFormDialog>
    );
}

const toCatalogOption = (option: CatalogOption) => ({ value: String(option.id), label: option.nombre });
const toUserOption = (option: UserOption) => ({ value: String(option.id), label: option.name });
