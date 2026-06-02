import type { ReactNode } from 'react';

type ModuleHeaderProps = {
    title: string;
    description: string;
    children?: ReactNode;
};

export function ModuleHeader({ title, description, children }: ModuleHeaderProps) {
    return (
        <div className="rounded-xl border border-sidebar-border/70 bg-sidebar-accent/20 p-4">
            <div className="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div className="space-y-1">
                    <h1 className="text-xl font-semibold">{title}</h1>
                    <p className="max-w-5xl text-sm leading-6 text-muted-foreground">{description}</p>
                </div>
                {children && <div className="flex flex-wrap gap-2">{children}</div>}
            </div>
        </div>
    );
}
