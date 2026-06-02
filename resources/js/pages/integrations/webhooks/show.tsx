import { Head, Link, router, useForm } from '@inertiajs/react';
import type React from 'react';
import { route } from 'ziggy-js';
import { CrudFormDialog } from '@/components/crud-form-dialog';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Field, FieldError } from '@/components/ui/field';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';
import { useState } from 'react';

type Event = {
    id: string;
    provider: string;
    event_type: string | null;
    external_id: string | null;
    status: string;
    payload: Record<string, unknown> | null;
    headers: Record<string, unknown> | null;
    error_message: string | null;
    created_at: string;
    processed_at: string | null;
    ticket?: { id: string; folio: string; titulo: string } | null;
};

type TicketOption = { id: string; folio: string; titulo: string };

export default function WebhookEventShow({ event, ticketOptions }: { event: Event; ticketOptions: TicketOption[] }) {
    const [linkOpen, setLinkOpen] = useState(false);
    const form = useForm({ ticket_id: event.ticket?.id ?? '' });
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Webhooks', href: route('integrations.webhooks.index') },
        { title: event.provider, href: route('integrations.webhooks.show', event.id) },
    ];
    const submit = (submitEvent: React.FormEvent<HTMLFormElement>) => {
        submitEvent.preventDefault();
        form.patch(route('integrations.webhooks.link-ticket', event.id), { preserveScroll: true, onSuccess: () => setLinkOpen(false) });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Webhook" />
            <div className="space-y-4 rounded-xl p-4">
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
                    <div className="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div><Badge variant={event.status === 'failed' ? 'destructive' : event.status === 'linked' ? 'default' : 'secondary'}>{event.status}</Badge><h1 className="mt-2 text-xl font-semibold">{event.provider} / {event.event_type ?? 'evento'}</h1><p className="text-sm text-muted-foreground">{event.external_id ?? 'Sin external ID'}</p></div>
                        <div className="flex gap-2"><Button variant="outline" onClick={() => setLinkOpen(true)}>Vincular ticket</Button><Button variant="outline" onClick={() => router.patch(route('integrations.webhooks.retry', event.id), {}, { preserveScroll: true })}>Reprocesar</Button><Button variant="outline" onClick={() => router.patch(route('integrations.webhooks.ignore', event.id), {}, { preserveScroll: true })}>Ignorar</Button></div>
                    </div>
                </div>
                <div className="grid gap-4 xl:grid-cols-2">
                    <Card className="rounded-lg"><CardHeader><CardTitle>Resumen</CardTitle></CardHeader><CardContent className="space-y-2 text-sm"><Info label="Ticket" value={event.ticket ? `${event.ticket.folio} - ${event.ticket.titulo}` : '-'} /><Info label="Recibido" value={new Date(event.created_at).toLocaleString('es-MX')} /><Info label="Procesado" value={event.processed_at ? new Date(event.processed_at).toLocaleString('es-MX') : '-'} /><Info label="Error" value={event.error_message} /></CardContent></Card>
                    <Card className="rounded-lg"><CardHeader><CardTitle>Payload resumido</CardTitle></CardHeader><CardContent><pre className="max-h-96 overflow-auto rounded-md bg-muted p-3 text-xs">{JSON.stringify(event.payload ?? {}, null, 2)}</pre></CardContent></Card>
                </div>
            </div>
            <CrudFormDialog open={linkOpen} onOpenChange={setLinkOpen} title="Vincular evento" description="Selecciona el ticket que corresponde a este evento externo." submitLabel="Vincular" processing={form.processing} onSubmit={submit}>
                <Field>
                    <Label>Ticket</Label>
                    <Select value={form.data.ticket_id} onValueChange={(value) => form.setData('ticket_id', value)}>
                        <SelectTrigger><SelectValue placeholder="Selecciona ticket" /></SelectTrigger>
                        <SelectContent>{ticketOptions.map((ticket) => <SelectItem key={ticket.id} value={ticket.id}>{ticket.folio} - {ticket.titulo}</SelectItem>)}</SelectContent>
                    </Select>
                    {form.errors.ticket_id && <FieldError>{form.errors.ticket_id}</FieldError>}
                </Field>
            </CrudFormDialog>
        </AppLayout>
    );
}

function Info({ label, value }: { label: string; value?: string | null }) {
    return <div><span className="text-muted-foreground">{label}</span><br /><span className="font-medium">{value ?? '-'}</span></div>;
}
