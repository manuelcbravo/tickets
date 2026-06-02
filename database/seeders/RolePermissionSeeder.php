<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            'audits.view',
            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',
            'clientes.view',
            'clientes.create',
            'clientes.manage',
            'clientes.delete',
            'proyectos.view',
            'proyectos.create',
            'proyectos.manage',
            'proyectos.delete',
            'knowledge.view',
            'knowledge.create',
            'knowledge.manage',
            'knowledge.delete',
            'knowledge.publish',
            'knowledge.link',
            'development.view',
            'development.manage',
            'development.releases.view',
            'development.releases.manage',
            'quotes.view',
            'quotes.create',
            'quotes.manage',
            'quotes.delete',
            'quotes.approve.internal',
            'quotes.approve.client',
            'quotes.convert',
            'integrations.view',
            'integrations.manage',
            'integrations.webhooks.view',
            'integrations.webhooks.manage',
            'notifications.view',
            'notifications.manage',
            'notifications.read',
            'notifications.delete',
            'project-billing.view',
            'project-billing.manage',
            'project-billing.charges.view',
            'project-billing.charges.manage',
            'project-billing.payments.view',
            'project-billing.payments.manage',
            'project-billing.payments.confirm',
            'project-billing.documents.manage',
            'project-billing.reports',
            'project-planning.view',
            'project-planning.manage',
            'project-planning.documents.view',
            'project-planning.documents.manage',
            'project-planning.activities.view',
            'project-planning.activities.manage',
            'project-planning.activities.time',
            'project-planning.kanban.view',
            'project-planning.kanban.manage',
            'tickets.view',
            'tickets.create',
            'tickets.manage',
            'tickets.quote',
            'tickets.notifications.view',
            'tickets.notifications.manage',
            'tickets.development.view',
            'tickets.development.manage',
            'tickets.qa.view',
            'tickets.qa.manage',
            'tickets.qa.approve',
            'tickets.qa.reject',
            'tickets.qa.evidence',
            'tickets.assign',
            'tickets.close',
            'tickets.reopen',
            'tickets.triage',
            'tickets.prioritize',
            'tickets.time.view',
            'tickets.time.manage',
            'tickets.sla.view',
            'tickets.sla.manage',
            'tickets.dashboard',
            'tickets.ai',
            'tickets.ai.analyze',
            'tickets.ai.apply',
            'tickets.ai.approve',
            'tickets.ai.view',
            'tickets.reports',
            'tickets.catalogs',
        ];

        foreach ($permissions as $permissionName) {
            Permission::query()->firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);
        }

        $developerRole = Role::query()->firstOrCreate([
            'name' => 'desarrollador',
            'guard_name' => 'web',
        ]);

        $developerRole->syncPermissions(
            Permission::query()->pluck('name')->all()
        );

        foreach (['administrador', 'super admin'] as $roleName) {
            $role = Role::query()->firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            $role->givePermissionTo($permissions);
        }

        $user = User::query()
            ->where('email', 'admin@fielgroup.com.mx')
            ->first();

        if ($user) {
            $user->assignRole($developerRole);
        }
    }
}
