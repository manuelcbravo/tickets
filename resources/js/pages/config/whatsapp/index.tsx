import { Head } from '@inertiajs/react';
import { useCallback, useEffect, useMemo, useState } from 'react';
import { route } from 'ziggy-js';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';

type WhatsAppStatusResponse = {
    ok: boolean;
    connected: boolean;
};

type WhatsAppQrResponse = {
    ok: boolean;
    qr: string | null;
};

type ActionName = 'disconnect' | 'reconnect' | 'qr' | null;

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Configuracion', href: route('admin.whatsapp.index') },
    { title: 'WhatsApp', href: route('admin.whatsapp.index') },
];

export default function WhatsAppStatusIndex() {
    const [connected, setConnected] = useState<boolean>(false);
    const [qr, setQr] = useState<string | null>(null);
    const [runningAction, setRunningAction] = useState<ActionName>(null);
    const [actionError, setActionError] = useState<string | null>(null);

    const csrfToken = useMemo(() => {
        const tag = document.querySelector('meta[name="csrf-token"]');
        return tag?.getAttribute('content') ?? '';
    }, []);

    const xsrfToken = useMemo(() => {
        const cookie = document.cookie
            .split('; ')
            .find((item) => item.startsWith('XSRF-TOKEN='));

        if (!cookie) return '';

        const [, value] = cookie.split('=');
        return decodeURIComponent(value ?? '');
    }, []);

    const refreshStatus = useCallback(async () => {
        try {
            const response = await fetch(route('admin.whatsapp.status'), {
                headers: { Accept: 'application/json' },
            });

            if (!response.ok) {
                throw new Error('request_failed');
            }

            const data = (await response.json()) as WhatsAppStatusResponse;
            setConnected(Boolean(data.connected));
            setQr(null);
        } catch (_error) {
            setConnected(false);
            setQr(null);
        }
    }, []);

    useEffect(() => {
        refreshStatus();

        const intervalId = window.setInterval(() => {
            refreshStatus();
        }, 3000);

        return () => {
            window.clearInterval(intervalId);
        };
    }, [refreshStatus]);

    const runGatewayAction = useCallback(
        async (action: Exclude<ActionName, null>) => {
            setRunningAction(action);
            setActionError(null);

            try {
                const endpoint =
                    action === 'disconnect'
                        ? route('admin.whatsapp.disconnect')
                        : action === 'reconnect'
                          ? route('admin.whatsapp.reconnect')
                          : route('admin.whatsapp.qr');

                const response = await fetch(endpoint, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
                        ...(xsrfToken ? { 'X-XSRF-TOKEN': xsrfToken } : {}),
                    },
                });

                if (!response.ok) {
                    throw new Error('No se pudo completar la accion.');
                }

                if (action === 'qr') {
                    const payload = (await response.json()) as WhatsAppQrResponse;

                    if (!payload.ok) {
                        throw new Error('No se pudo obtener el QR.');
                    }

                    setQr(payload.qr);
                } else {
                    const payload = (await response.json()) as WhatsAppStatusResponse;

                    if (!payload.ok) {
                        throw new Error('No se pudo completar la accion.');
                    }

                    setConnected(Boolean(payload.connected));
                    setQr(null);
                }
            } catch (error) {
                const message = error instanceof Error ? error.message : 'Error ejecutando la accion.';
                setActionError(message);
            } finally {
                setRunningAction(null);
            }
        },
        [csrfToken, xsrfToken],
    );

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Estado de WhatsApp" />

            <div className="space-y-4 rounded-xl p-4">
                <div className="rounded-xl border bg-muted/30 p-4 text-sm">
                    <p className="font-medium">Instrucciones de uso</p>
                    <p className="mt-2 text-muted-foreground">
                        1. Revisa el estado actual de WhatsApp.
                    </p>
                    <p className="text-muted-foreground">
                        2. Si esta desconectado, pulsa "Mostrar QR" y escanealo desde tu WhatsApp.
                    </p>
                    <p className="text-muted-foreground">
                        3. Si esta conectado, puedes usar "Desconectar" o "Reconectar" segun necesites.
                    </p>
                </div>

                <div className="rounded-xl border border-amber-300 bg-amber-50 p-4 text-sm text-amber-800">
                    Advertencia: el gateway corre sobre un servicio gratuito y puede caerse o reiniciarse. Si pasa,
                    usa "Reconectar" o vuelve a generar el QR.
                </div>

                <div className="rounded-xl border bg-card p-6">
                    <div className="mb-6 flex flex-wrap items-center justify-between gap-4">
                        <div className="space-y-2">
                            <p className="text-sm text-muted-foreground">Estado actual</p>
                            <span
                                className={
                                    connected
                                        ? 'inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-sm font-medium text-emerald-700'
                                        : 'inline-flex items-center rounded-full bg-rose-100 px-3 py-1 text-sm font-medium text-rose-700'
                                }
                            >
                                {connected ? 'Conectado' : 'Desconectado'}
                            </span>
                        </div>

                        <div className="flex flex-wrap gap-2">
                            {connected ? (
                                <>
                                    <Button
                                        type="button"
                                        variant="destructive"
                                        onClick={() => runGatewayAction('disconnect')}
                                        disabled={runningAction !== null}
                                    >
                                        {runningAction === 'disconnect' ? 'Desconectando...' : 'Desconectar'}
                                    </Button>
                                    <Button
                                        type="button"
                                        onClick={() => runGatewayAction('reconnect')}
                                        disabled={runningAction !== null}
                                    >
                                        {runningAction === 'reconnect' ? 'Reconectando...' : 'Reconectar'}
                                    </Button>
                                </>
                            ) : (
                                <Button
                                    type="button"
                                    onClick={() => runGatewayAction('qr')}
                                    disabled={runningAction !== null}
                                >
                                    {runningAction === 'qr' ? 'Cargando...' : 'Mostrar QR'}
                                </Button>
                            )}
                        </div>
                    </div>

                    {actionError && (
                        <div className="mb-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                            {actionError}
                        </div>
                    )}

                    {!connected && qr && (
                        <div className="space-y-4">
                            <div className="mx-auto flex w-full max-w-md items-center justify-center rounded-xl border bg-white p-4">
                                <img src={qr} alt="QR WhatsApp" className="h-full w-full max-w-sm" />
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}
