import { CheckIcon } from 'lucide-react';
import { useEffect, useId, useMemo, useRef, useState } from 'react';
import { Input } from '@/components/ui/input';
import { Spinner } from '@/components/ui/spinner';
import { cn } from '@/lib/utils';

export type TypeaheadOption = {
    value: string;
    label: string;
    description?: string;
    raw?: unknown;
};

type EndpointResolver = string | ((query: string) => string);

type RemoteTypeaheadProps = {
    endpoint: EndpointResolver;
    onValueChange?: (value: string, option: TypeaheadOption | null) => void;
    mapResponse?: (response: unknown) => TypeaheadOption[];
    minChars?: number;
    debounceMs?: number;
    queryParam?: string;
    name?: string;
    disabled?: boolean;
    placeholder?: string;
    noResultsText?: string;
    minCharsText?: string;
    errorText?: string;
    defaultValue?: string;
    defaultLabel?: string;
    className?: string;
    inputClassName?: string;
    noResultsActionLabel?: (query: string) => string;
    onNoResultsActionClick?: (query: string) => Promise<TypeaheadOption | null> | TypeaheadOption | null;
    noResultsActionProcessingText?: string;
};

const defaultMapResponse = (response: unknown): TypeaheadOption[] => {
    const list = Array.isArray(response)
        ? response
        : isRecord(response) && Array.isArray(response.data)
          ? response.data
          : [];

    return list
        .map((item) => toDefaultOption(item))
        .filter((item): item is TypeaheadOption => item !== null);
};

const toDefaultOption = (item: unknown): TypeaheadOption | null => {
    if (!isRecord(item)) return null;

    const value = item.id ?? item.value;
    const label = item.name ?? item.label ?? item.title;
    const description = item.description ?? item.email ?? item.phone;

    if (value === undefined || label === undefined) return null;

    return {
        value: String(value),
        label: String(label),
        description:
            description === undefined ? undefined : String(description),
        raw: item,
    };
};

const isRecord = (value: unknown): value is Record<string, unknown> =>
    typeof value === 'object' && value !== null;

const buildUrl = (
    endpoint: EndpointResolver,
    query: string,
    queryParam: string,
): string => {
    if (typeof endpoint === 'function') {
        return endpoint(query);
    }

    const url = new URL(endpoint, window.location.origin);
    url.searchParams.set(queryParam, query);
    return url.toString();
};

