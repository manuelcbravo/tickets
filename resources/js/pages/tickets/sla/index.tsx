import { Head, Link, router, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import { Search, Settings, XCircle } from 'lucide-react';
import { useEffect, useState } from 'react';
import { route } from 'ziggy-js';
import { ModuleHeader } from '@/components/module-header';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, CatalogOption, ClientOption, SharedData, UserOption } from '@/types';

type SlaRow = {
    id: string;
    estado_sla: string;
    vence_primera_respuesta_at: string | null;
    vence_resolucion_at: string | null;
    ticket?: {
        id: string;
        folio: string;
        titulo: string;
        cliente?: { nombre: string | null } | null;
        proyecto?: { nombre: string | null } | null;
        responsable?: { name: string } | null;
        estado?: { nombre: string } | null;
    } | null;
    prioridad?: { nombre: string } | null;
};

type PaginatedSla = {
    data: SlaRow[];
    links: { url: string | null; label: string; active: boolean }[];
    from: number | null;
    to: number | null;
    total: number;
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Tickets', href: route('tickets.dashboard') },
    { title: 'SLA', href: route('tickets.sla.index') },
];

export default function TicketsSlaIndex({
    slas,
    filters,
    prioridades,
    clientes,
    users,
}: {
    slas: PaginatedSla;
    filters: Record<string, string | null>;
    prioridades: CatalogOption[];
    clientes: ClientOption[];
    users: UserOption[];
}) {
    const { flash } = usePage<SharedData>().props;

    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error) toast.error(flash.error);
    }, [flash?.error, flash?.success]);

    const [localFilters, setLocalFilters] = useState({
        estado_sla: filters.estado_sla ?? 'todos',
        prioridad_id: filters.prioridad_id ?? 'todos',
        cliente_id: filters.cliente_id ?? 'todos',
        responsable_id: filters.responsable_id ?? 'todos',
    });

    const applyFilters = () => {
        router.get(route('tickets.sla.index'), normalizeFilters(localFilters), { preserveState: true, preserveScroll: true });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Tickets - SLA" />
            <div className="space-y-4 rounded-xl p-4">
                <ModuleHeader title="SLA" description="Monitorea tiempos de respuesta y resolucion comprometidos. Ayuda a detectar tickets vencidos, en riesgo y cumplimiento de atencion por prioridad.">
                    <Button asChild variant="outline"><Link href={route('tickets.sla.settings')}><Settings className="size-4" /> Configuracion</Link></Button>
                </ModuleHeader>

                <div className="grid gap-3 md:grid-cols-5">
                    <FilterSelect value={localFilters.estado_sla} onChange={(value) => setLocalFilters({ ...localFilters, estado_sla: value })} options={slaStatuses} placeholder="Estado SLA" />
                    <FilterSelect value={localFilters.prioridad_id} onChange={(value) => setLocalFilters({ ...localFilters, prioridad_id: value })} options={prioridades.map((item) => ({ value: String(item.id), label: item.nombre }))} placeholder="Prioridad" />
                    <FilterSelect value={localFilters.cliente_id} onChange={(value) => setLocalFilters({ ...localFilters, cliente_id: value })} options={clientes.map((item) => ({ value: item.id, label: item.nombre ?? item.id }))} placeholder="Cliente" />
                    <FilterSelect value={localFilters.responsable_id} onChange={(value) => setLocalFilters({ ...localFilters, responsable_id: value })} options={users.map((item) => ({ value: String(item.id), label: item.name }))} placeholder="Responsable" />
                    <div className="flex gap-2">
                        <Button type="button" onClick={applyFilters}><Search className="size-4" /> Filtrar</Button>
                        <Button type="button" variant="outline" onClick={() => router.get(route('tickets.sla.index'))}><XCircle className="size-4" /> Limpiar</Button>
                    </div>
                </div>

                <Card className="rounded-lg">
                    <CardHeader><CardTitle>Tickets con SLA</CardTitle></CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Folio</TableHead>
                                    <TableHead>Cliente</TableHead>
                                    <TableHead>Proyecto</TableHead>
                                    <TableHead>Prioridad</TableHead>
                                    <TableHead>Responsable</TableHead>
                                    <TableHead>Estado ticket</TableHead>
                                    <TableHead>Estado SLA</TableHead>
                                    <TableHead>Primera respuesta</TableHead>
                                    <TableHead>Resolucion</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {slas.data.length === 0 ? (
                                    <TableRow><TableCell colSpan={9} className="text-muted-foreground">No hay registros SLA.</TableCell></TableRow>
                                ) : slas.data.map((sla) => (
                                    <TableRow key={sla.id}>
                                        <TableCell><Link className="font-medium text-primary hover:underline" href={route('tickets.show', sla.ticket?.id)}>{sla.ticket?.folio}</Link></TableCell>
                                        <TableCell>{sla.ticket?.cliente?.nombre ?? '-'}</TableCell>
                                        <TableCell>{sla.ticket?.proyecto?.nombre ?? '-'}</TableCell>
                                        <TableCell><Badge variant={sla.prioridad?.nombre?.startsWith('P0') ? 'destructive' : 'secondary'}>{sla.prioridad?.nombre ?? '-'}</Badge></TableCell>
                                        <TableCell>{sla.ticket?.responsable?.name ?? '-'}</TableCell>
                                        <TableCell>{sla.ticket?.estado?.nombre ?? '-'}</TableCell>
                                        <TableCell><Badge variant={slaVariant(sla.estado_sla)}>{sla.estado_sla}</Badge></TableCell>
                                        <TableCell>{formatDate(sla.vence_primera_respuesta_at)}</TableCell>
                                        <TableCell>{formatDate(sla.vence_resolucion_at)}</TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>

                <div className="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <p className="text-sm text-muted-foreground">Mostrando {slas.from ?? 0}-{slas.to ?? 0} de {slas.total}</p>
                    <div className="flex flex-wrap gap-1">
                        {slas.links.map((link, index) => (
                            <Button key={`${link.label}-${index}`} variant={link.active ? 'default' : 'outline'} size="sm" disabled={!link.url} onClick={() => link.url && router.get(link.url, {}, { preserveScroll: true })}>
                                <span dangerouslySetInnerHTML={{ __html: link.label }} />
                            </Button>
                        ))}
                    </div>
                </div>
            </div>
        </AppLayout>
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

const slaStatuses = ['pendiente', 'en_tiempo', 'en_riesgo', 'vencido', 'cumplido', 'incumplido', 'pausado'].map((status) => ({ value: status, label: status }));

function normalizeFilters(filters: Record<string, string>) {
    return Object.fromEntries(Object.entries(filters).filter(([, value]) => value !== '' && value !== 'todos'));
}

function formatDate(value?: string | null) {
    return value ? new Date(value).toLocaleString('es-MX') : '-';
}

function slaVariant(status?: string | null): 'default' | 'secondary' | 'destructive' | 'outline' {
    if (status === 'vencido' || status === 'incumplido') return 'destructive';
    if (status === 'en_riesgo') return 'secondary';
    if (status === 'cumplido' || status === 'en_tiempo') return 'default';
    return 'outline';
}
