import { Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, KnowledgeFormValues, KnowledgeOptionProps } from '@/types';
import { KnowledgeForm } from './form';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Base de conocimiento', href: route('knowledge.index') },
    { title: 'Nuevo articulo', href: route('knowledge.create') },
];

export default function KnowledgeCreate(props: KnowledgeOptionProps & { defaults?: Partial<KnowledgeFormValues>; sourceTicket?: { id: string; folio: string; titulo: string } }) {
    const submitUrl = props.sourceTicket ? route('tickets.knowledge.store', props.sourceTicket.id) : route('knowledge.store');

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Nuevo articulo" />
            <div className="space-y-4 rounded-xl p-4">
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
                    <h1 className="text-xl font-semibold">Nuevo articulo</h1>
                    <p className="text-sm text-muted-foreground">{props.sourceTicket ? `Desde ticket ${props.sourceTicket.folio}` : 'Documenta soluciones, procedimientos y aprendizajes.'}</p>
                </div>
                <KnowledgeForm {...props} defaults={props.defaults} submitUrl={submitUrl} submitLabel="Guardar articulo" />
            </div>
        </AppLayout>
    );
}
