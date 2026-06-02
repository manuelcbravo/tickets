import { Head, router, useForm } from '@inertiajs/react';
import type React from 'react';
import { useState } from 'react';
import { route } from 'ziggy-js';
import { CrudFormDialog } from '@/components/crud-form-dialog';
import { FormTextareaField } from '@/components/form-textarea-field';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Field, FieldError } from '@/components/ui/field';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';

type Message = {
    id: string;
    channel: string;
    direction: string;
    sender: string | null;
    recipient: string | null;
    message: string | null;
    payload: Record<string, unknown> | null;
    ticket?: { id: string; folio: string; titulo: string } | null;
};

type TicketOption = { id: string; folio: string; titulo: string };

export default function ExternalMessageShow({ message, ticketOptions }: { message: Message; ticketOptions: TicketOption[] }) {
    const [linkOpen, setLinkOpen] = useState(false);
    const [commentOpen, setCommentOpen] = useState(false);
    const linkForm = useForm({ ticket_id: message.ticket?.id ?? '' });
    const commentForm = useForm({ es_interno: true, mensaje: message.message ?? '' });
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Mensajes externos', href: route('integrations.messages.index') },
        { title: message.channel, href: route('integrations.messages.show', message.id) },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Mensaje externo" />
            <div className="space-y-4 rounded-xl p-4">
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
                    <div className="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div><Badge variant="outline">{message.channel}</Badge><h1 className="mt-2 text-xl font-semibold">{message.direction}</h1><p className="text-sm text-muted-foreground">{message.sender ?? '-'} {'->'} {message.recipient ?? '-'}</p></div>
                        <div className="flex gap-2"><Button variant="outline" onClick={() => setLinkOpen(true)}>Vincular ticket</Button><Button disabled={!message.ticket} onClick={() => setCommentOpen(true)}>Convertir a comentario</Button></div>
                    </div>
                </div>
                <div className="grid gap-4 xl:grid-cols-2">
                    <Card className="rounded-lg"><CardHeader><CardTitle>Mensaje</CardTitle></CardHeader><CardContent><p className="whitespace-pre-wrap text-sm">{message.message ?? '-'}</p></CardContent></Card>
                    <Card className="rounded-lg"><CardHeader><CardTitle>Payload</CardTitle></CardHeader><CardContent><pre className="max-h-96 overflow-auto rounded-md bg-muted p-3 text-xs">{JSON.stringify(message.payload ?? {}, null, 2)}</pre></CardContent></Card>
                </div>
            </div>

            <CrudFormDialog open={linkOpen} onOpenChange={setLinkOpen} title="Vincular mensaje" description="Selecciona un ticket existente." submitLabel="Vincular" processing={linkForm.processing} onSubmit={(event: React.FormEvent<HTMLFormElement>) => { event.preventDefault(); linkForm.patch(route('integrations.messages.link-ticket', message.id), { preserveScroll: true, onSuccess: () => setLinkOpen(false) }); }}>
                <Field>
                    <Label>Ticket</Label>
                    <Select value={linkForm.data.ticket_id} onValueChange={(value) => linkForm.setData('ticket_id', value)}>
                        <SelectTrigger><SelectValue placeholder="Ticket" /></SelectTrigger>
                        <SelectContent>{ticketOptions.map((ticket) => <SelectItem key={ticket.id} value={ticket.id}>{ticket.folio} - {ticket.titulo}</SelectItem>)}</SelectContent>
                    </Select>
                    {linkForm.errors.ticket_id && <FieldError>{linkForm.errors.ticket_id}</FieldError>}
                </Field>
            </CrudFormDialog>

            <CrudFormDialog open={commentOpen} onOpenChange={setCommentOpen} title="Convertir a comentario" description="El comentario se agrega al ticket vinculado." submitLabel="Crear comentario" processing={commentForm.processing} onSubmit={(event) => { event.preventDefault(); commentForm.post(route('integrations.messages.convert-comment', message.id), { preserveScroll: true, onSuccess: () => setCommentOpen(false) }); }}>
                <label className="flex items-center gap-2 text-sm"><Checkbox checked={commentForm.data.es_interno} onCheckedChange={(value) => commentForm.setData('es_interno', Boolean(value))} /> Comentario interno</label>
                <FormTextareaField id="external-comment" label="Mensaje" value={commentForm.data.mensaje} error={commentForm.errors.mensaje} onChange={(event) => commentForm.setData('mensaje', event.target.value)} />
            </CrudFormDialog>
        </AppLayout>
    );
}
