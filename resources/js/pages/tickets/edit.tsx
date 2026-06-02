import { Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, TicketFormValues, TicketOptionProps } from '@/types';
import { TicketForm } from './form';

type TicketEdit = {
    id: string;
    folio: string;
} & Partial<{
    cliente_id: string;
    proyecto_id: string | null;
    proyecto_modulo_id: string | null;
    contacto_id: string | null;
    ambiente_id: string | null;
    titulo: string;
    descripcion: string;
    tipo_id: number;
    estado_id: number | null;
    prioridad_id: number;
    impacto_id: number | null;
    urgencia_id: number | null;
    riesgo_id: number | null;
    dificultad: string | null;
    responsable_id: number | null;
    fecha_objetivo: string | null;
    tiempo_estimado_min: number | null;
    requires_code_change: boolean;
    requires_quote: boolean;
    is_internal: boolean;
}>;

export default function TicketsEdit({ ticket, ...props }: TicketOptionProps & { ticket: TicketEdit }) {
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Tickets', href: route('tickets.index') },
        { title: ticket.folio, href: route('tickets.edit', ticket.id) },
    ];

    const initialValues: Partial<TicketFormValues> = {
        cliente_id: ticket.cliente_id ?? '',
        proyecto_id: ticket.proyecto_id ?? 'none',
        proyecto_modulo_id: ticket.proyecto_modulo_id ?? 'none',
        contacto_id: ticket.contacto_id ?? 'none',
        ambiente_id: ticket.ambiente_id ?? 'none',
        titulo: ticket.titulo ?? '',
        descripcion: ticket.descripcion ?? '',
        tipo_id: ticket.tipo_id ? String(ticket.tipo_id) : '',
        estado_id: ticket.estado_id ? String(ticket.estado_id) : 'none',
        prioridad_id: ticket.prioridad_id ? String(ticket.prioridad_id) : '',
        impacto_id: ticket.impacto_id ? String(ticket.impacto_id) : 'none',
        urgencia_id: ticket.urgencia_id ? String(ticket.urgencia_id) : 'none',
        riesgo_id: ticket.riesgo_id ? String(ticket.riesgo_id) : 'none',
        dificultad: ticket.dificultad ?? '',
        responsable_id: ticket.responsable_id ? String(ticket.responsable_id) : 'none',
        fecha_objetivo: ticket.fecha_objetivo ? ticket.fecha_objetivo.slice(0, 16) : '',
        tiempo_estimado_min: ticket.tiempo_estimado_min ? String(ticket.tiempo_estimado_min) : '',
        requires_code_change: ticket.requires_code_change ?? false,
        requires_quote: ticket.requires_quote ?? false,
        is_internal: ticket.is_internal ?? false,
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Editar ${ticket.folio}`} />
            <div className="space-y-4 rounded-xl p-4">
                <Card className="rounded-lg">
                    <CardHeader>
                        <CardTitle>Editar ticket {ticket.folio}</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <TicketForm
                            {...props}
                            initialValues={initialValues}
                            submitUrl={route('tickets.update', ticket.id)}
                            submitLabel="Guardar cambios"
                            method="put"
                        />
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
