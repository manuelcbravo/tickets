import { Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, ClientOption, ContactOption, ProjectOption } from '@/types';
import { QuoteForm, type QuoteModel } from './form';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Cotizaciones', href: route('quotes.index') },
    { title: 'Editar', href: '#' },
];

export default function QuotesEdit({ quote, clientes, proyectos, contactos, estados }: { quote: QuoteModel; clientes: ClientOption[]; proyectos: ProjectOption[]; contactos: ContactOption[]; estados: string[] }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Editar cotizacion" />
            <div className="rounded-xl p-4">
                <QuoteForm quote={quote} clientes={clientes} proyectos={proyectos} contactos={contactos} estados={estados} />
            </div>
        </AppLayout>
    );
}
