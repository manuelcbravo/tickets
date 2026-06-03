import { Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, KnowledgeArticle, KnowledgeOptionProps } from '@/types';
import { KnowledgeForm } from './form';

type ArticleFile = { id: string; original_name: string; path: string; url: string; mime_type: string | null; size: number };

export default function KnowledgeEdit(props: KnowledgeOptionProps & { article: KnowledgeArticle; files?: ArticleFile[] }) {
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Base de conocimiento', href: route('knowledge.index') },
        { title: props.article.titulo, href: route('knowledge.show', props.article.id) },
        { title: 'Editar', href: route('knowledge.edit', props.article.id) },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Editar - ${props.article.titulo}`} />
            <div className="space-y-4 rounded-xl p-4">
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
                    <h1 className="text-xl font-semibold">Editar articulo</h1>
                    <p className="text-sm text-muted-foreground">Si estaba publicado o en revision se guardara version anterior.</p>
                </div>
                <KnowledgeForm {...props} article={props.article} files={props.files} submitUrl={route('knowledge.update', props.article.id)} submitLabel="Actualizar articulo" method="put" />
            </div>
        </AppLayout>
    );
}
