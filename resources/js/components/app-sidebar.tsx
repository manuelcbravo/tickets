import { Link, usePage } from '@inertiajs/react';
import {
    BookOpen,
    BriefcaseBusiness,
    CircleDollarSign,
    ClipboardList,
    FolderKanban,
    Inbox,
    LayoutGrid,
    Mail,
    Plug,
    Rocket,
    Settings,
    ShieldCheck,
    Ticket,
} from 'lucide-react';
import { route } from 'ziggy-js';
import { NavConfig } from '@/components/nav-config';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import type { NavItem, SharedData } from '@/types';
import { dashboard } from '@/routes';
import AppLogo from './app-logo';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
        children: [
            {
                title: 'Inicio',
                href: dashboard(),
                activePatterns: ['^/dashboard$'],
            },
        ],
    },
    {
        title: 'Clientes',
        href: route('clientes.index'),
        icon: BriefcaseBusiness,
        permissions: ['clientes.view', 'clientes.manage'],
        activePatterns: ['^/clientes'],
    },
    {
        title: 'Proyectos',
        href: route('proyectos.index'),
        icon: FolderKanban,
        permissions: ['proyectos.view', 'proyectos.manage'],
        activePatterns: ['^/proyectos'],
    },
    {
        title: 'Actividades',
        href: route('activities.dashboard'),
        icon: ClipboardList,
        permissions: [
            'project-planning.activities.view',
            'project-planning.activities.manage',
        ],
        children: [
            {
                title: 'Dashboard',
                href: route('activities.dashboard'),
                permissions: [
                    'project-planning.activities.view',
                    'project-planning.activities.manage',
                ],
                activePatterns: ['^/actividades/dashboard$'],
            },
            {
                title: 'Actividades',
                href: route('activities.index'),
                permissions: [
                    'project-planning.activities.view',
                    'project-planning.activities.manage',
                ],
                activePatterns: ['^/actividades$'],
            },
            {
                title: 'Terminadas',
                href: route('activities.completed'),
                permissions: [
                    'project-planning.activities.view',
                    'project-planning.activities.manage',
                ],
                activePatterns: [
                    '^/actividades/terminadas$',
                    '^/actividades/finalizadas$',
                ],
            },
        ],
        activePatterns: ['^/actividades'],
    },
    {
        title: 'Tickets',
        href: route('tickets.index'),
        icon: Ticket,
        permissions: [
            'tickets.view',
            'tickets.manage',
            'tickets.triage',
            'tickets.sla.view',
            'tickets.sla.manage',
            'tickets.reports',
            'tickets.qa.view',
            'tickets.qa.manage',
        ],
        children: [
            {
                title: 'Dashboard tickets',
                href: route('tickets.dashboard'),
                permissions: [
                    'tickets.dashboard',
                    'tickets.reports',
                    'tickets.view',
                ],
                activePatterns: ['^/tickets/dashboard$'],
            },
            {
                title: 'Tickets',
                href: route('tickets.index'),
                permissions: ['tickets.view', 'tickets.manage'],
                activePatterns: [
                    '^/tickets$',
                    '^/tickets/create$',
                    '^/tickets/[^/]+$',
                    '^/tickets/[^/]+/edit$',
                    '^/tickets/[^/]+/ai',
                ],
            },
            {
                title: 'Triage',
                href: route('tickets.triage.index'),
                permissions: ['tickets.triage', 'tickets.manage'],
                activePatterns: ['^/tickets/triage', '^/tickets/[^/]+/triage'],
            },
            {
                title: 'SLA',
                href: route('tickets.sla.index'),
                permissions: [
                    'tickets.sla.view',
                    'tickets.sla.manage',
                    'tickets.reports',
                ],
                activePatterns: ['^/tickets/sla$'],
            },
            {
                title: 'QA',
                href: route('tickets.qa.index'),
                icon: ShieldCheck,
                permissions: ['tickets.qa.view', 'tickets.qa.manage'],
                activePatterns: ['^/tickets/qa'],
            },
        ],
    },
    {
        title: 'Comercial',
        href: route('quotes.index'),
        icon: CircleDollarSign,
        permissions: [
            'quotes.view',
            'quotes.manage',
            'project-billing.view',
            'project-billing.reports',
            'project-billing.charges.view',
            'project-billing.payments.view',
        ],
        children: [
            {
                title: 'Cotizaciones',
                href: route('quotes.index'),
                permissions: ['quotes.view', 'quotes.manage'],
                activePatterns: ['^/quotes'],
            },
            {
                title: 'Cobranza',
                href: route('project-billing.dashboard'),
                permissions: [
                    'project-billing.view',
                    'project-billing.reports',
                ],
                activePatterns: ['^/project-billing$'],
            },
            {
                title: 'Pagos',
                href: route('project-billing.payments.index'),
                permissions: ['project-billing.payments.view'],
                activePatterns: ['^/project-billing/payments'],
            },
            {
                title: 'Cargos',
                href: route('project-billing.charges.index'),
                permissions: ['project-billing.charges.view'],
                activePatterns: ['^/project-billing/charges'],
            },
        ],
    },
    {
        title: 'Conocimiento',
        href: route('knowledge.index'),
        icon: BookOpen,
        permissions: ['knowledge.view', 'knowledge.manage'],
        children: [
            {
                title: 'Base de conocimiento',
                href: route('knowledge.index'),
                permissions: ['knowledge.view', 'knowledge.manage'],
                activePatterns: [
                    '^/knowledge$',
                    '^/knowledge/create$',
                    '^/knowledge/(?!categories)[^/]+',
                ],
            },
            {
                title: 'Categorias',
                href: route('knowledge.categories.index'),
                permissions: ['knowledge.manage'],
                activePatterns: ['^/knowledge/categories'],
            },
        ],
    },
    {
        title: 'Desarrollo',
        href: route('development.releases.index'),
        icon: Rocket,
        permissions: [
            'development.view',
            'development.manage',
            'development.releases.view',
            'development.releases.manage',
        ],
        children: [
            {
                title: 'Releases',
                href: route('development.releases.index'),
                permissions: [
                    'development.releases.view',
                    'development.releases.manage',
                ],
                activePatterns: ['^/development/releases'],
            },
            {
                title: 'Repositorios',
                href: route('development.repositories.index'),
                permissions: ['development.view', 'development.manage'],
                activePatterns: ['^/development/repositories'],
            },
        ],
    },
    {
        title: 'Integraciones',
        href: route('integrations.index'),
        icon: Plug,
        permissions: [
            'integrations.view',
            'integrations.manage',
            'integrations.webhooks.view',
            'notifications.view',
        ],
        children: [
            {
                title: 'Integraciones',
                href: route('integrations.index'),
                permissions: ['integrations.view', 'integrations.manage'],
                activePatterns: [
                    '^/integrations$',
                    '^/integrations/create$',
                    '^/integrations/[^/]+$',
                    '^/integrations/[^/]+/edit$',
                ],
            },
            {
                title: 'Webhooks',
                href: route('integrations.webhooks.index'),
                permissions: [
                    'integrations.webhooks.view',
                    'integrations.webhooks.manage',
                ],
                activePatterns: ['^/integrations/webhooks'],
            },
            {
                title: 'Mensajes externos',
                href: route('integrations.messages.index'),
                icon: Inbox,
                permissions: ['integrations.view', 'integrations.manage'],
                activePatterns: ['^/integrations/messages'],
            },
            {
                title: 'Notificaciones',
                href: route('notifications.logs.index'),
                icon: Mail,
                permissions: ['notifications.view', 'notifications.manage'],
                activePatterns: ['^/notifications/logs'],
            },
        ],
    },
    {
        title: 'Configuracion',
        href: route('tickets.catalogs'),
        icon: Settings,
        permissions: [
            'tickets.catalogs',
            'tickets.manage',
            'tickets.sla.manage',
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',
            'audits.view',
        ],
        children: [
            {
                title: 'Catalogos',
                href: route('tickets.catalogs'),
                permissions: ['tickets.catalogs', 'tickets.manage'],
                activePatterns: ['^/tickets/catalogos'],
            },
            {
                title: 'Configuracion SLA',
                href: route('tickets.sla.settings'),
                permissions: ['tickets.sla.manage'],
                activePatterns: ['^/tickets/sla/configuracion'],
            },
            {
                title: 'Usuarios',
                href: route('config.users.index'),
                permissions: [
                    'users.view',
                    'users.create',
                    'users.update',
                    'users.delete',
                ],
                activePatterns: ['^/config/users'],
            },
            {
                title: 'Roles y permisos',
                href: route('config.roles.index'),
                permissions: [
                    'roles.view',
                    'roles.create',
                    'roles.update',
                    'roles.delete',
                ],
                activePatterns: ['^/config/roles'],
            },
            {
                title: 'Auditoria',
                href: route('config.audits.index'),
                permissions: ['audits.view'],
                activePatterns: ['^/config/audits'],
            },
        ],
    },
];

const configNavItems: NavItem[] = [];

function filterNavItems(items: NavItem[], permissions: string[]): NavItem[] {
    return items.reduce<NavItem[]>((visibleItems, item) => {
        const children = item.children
            ? filterNavItems(item.children, permissions)
            : undefined;
        const canViewItem =
            !item.permissions?.length ||
            item.permissions.some((permission) =>
                permissions.includes(permission),
            );

        if (!canViewItem && !children?.length) {
            return visibleItems;
        }

        visibleItems.push({ ...item, children });

        return visibleItems;
    }, []);
}

export function AppSidebar() {
    const permissions = usePage<SharedData>().props.auth.permissions ?? [];
    const visibleMainNavItems = filterNavItems(mainNavItems, permissions);
    const visibleConfigNavItems = filterNavItems(configNavItems, permissions);

    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={dashboard()} prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={visibleMainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                {visibleConfigNavItems.length > 0 && (
                    <NavConfig items={visibleConfigNavItems} />
                )}
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
