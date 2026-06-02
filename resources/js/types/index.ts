export type * from './auth';
export type * from './knowledge';
export type * from './navigation';
export type * from './tickets';
export type * from './ui';

import type { Auth } from './auth';

export type SharedData = {
    name: string;
    auth: Auth;
    sidebarOpen: boolean;
    flash?: {
        success?: string | null;
        error?: string | null;
    };
    [key: string]: unknown;
};
