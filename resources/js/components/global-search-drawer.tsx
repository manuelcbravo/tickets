import { Link } from '@inertiajs/react';
import { Search } from 'lucide-react';
import { useEffect, useState } from 'react';
import { route } from 'ziggy-js';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Separator } from '@/components/ui/separator';
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';
import { Skeleton } from '@/components/ui/skeleton';

type ClientSearchResult = {
    id: string;
    full_name: string;
    phone: string | null;
    email: string | null;
};

type AppointmentSearchResult = {
    id: string;
    client_name: string;
    staff_name: string;
    services_label: string;
    start_at: string | null;
    start_at_label: string | null;
    status: string;
    is_google_synced: boolean;
};

type SearchResponse = {
    clients: ClientSearchResult[];
    appointments: AppointmentSearchResult[];
};

const MIN_SEARCH_LENGTH = 3;
const DEBOUNCE_MS = 350;

export function GlobalSearchDrawer() {
    const [open, setOpen] = useState(false);
    const [query, setQuery] = useState('');
    const [debouncedQuery, setDebouncedQuery] = useState('');
    const [loading, setLoading] = useState(false);
    const [results, setResults] = useState<SearchResponse>({
        clients: [],
        appointments: [],
    });
    const [requestError, setRequestError] = useState<string | null>(null);

    useEffect(() => {
        const timer = window.setTimeout(() => {
            setDebouncedQuery(query.trim());
        }, DEBOUNCE_MS);

        return () => window.clearTimeout(timer);
    }, [query]);

    useEffect(() => {
        if (!open) return;

        if (debouncedQuery.length < MIN_SEARCH_LENGTH) {
            setLoading(false);
            setRequestError(null);
            setResults({
                clients: [],
                appointments: [],
            });
            return;
        }

        const controller = new AbortController();
        setLoading(true);
        setRequestError(null);

        fetch(
            `${route('appointments.search.global')}?${new URLSearchParams({ search: debouncedQuery }).toString()}`,
            {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                signal: controller.signal,
            },
        )
            .then(async (response) => {
                if (!response.ok) {
                    throw new Error(`Error ${response.status}`);
                }

                const payload = (await response.json()) as SearchResponse;
                setResults({
                    clients: payload.clients ?? [],
                    appointments: payload.appointments ?? [],
                });
            })
            .catch((error: unknown) => {
                if (error instanceof Error && error.name === 'AbortError') {
                    return;
                }

                setRequestError('No se pudo completar la busqueda.');
                setResults({
                    clients: [],
                    appointments: [],
                });
            })
            .finally(() => setLoading(false));

        return () => controller.abort();
    }, [debouncedQuery, open]);

    const showMinLengthHint = debouncedQuery.length < MIN_SEARCH_LENGTH;
    const hasResults = results.clients.length > 0 || results.appointments.length > 0;

    return (
        <Sheet open={open} onOpenChange={setOpen}>
            <SheetTrigger asChild>
                <Button
                    type="button"
                    variant="ghost"
                    size="sm"
                    className="group h-10 rounded-full border border-border/70 bg-gradient-to-b from-background to-muted/40 px-4 text-foreground shadow-sm transition-all hover:border-primary/40 hover:from-muted/60 hover:to-muted hover:shadow focus-visible:ring-2 focus-visible:ring-primary/40"
                >
                    <span className="mr-2 inline-flex size-6 items-center justify-center rounded-full bg-primary/10 text-primary transition-colors group-hover:bg-primary/15">
                        <Search className="size-3.5" />
                    </span>
                    <span className="hidden text-sm font-medium sm:inline">Busqueda</span>
                </Button>
            </SheetTrigger>
            <SheetContent side="right" className="w-full sm:max-w-xl">
                <SheetHeader className="px-6 pb-3">
                    <SheetTitle>Busqueda global </SheetTitle>
                    <SheetDescription>Busca clientes un solo lugar.</SheetDescription>
                </SheetHeader>

                <div className="px-6 pb-4">
                    <Input
                        autoFocus
                        value={query}
                        onChange={(event) => setQuery(event.target.value)}
                        placeholder="Escribe nombre, telefono, correo"
                    />
                    <p className="mt-2 text-xs text-muted-foreground">
                        Minimo {MIN_SEARCH_LENGTH} caracteres para buscar.
                    </p>
                </div>

                <Separator />

                <div className="flex-1 overflow-y-auto px-6 py-4">
                    {showMinLengthHint && (
                        <div className="rounded-md border border-dashed p-4 text-sm text-muted-foreground">
                            Escribe al menos {MIN_SEARCH_LENGTH} caracteres para iniciar la busqueda.
                        </div>
                    )}

                    {!showMinLengthHint && loading && (
                        <div className="space-y-4">
                            <section className="space-y-2">
                                <Skeleton className="h-4 w-24" />
                                <div className="space-y-2">
                                    <Skeleton className="h-16 w-full" />
                                    <Skeleton className="h-16 w-full" />
                                </div>
                            </section>
                            <section className="space-y-2">
                                <Skeleton className="h-4 w-20" />
                                <div className="space-y-2">
                                    <Skeleton className="h-20 w-full" />
                                    <Skeleton className="h-20 w-full" />
                                </div>
                            </section>
                        </div>
                    )}

                    {!showMinLengthHint && !loading && requestError && (
                        <div className="rounded-md border border-destructive/30 bg-destructive/10 p-3 text-sm text-destructive">
                            {requestError}
                        </div>
                    )}

                    {!showMinLengthHint && !loading && !requestError && !hasResults && (
                        <div className="rounded-md border border-dashed p-4 text-sm text-muted-foreground">
                            Sin resultados para "{debouncedQuery}".
                        </div>
                    )}

                    {!showMinLengthHint && !loading && !requestError && hasResults && (
                        <div className="space-y-6">
                            <section className="space-y-2">
                                <div className="flex items-center justify-between">
                                    <h3 className="text-sm font-semibold">Clientes</h3>
                                    <span className="text-xs text-muted-foreground">{results.clients.length}</span>
                                </div>
                                {results.clients.length === 0 ? (
                                    <p className="text-sm text-muted-foreground">Sin clientes.</p>
                                ) : (
                                    <div className="space-y-2">
                                        {results.clients.map((client) => (
                                            <Link
                                                key={client.id}
                                                href={route('clients.show', client.id)}
                                                onClick={() => setOpen(false)}
                                                className="block rounded-md border p-3 transition hover:bg-muted/40"
                                            >
                                                <p className="font-medium">{client.full_name}</p>
                                                <p className="text-xs text-muted-foreground">
                                                    {client.phone || 'Sin telefono'} - {client.email || 'Sin correo'}
                                                </p>
                                            </Link>
                                        ))}
                                    </div>
                                )}
                            </section>

                            <section className="space-y-2">
                                <div className="flex items-center justify-between">
                                    <h3 className="text-sm font-semibold">Citas</h3>
                                    <span className="text-xs text-muted-foreground">{results.appointments.length}</span>
                                </div>
                                {results.appointments.length === 0 ? (
                                    <p className="text-sm text-muted-foreground">Sin citas.</p>
                                ) : (
                                    <div className="space-y-2">
                                        {results.appointments.map((appointment) => (
                                            <Link
                                                key={appointment.id}
                                                href={route('appointments.show', appointment.id)}
                                                onClick={() => setOpen(false)}
                                                className="block rounded-md border p-3 transition hover:bg-muted/40"
                                            >
                                                <div className="flex items-center justify-between gap-2">
                                                    <p className="font-medium">{appointment.client_name}</p>
                                                    {appointment.is_google_synced && (
                                                        <Badge variant="secondary">Sincronizado</Badge>
                                                    )}
                                                </div>
                                                <p className="text-xs text-muted-foreground">
                                                    {appointment.start_at_label || 'Sin fecha'} - {appointment.staff_name}
                                                </p>
                                                <p className="text-xs text-muted-foreground">
                                                    {appointment.services_label || 'Sin servicios'}
                                                </p>
                                            </Link>
                                        ))}
                                    </div>
                                )}
                            </section>
                        </div>
                    )}
                </div>
            </SheetContent>
        </Sheet>
    );
}
