import { Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, ClientOption, ContactOption, ProjectOption } from '@/types';
import { QuoteForm } from './form';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Cotizaciones', href: route('quotes.index') },
    { title: 'Nueva', href: route('quotes.create') },
];

export default function QuotesCreate({ clientes, proyectos, contactos, estados }: { clientes: ClientOption[]; proyectos: ProjectOption[]; contactos: ContactOption[]; estados: string[] }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Nueva cotizacion" />
            <div className="rounded-xl p-4">
                <QuoteForm clientes={clientes} proyectos={proyectos} contactos={contactos} estados={estados} />
            </div>
        </AppLayout>
    );
}
