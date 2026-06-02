import { Head } from '@inertiajs/react';
import { Boxes, Flag, Gauge, ShieldAlert, Siren, Tags } from 'lucide-react';
import { route } from 'ziggy-js';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, CatalogOption } from '@/types';

type CatalogGroups = Record<string, CatalogOption[]>;

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Tickets', href: route('tickets.dashboard') },
    { title: 'Catalogos', href: route('tickets.catalogs') },
];

const catalogIcons = {
    Tipos: Tags,
    Estados: Boxes,
    Prioridades: Flag,
    Impactos: Gauge,
    Urgencias: Siren,
    Riesgos: ShieldAlert,
} as const;

export default function TicketCatalogs({ catalogs }: { catalogs: CatalogGroups }) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Tickets - Catalogos" />

            <div className="space-y-4 rounded-xl p-4">
                <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
                    <div className="flex items-center gap-3">
                        <Boxes className="size-5 text-primary" />
                        <div>
                            <h1 className="text-xl font-semibold">Catalogos de tickets</h1>
                            <p className="text-sm text-muted-foreground">
                                Valores base disponibles para clasificar tickets.
                            </p>
                        </div>
                    </div>
                </div>

                <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    {Object.entries(catalogs).map(([name, values]) => {
                        const Icon = catalogIcons[name as keyof typeof catalogIcons] ?? Tags;

                        return (
                            <Card key={name} className="rounded-lg">
                                <CardHeader className="flex flex-row items-start justify-between space-y-0">
                                    <div className="space-y-1">
                                        <CardTitle>{name}</CardTitle>
                                        <CardDescription>
                                            CRUD administrativo pendiente para un sprint posterior.
                                        </CardDescription>
                                    </div>
                                    <Icon className="size-5 text-muted-foreground" />
                                </CardHeader>
                                <CardContent className="space-y-3">
                                    <Badge variant="secondary">{values.length} valores base</Badge>
                                    <div className="flex flex-wrap gap-2">
                                        {values.map((value) => (
                                            <Badge key={value.id} variant={value.activo === false ? 'outline' : 'secondary'}>
                                                {value.nombre}
                                            </Badge>
                                        ))}
                                    </div>
                                </CardContent>
                            </Card>
                        );
                    })}
                </div>
            </div>
        </AppLayout>
    );
}