export function RemoteTypeahead({
    endpoint,
    onValueChange,
    mapResponse = defaultMapResponse,
    minChars = 3,
    debounceMs = 350,
    queryParam = 'search',
    name,
    disabled = false,
    placeholder = 'Escriba para buscar...',
    noResultsText = 'Resultados no encontrados',
    minCharsText,
    errorText = 'Error cargando resultados',
    defaultValue,
    defaultLabel = '',
    className,
    inputClassName,
    noResultsActionLabel,
    onNoResultsActionClick,
    noResultsActionProcessingText = 'Cargando...',
}: RemoteTypeaheadProps) {
    const inputId = useId();
    const requestIdRef = useRef(0);
    const closeTimeoutRef = useRef<number | null>(null);
    const [query, setQuery] = useState(defaultLabel);
    const [debouncedQuery, setDebouncedQuery] = useState(defaultLabel);
    const [options, setOptions] = useState<TypeaheadOption[]>([]);
    const [selected, setSelected] = useState<TypeaheadOption | null>(
        defaultValue ? { value: defaultValue, label: defaultLabel } : null,
    );
    const [isFocused, setIsFocused] = useState(false);
    const [isLoading, setIsLoading] = useState(false);
    const [isNoResultsActionProcessing, setIsNoResultsActionProcessing] = useState(false);
    const [hasError, setHasError] = useState(false);

    const thresholdMessage = useMemo(
        () => minCharsText ?? `Escribe al menos ${minChars} caracteres`,
        [minChars, minCharsText],
    );

    useEffect(() => {
        const timer = window.setTimeout(() => {
            setDebouncedQuery(query.trim());
        }, debounceMs);

        return () => window.clearTimeout(timer);
    }, [query, debounceMs]);

    useEffect(() => {
        if (disabled) return;

        if (debouncedQuery.length < minChars) {
            setOptions([]);
            setHasError(false);
            setIsLoading(false);
            return;
        }

        const currentRequestId = ++requestIdRef.current;
        const controller = new AbortController();
        setIsLoading(true);
        setHasError(false);

        const fetchOptions = async () => {
            try {
                const response = await fetch(
                    buildUrl(endpoint, debouncedQuery, queryParam),
                    {
                        headers: { Accept: 'application/json' },
                        signal: controller.signal,
                    },
                );

                if (!response.ok) {
                    throw new Error(`Failed with status ${response.status}`);
                }

                const json = (await response.json()) as unknown;

                if (currentRequestId !== requestIdRef.current) {
                    return;
                }

                setOptions(mapResponse(json));
            } catch {
                if (controller.signal.aborted) return;

                if (currentRequestId === requestIdRef.current) {
                    setOptions([]);
                    setHasError(true);
                }
            } finally {
                if (currentRequestId === requestIdRef.current) {
                    setIsLoading(false);
                }
            }
        };

        void fetchOptions();

        return () => controller.abort();
    }, [
        endpoint,
        queryParam,
        debouncedQuery,
        minChars,
        mapResponse,
        disabled,
    ]);

    useEffect(() => {
        return () => {
            if (closeTimeoutRef.current !== null) {
                window.clearTimeout(closeTimeoutRef.current);
            }
        };
    }, []);

    const shouldShowList = isFocused && !disabled;

    const handleQueryChange = (value: string) => {
        setQuery(value);

        if (selected && value !== selected.label) {
            setSelected(null);
            onValueChange?.('', null);
        }
    };

    const handleSelect = (option: TypeaheadOption) => {
        setSelected(option);
        setQuery(option.label);
        setOptions([]);
        setIsFocused(false);
        onValueChange?.(option.value, option);
    };

    const handleFocus = () => {
        if (closeTimeoutRef.current !== null) {
            window.clearTimeout(closeTimeoutRef.current);
            closeTimeoutRef.current = null;
        }
        setIsFocused(true);
    };

    const handleBlur = () => {
        closeTimeoutRef.current = window.setTimeout(() => {
            setIsFocused(false);
        }, 120);
    };

    const canShowNoResultsAction =
        Boolean(onNoResultsActionClick) &&
        query.trim().length >= minChars &&
        !isLoading &&
        !hasError &&
        options.length === 0;

    const handleNoResultsActionClick = async () => {
        if (!onNoResultsActionClick || isNoResultsActionProcessing) return;

        setIsNoResultsActionProcessing(true);
        try {
            const option = await onNoResultsActionClick(query.trim());
            if (option) {
                handleSelect(option);
            }
        } finally {
            setIsNoResultsActionProcessing(false);
        }
    };

    return (
        <div className={cn('relative', className)}>
            <Input
                id={inputId}
                value={query}
                onChange={(event) => handleQueryChange(event.target.value)}
                onFocus={handleFocus}
                onBlur={handleBlur}
                disabled={disabled}
                placeholder={placeholder}
                className={inputClassName}
                autoComplete="off"
            />

            {name && (
                <input
                    type="hidden"
                    name={name}
                    value={selected?.value ?? ''}
                />
            )}

            {shouldShowList && (
                <div className="absolute z-50 mt-1 w-full overflow-hidden rounded-md border bg-popover text-popover-foreground shadow-md">
                    <div className="max-h-64 overflow-y-auto p-1">
                        {query.trim().length < minChars && (
                            <p className="px-2 py-1.5 text-sm text-muted-foreground">
                                {thresholdMessage}
                            </p>
                        )}

                        {query.trim().length >= minChars && isLoading && (
                            <div className="flex items-center gap-2 px-2 py-1.5 text-sm text-muted-foreground">
                                <Spinner className="size-4" />
                                <span>Buscando...</span>
                            </div>
                        )}

                        {query.trim().length >= minChars &&
                            !isLoading &&
                            hasError && (
                                <p className="px-2 py-1.5 text-sm text-destructive">
                                    {errorText}
                                </p>
                            )}

                        {query.trim().length >= minChars &&
                            !isLoading &&
                            !hasError &&
                            options.length === 0 && (
                                <div className="space-y-1">
                                    <p className="px-2 py-1.5 text-sm text-muted-foreground">
                                        {noResultsText}
                                    </p>
                                    {canShowNoResultsAction && (
                                        <button
                                            type="button"
                                            onMouseDown={(event) => {
                                                event.preventDefault();
                                                void handleNoResultsActionClick();
                                            }}
                                            disabled={isNoResultsActionProcessing}
                                            className="flex w-full items-center rounded-sm px-2 py-1.5 text-left text-sm text-primary hover:bg-accent hover:text-accent-foreground disabled:cursor-not-allowed disabled:opacity-60"
                                        >
                                            {isNoResultsActionProcessing
                                                ? noResultsActionProcessingText
                                                : noResultsActionLabel?.(query.trim()) ??
                                                  query.trim()}
                                        </button>
                                    )}
                                </div>
                            )}

                        {query.trim().length >= minChars &&
                            !isLoading &&
                            !hasError &&
                            options.map((option) => (
                                <button
                                    key={option.value}
                                    type="button"
                                    onMouseDown={(event) => {
                                        event.preventDefault();
                                        handleSelect(option);
                                    }}
                                    className="flex w-full items-center justify-between rounded-sm px-2 py-1.5 text-left text-sm hover:bg-accent hover:text-accent-foreground"
                                >
                                    <span className="truncate">
                                        {option.label}
                                        {option.description && (
                                            <span className="ml-2 text-xs text-muted-foreground">
                                                {option.description}
                                            </span>
                                        )}
                                    </span>
                                    {selected?.value === option.value && (
                                        <CheckIcon className="size-4 shrink-0" />
                                    )}
                                </button>
                            ))}
                    </div>
                </div>
            )}
        </div>
    );
}
