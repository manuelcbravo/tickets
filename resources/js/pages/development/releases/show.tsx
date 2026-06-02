import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import type React from 'react';
import { Pencil, Plus, Rocket, Trash2 } from 'lucide-react';
import { useEffect, useMemo, useState } from 'react';
import { toast } from 'sonner';
import { route } from 'ziggy-js';
import { CrudFormDialog } from '@/components/crud-form-dialog';
import { FormTextareaField } from '@/components/form-textarea-field';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Field, FieldError } from '@/components/ui/field';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, SharedData } from '@/types';

type ReleaseTicket = {
    id: string;
    notas: string | null;
    ticket?: {
        id: string;
        folio: string;
        titulo: string;
        development_status: string | null;
        estado?: { nombre: string } | null;
        prioridad?: { nombre: string } | null;
        responsable?: { name: string } | null;
    } | null;
    development_task?: { id: string; titulo: string; estado: string } | null;
};

type ReleaseShow = {
    id: string;
    nombre: string;
    version: string | null;
    descripcion: string | null;
    estado: string;
    release_notes: string | null;
    scheduled_at: string | null;
    released_at: string | null;
    proyecto?: { nombre: string } | null;
    ambiente?: { nombre: string } | null;
    created_by?: { name: string } | null;
    released_by?: { name: string } | null;
    release_tickets: ReleaseTicket[];
};

type TicketOption = { id: string; folio: string; titulo: string; development_status: string | null; prioridad?: { nombre: string } | null };
type TaskOption = { id: string; ticket_id: string; titulo: string; estado: string };

