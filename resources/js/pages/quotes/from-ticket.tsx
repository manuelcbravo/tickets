import { Head, Link, useForm } from '@inertiajs/react';
import type React from 'react';
import { route } from 'ziggy-js';
import { FormInputField } from '@/components/form-input-field';
import { FormTextareaField } from '@/components/form-textarea-field';
import { LoadingSubmitButton } from '@/components/loading-submit-button';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';

type TicketForQuote = {
    id: string;
    folio: string;
    titulo: string;
    descripcion: string;
    resolution?: string | null;
    cliente?: { nombre?: string | null; razon_social?: string | null } | null;
    proyecto?: { nombre?: string | null } | null;
    contacto?: { nombre?: string | null } | null;
};

export default function QuoteFromTicket({ ticket }: { ticket: TicketForQuote }) {
    const form = useForm({
        titulo: `Cotizacion ${ticket.folio} - ${ticket.titulo}`,
        alcance: `Definir alcance para ${ticket.folio}: ${ticket.titulo}`,
        incluir_descripcion_ticket: true,
        incluir_comentarios: false,
        incluir_tiempos: false,
    });

    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Tickets', href: route('tickets.index') },
        { title: ticket.folio, href: route('tickets.show', ticket.id) },
        { title: 'Crear cotizacion', href: route('tickets.quote.create', ticket.id) },
    ];

    const submit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        form.post(route('tickets.quote.store', ticket.id));
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Cotizacion desde ${ticket.folio}`} />
            <div className="grid gap-4 rounded-xl p-4 xl:grid-cols-3">
                <Card className="rounded-lg xl:col-span-2">
                    <CardHeader>
                        <CardTitle>Crear cotizacion desde ticket</CardTitle>
                        <CardDescription>La cotizacion quedara ligada al ticket origen y el ticket se marcara como requiere cotizacion.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <form className="space-y-4" onSubmit={submit}>
                            <FormInputField id="quote-title" label="Titulo" value={form.data.titulo} error={form.errors.titulo} onChange={(event) => form.setData('titulo', event.target.value)} />
                            <FormTextareaField id="quote-scope" label="Alcance base" value={form.data.alcance} error={form.errors.alcance} onChange={(event) => form.setData('alcance', event.target.value)} />
                            <div className="grid gap-3 md:grid-cols-3">
                                <label className="flex items-center gap-2 text-sm"><Checkbox checked={form.data.incluir_descripcion_ticket} onCheckedChange={(value) => form.setData('incluir_descripcion_ticket', Boolean(value))} /> Incluir descripcion</label>
                                <label className="flex items-center gap-2 text-sm"><Checkbox checked={form.data.incluir_comentarios} onCheckedChange={(value) => form.setData('incluir_comentarios', Boolean(value))} /> Incluir comentarios</label>
                                <label className="flex items-center gap-2 text-sm"><Checkbox checked={form.data.incluir_tiempos} onCheckedChange={(value) => form.setData('incluir_tiempos', Boolean(value))} /> Incluir tiempos</label>
                            </div>
                            <div className="flex justify-end gap-2">
                                <Button asChild variant="outline"><Link href={route('tickets.show', ticket.id)}>Cancelar</Link></Button>
                                <LoadingSubmitButton processing={form.processing} label="Crear cotizacion" />
                            </div>
                        </form>
                    </CardContent>
                </Card>

                <Card className="rounded-lg">
                    <CardHeader>
                        <div className="flex items-center justify-between gap-2">
                            <CardTitle>{ticket.folio}</CardTitle>
                            <Badge variant="outline">Origen</Badge>
                        </div>
                        <CardDescription>{ticket.titulo}</CardDescription>
                    </CardHeader>
                    <CardContent className="space-y-3 text-sm">
                        <div><span className="text-muted-foreground">Cliente</span><br /><span className="font-medium">{ticket.cliente?.nombre ?? ticket.cliente?.razon_social ?? '-'}</span></div>
                        <div><span className="text-muted-foreground">Proyecto</span><br /><span className="font-medium">{ticket.proyecto?.nombre ?? '-'}</span></div>
                        <div><span className="text-muted-foreground">Contacto</span><br /><span className="font-medium">{ticket.contacto?.nombre ?? '-'}</span></div>
                        <div><span className="text-muted-foreground">Descripcion</span><p className="mt-1 whitespace-pre-wrap">{ticket.descripcion}</p></div>
                        {ticket.resolution && <div><span className="text-muted-foreground">Resolucion</span><p className="mt-1 whitespace-pre-wrap">{ticket.resolution}</p></div>}
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
