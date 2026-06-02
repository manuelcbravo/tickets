import { Head, Link } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';

type Integration = {
    id: string;
    nombre: string;
    tipo: string;
    proveedor: string | null;
    descripcion: string | null;
    activo: boolean;
    config?: Record<string, unknown> | null;
};

type Row = { id: string; status?: string; event_type?: string | null; channel?: string; subject?: string | null; created_at: string };

export default function IntegrationShow({ integration, webhookEvents, notificationLogs, externalMessages }: { integration: Integration; webhookEvents: Row[]; notificationLogs: Row[]; externalMessages: Row[] }) {
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Integraciones', href: route('integrations.index') },
        { title: integration.nombre, href: route('integrations.show', integration.id) },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={integration.nombre} />
            <div className="space-y-4 rounded-xl p-4">
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
                    <div className="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <Badge variant={integration.activo ? 'default' : 'secondary'}>{integration.activo ? 'Activa' : 'Inactiva'}</Badge>
                            <h1 className="mt-2 text-2xl font-semibold">{integration.nombre}</h1>
                            <p className="text-sm text-muted-foreground">{labelize(integration.tipo)}{integration.proveedor ? ` / ${labelize(integration.proveedor)}` : ''}</p>
                        </div>
                        <div className="flex gap-2"><Button asChild variant="outline"><Link href={route('integrations.index')}>Volver</Link></Button><Button asChild><Link href={route('integrations.edit', integration.id)}>Editar</Link></Button></div>
                    </div>
                </div>

                <Card className="rounded-lg">
                    <CardHeader><CardTitle>Configuracion visible</CardTitle></CardHeader>
                    <CardContent className="grid gap-4 md:grid-cols-2">
                        <div><h3 className="font-medium">Descripcion</h3><p className="text-sm text-muted-foreground">{integration.descripcion ?? '-'}</p></div>
                        <pre className="overflow-auto rounded-md bg-muted p-3 text-xs">{JSON.stringify(integration.config ?? {}, null, 2)}</pre>
                    </CardContent>
                </Card>

                <div className="grid gap-4 xl:grid-cols-3">
                    <SimpleTable title="Webhooks recientes" rows={webhookEvents} type="webhook" />
                    <SimpleTable title="Notificaciones recientes" rows={notificationLogs} type="notification" />
                    <SimpleTable title="Mensajes externos" rows={externalMessages} type="message" />
                </div>
            </div>
        </AppLayout>
    );
}

function SimpleTable({ title, rows, type }: { title: string; rows: Row[]; type: 'webhook' | 'notification' | 'message' }) {
    return (
        <Card className="rounded-lg">
            <CardHeader><CardTitle>{title}</CardTitle></CardHeader>
            <CardContent>
                <Table>
                    <TableHeader><TableRow><TableHead>Tipo</TableHead><TableHead>Estado</TableHead><TableHead>Fecha</TableHead></TableRow></TableHeader>
                    <TableBody>
                        {rows.length === 0 ? <TableRow><TableCell colSpan={3} className="text-muted-foreground">Sin registros.</TableCell></TableRow> : rows.map((row) => (
                            <TableRow key={row.id}>
                                <TableCell>{row.event_type ?? row.channel ?? row.subject ?? type}</TableCell>
                                <TableCell><Badge variant={row.status === 'failed' ? 'destructive' : 'outline'}>{row.status ?? '-'}</Badge></TableCell>
                                <TableCell>{new Date(row.created_at).toLocaleDateString('es-MX')}</TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </CardContent>
        </Card>
    );
}

const labelize = (value: string) => value.replaceAll('_', ' ');