export default function ReleasesShow({ release, availableTickets, availableTasks }: { release: ReleaseShow; availableTickets: TicketOption[]; availableTasks: TaskOption[] }) {
    const [ticketOpen, setTicketOpen] = useState(false);
    const { flash, auth } = usePage<SharedData>().props;
    const canManage = auth.permissions?.includes('development.releases.manage') ?? false;
    const form = useForm({ ticket_id: '', development_task_id: '', notas: '' });

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Releases', href: route('development.releases.index') },
        { title: release.nombre, href: route('development.releases.show', release.id) },
    ];

    const filteredTasks = useMemo(() => availableTasks.filter((task) => !form.data.ticket_id || task.ticket_id === form.data.ticket_id), [availableTasks, form.data.ticket_id]);

    const submitTicket = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        form.post(route('development.releases.tickets.store', release.id), {
            preserveScroll: true,
            onSuccess: () => {
                setTicketOpen(false);
                form.reset();
            },
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={release.nombre} />
            <div className="space-y-4 p-4">
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
                    <div className="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div className="flex items-center gap-3">
                            <Rocket className="size-5 text-primary" />
                            <div>
                                <h1 className="text-xl font-semibold">{release.nombre}</h1>
                                <p className="text-sm text-muted-foreground">{release.proyecto?.nombre ?? '-'} · {release.ambiente?.nombre ?? 'Sin ambiente'}</p>
                            </div>
                        </div>
                        <div className="flex flex-wrap gap-2">
                            <Badge variant={release.estado === 'liberado' ? 'default' : 'secondary'}>{release.estado}</Badge>
                            {canManage && <Button asChild variant="outline"><Link href={route('development.releases.edit', release.id)}><Pencil className="size-4" /> Editar</Link></Button>}
                            {canManage && release.estado !== 'liberado' && <Button onClick={() => router.patch(route('development.releases.publish', release.id), {}, { preserveScroll: true })}><Rocket className="size-4" /> Marcar liberado</Button>}
                        </div>
                    </div>
                </div>

                <div className="grid gap-4 lg:grid-cols-3">
                    <Card className="rounded-lg lg:col-span-2">
                        <CardHeader><CardTitle>Informacion general</CardTitle></CardHeader>
                        <CardContent className="grid gap-3 md:grid-cols-2">
                            <Info label="Version" value={release.version} />
                            <Info label="Programado" value={formatDateTime(release.scheduled_at)} />
                            <Info label="Liberado" value={formatDateTime(release.released_at)} />
                            <Info label="Liberado por" value={release.released_by?.name} />
                        </CardContent>
                    </Card>
                    <Card className="rounded-lg">
                        <CardHeader><CardTitle>Descripcion</CardTitle></CardHeader>
                        <CardContent><p className="whitespace-pre-line text-sm text-muted-foreground">{release.descripcion || 'Sin descripcion.'}</p></CardContent>
                    </Card>
                </div>

                <Card className="rounded-lg">
                    <CardHeader><CardTitle>Release notes</CardTitle></CardHeader>
                    <CardContent><p className="whitespace-pre-line text-sm">{release.release_notes || 'Sin notas de version.'}</p></CardContent>
                </Card>

                <Card className="rounded-lg">
                    <CardHeader className="flex flex-row items-center justify-between space-y-0">
                        <div>
                            <CardTitle>Tickets incluidos</CardTitle>
                            <CardDescription>Solicitudes asociadas a esta liberacion.</CardDescription>
                        </div>
                        {canManage && <Button onClick={() => setTicketOpen(true)}><Plus className="size-4" /> Agregar ticket</Button>}
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader><TableRow><TableHead>Folio</TableHead><TableHead>Titulo</TableHead><TableHead>Estado ticket</TableHead><TableHead>Estado tecnico</TableHead><TableHead>Prioridad</TableHead><TableHead>Responsable</TableHead><TableHead>Tarea</TableHead><TableHead /></TableRow></TableHeader>
                            <TableBody>
                                {release.release_tickets.length === 0 ? (
                                    <TableRow><TableCell colSpan={8} className="text-muted-foreground">Sin tickets asociados.</TableCell></TableRow>
                                ) : release.release_tickets.map((row) => (
                                    <TableRow key={row.id}>
                                        <TableCell><Link className="font-medium text-primary hover:underline" href={route('tickets.show', row.ticket?.id)}>{row.ticket?.folio}</Link></TableCell>
                                        <TableCell>{row.ticket?.titulo}</TableCell>
                                        <TableCell>{row.ticket?.estado?.nombre ?? '-'}</TableCell>
                                        <TableCell><Badge variant="outline">{row.ticket?.development_status ?? 'sin_desarrollo'}</Badge></TableCell>
                                        <TableCell>{row.ticket?.prioridad?.nombre ?? '-'}</TableCell>
                                        <TableCell>{row.ticket?.responsable?.name ?? '-'}</TableCell>
                                        <TableCell>{row.development_task?.titulo ?? '-'}</TableCell>
                                        <TableCell>{canManage && <Button variant="ghost" size="icon-sm" onClick={() => row.ticket && router.delete(route('development.releases.tickets.destroy', [release.id, row.ticket.id]), { preserveScroll: true })}><Trash2 className="size-4" /></Button>}</TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>
            </div>

            <CrudFormDialog open={ticketOpen} onOpenChange={setTicketOpen} title="Agregar ticket al release" description="Relaciona un ticket con esta liberacion." processing={form.processing} submitLabel="Agregar ticket" onSubmit={submitTicket}>
                <Field>
                    <Label>Ticket</Label>
                    <Select value={form.data.ticket_id} onValueChange={(value) => form.setData('ticket_id', value)}>
                        <SelectTrigger className="w-full"><SelectValue placeholder="Selecciona ticket" /></SelectTrigger>
                        <SelectContent>{availableTickets.map((ticket) => <SelectItem key={ticket.id} value={ticket.id}>{ticket.folio} · {ticket.titulo}</SelectItem>)}</SelectContent>
                    </Select>
                    {form.errors.ticket_id && <FieldError>{form.errors.ticket_id}</FieldError>}
                </Field>
                <Field>
                    <Label>Tarea tecnica</Label>
                    <Select value={form.data.development_task_id || 'none'} onValueChange={(value) => form.setData('development_task_id', value === 'none' ? '' : value)}>
                        <SelectTrigger className="w-full"><SelectValue placeholder="Sin tarea" /></SelectTrigger>
                        <SelectContent>
                            <SelectItem value="none">Sin tarea</SelectItem>
                            {filteredTasks.map((task) => <SelectItem key={task.id} value={task.id}>{task.titulo} · {task.estado}</SelectItem>)}
                        </SelectContent>
                    </Select>
                    {form.errors.development_task_id && <FieldError>{form.errors.development_task_id}</FieldError>}
                </Field>
                <FormTextareaField id="release-ticket-notes" label="Notas" value={form.data.notas} error={form.errors.notas} onChange={(event) => form.setData('notas', event.target.value)} />
            </CrudFormDialog>
        </AppLayout>
    );
}

function Info({ label, value }: { label: string; value?: string | null }) {
    return <div className="rounded-md border p-3"><p className="text-xs text-muted-foreground">{label}</p><p className="text-sm font-medium">{value || '-'}</p></div>;
}

function formatDateTime(value?: string | null) {
    return value ? new Date(value).toLocaleString('es-MX') : null;
}
