import { Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, TicketOptionProps } from '@/types';
import { TicketForm } from './form';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Tickets', href: route('tickets.index') },
    { title: 'Crear ticket', href: route('tickets.create') },
];

export default function TicketsCreate(props: TicketOptionProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Crear ticket" />

            <div className="space-y-4 rounded-xl p-4">
                <Card className="rounded-lg">
                    <CardHeader>
                        <CardTitle>Crear ticket</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <TicketForm
                            {...props}
                            submitUrl={route('tickets.store')}
                            submitLabel="Guardar ticket"
                        />
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
