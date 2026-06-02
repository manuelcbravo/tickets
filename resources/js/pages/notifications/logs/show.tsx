import { Head, Link, router } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';

type Log = {
    id: string;
    channel: string;
    direction: string;
    recipient: string | null;
    subject: string | null;
    message: string | null;
    payload: Record<string, unknown> | null;
    status: string;
    sent_at: string | null;
    failed_at: string | null;
    error_message: string | null;
    ticket?: { id: string; folio: string; titulo: string } | null;
    cliente?: { nombre?: string | null; razon_social?: string | null } | null;
};

export default function NotificationLogShow({ log }: { log: Log }) {
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Notificaciones', href: route('notifications.logs.index') },
        { title: log.subject ?? log.channel, href: route('notifications.logs.show', log.id) },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Notificacion" />
            <div className="space-y-4 rounded-xl p-4">
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
                    <div className="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div><Badge variant={log.status === 'failed' ? 'destructive' : log.status === 'sent' ? 'default' : 'secondary'}>{log.status}</Badge><h1 className="mt-2 text-xl font-semibold">{log.subject ?? 'Notificacion'}</h1><p className="text-sm text-muted-foreground">{log.channel} / {log.direction}</p></div>
                        {log.channel === 'email' && <Button variant="outline" onClick={() => router.patch(route('notifications.logs.resend', log.id), {}, { preserveScroll: true })}>Reenviar</Button>}
                    </div>
                </div>
                <div className="grid gap-4 xl:grid-cols-2">
                    <Card className="rounded-lg"><CardHeader><CardTitle>Detalle</CardTitle></CardHeader><CardContent className="space-y-2 text-sm"><Info label="Ticket" value={log.ticket ? `${log.ticket.folio} - ${log.ticket.titulo}` : '-'} /><Info label="Cliente" value={log.cliente?.nombre ?? log.cliente?.razon_social} /><Info label="Destinatario" value={log.recipient} /><Info label="Enviado" value={log.sent_at ? new Date(log.sent_at).toLocaleString('es-MX') : '-'} /><Info label="Error" value={log.error_message} /></CardContent></Card>
                    <Card className="rounded-lg"><CardHeader><CardTitle>Mensaje</CardTitle></CardHeader><CardContent><p className="whitespace-pre-wrap text-sm">{log.message ?? '-'}</p></CardContent></Card>
                </div>
            </div>
        </AppLayout>
    );
}

function Info({ label, value }: { label: string; value?: string | null }) {
    return <div><span className="text-muted-foreground">{label}</span><br /><span className="font-medium">{value ?? '-'}</span></div>;
}
