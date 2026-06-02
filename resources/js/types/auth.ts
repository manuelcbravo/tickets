export type User = {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    two_factor_enabled?: boolean;
    created_at: string;
    updated_at: string;
    unread_notifications_count?: number;
    recent_notifications?: UserNotificationSummary[];
    [key: string]: unknown;
};

export type Auth = {
    user: User;
    permissions?: string[];
};

export type UserNotificationSummary = {
    id: string;
    title: string;
    message: string;
    level: string;
    module: string;
    action_url?: string | null;
    read_at?: string | null;
    created_at?: string | null;
};

export type TwoFactorSetupData = {
    svg: string;
    url: string;
};

export type TwoFactorSecretKey = {
    secretKey: string;
};
