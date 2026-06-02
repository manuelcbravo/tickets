<?php

namespace Tests\Feature\ProjectBilling;

use App\Models\Client;
use App\Models\Proyecto;
use App\Models\ProyectoCargo;
use App\Models\ProyectoPago;
use App\Models\ProyectoPlanCobro;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProjectBillingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_permission_can_view_billing_dashboard(): void
    {
        $user = $this->userWithPermissions(['project-billing.view']);

        $this->actingAs($user)
            ->get(route('project-billing.dashboard'))
            ->assertOk();
    }

    public function test_monthly_profile_requires_monthly_fields(): void
    {
        $user = $this->userWithPermissions(['project-billing.manage']);
        $project = $this->project();

        $this->actingAs($user)
            ->post(route('proyectos.billing.profile.store', $project), [
                'tipo_cobro' => 'mensual',
                'moneda' => 'MXN',
            ])
            ->assertSessionHasErrors(['monto_mensual', 'dia_vencimiento', 'fecha_inicio', 'fecha_fin']);
    }

    public function test_global_billing_profile_can_configure_single_payment_and_initial_charge(): void
    {
        $user = $this->userWithPermissions(['project-billing.manage']);
        $project = $this->project();

        $this->actingAs($user)
            ->post(route('project-billing.profiles.store'), [
                'cliente_id' => $project->client_id,
                'proyecto_id' => $project->id,
                'tipo_cobro' => 'unico',
                'moneda' => 'MXN',
                'monto_total' => 2500,
                'fecha_inicio' => '2026-06-01',
                'fecha_emision' => '2026-06-01',
                'fecha_vencimiento' => '2026-06-15',
            ])
            ->assertRedirect(route('proyectos.show', $project))
            ->assertSessionHas('success', 'Plan de cobro configurado y cargo generado correctamente.');

        $this->assertDatabaseHas('proyecto_planes_cobro', [
            'proyecto_id' => $project->id,
            'tipo_cobro' => 'unico',
            'monto_total' => 2500,
            'activo' => true,
        ]);
        $this->assertDatabaseHas('proyecto_cargos', [
            'proyecto_id' => $project->id,
            'concepto' => 'Pago unico del proyecto '.$project->nombre,
            'monto' => 2500,
            'saldo' => 2500,
        ]);
    }

    public function test_global_monthly_profile_generates_all_contract_charges(): void
    {
        $user = $this->userWithPermissions(['project-billing.manage']);
        $project = $this->project();

        $this->actingAs($user)
            ->post(route('project-billing.profiles.store'), [
                'cliente_id' => $project->client_id,
                'proyecto_id' => $project->id,
                'tipo_cobro' => 'mensual',
                'moneda' => 'MXN',
                'monto_mensual' => 3500,
                'dia_vencimiento' => 5,
                'fecha_inicio' => '2026-01-01',
                'fecha_fin' => '2026-06-30',
            ])
            ->assertRedirect(route('proyectos.show', $project))
            ->assertSessionHas('success', 'Plan mensual configurado y cargos generados correctamente.');

        $this->assertSame(6, ProyectoCargo::query()->where('proyecto_id', $project->id)->count());
        $februaryCharge = ProyectoCargo::query()
            ->where('proyecto_id', $project->id)
            ->where('concepto', 'Mensualidad febrero 2026 - '.$project->nombre)
            ->firstOrFail();

        $this->assertSame('2026-02-01', $februaryCharge->periodo_inicio->toDateString());
        $this->assertSame('2026-02-28', $februaryCharge->periodo_fin->toDateString());
        $this->assertSame('2026-02-05', $februaryCharge->fecha_vencimiento->toDateString());
        $this->assertSame('3500.00', $februaryCharge->monto);
        $this->assertSame('3500.00', $februaryCharge->saldo);

        $project->refresh();

        $this->assertSame('21000.00', $project->saldo_pendiente);
    }

    public function test_monthly_profile_uses_real_month_end_for_due_day_31(): void
    {
        $user = $this->userWithPermissions(['project-billing.manage']);
        $project = $this->project();

        $this->actingAs($user)
            ->post(route('project-billing.profiles.store'), [
                'cliente_id' => $project->client_id,
                'proyecto_id' => $project->id,
                'tipo_cobro' => 'mensual',
                'moneda' => 'MXN',
                'monto_mensual' => 3500,
                'dia_vencimiento' => 31,
                'fecha_inicio' => '2026-02-10',
                'fecha_fin' => '2026-03-20',
            ])
            ->assertRedirect(route('proyectos.show', $project));

        $februaryCharge = ProyectoCargo::query()
            ->where('proyecto_id', $project->id)
            ->where('concepto', 'Mensualidad febrero 2026 - '.$project->nombre)
            ->firstOrFail();
        $marchCharge = ProyectoCargo::query()
            ->where('proyecto_id', $project->id)
            ->where('concepto', 'Mensualidad marzo 2026 - '.$project->nombre)
            ->firstOrFail();

        $this->assertSame('2026-02-10', $februaryCharge->periodo_inicio->toDateString());
        $this->assertSame('2026-02-28', $februaryCharge->periodo_fin->toDateString());
        $this->assertSame('2026-02-28', $februaryCharge->fecha_vencimiento->toDateString());
        $this->assertSame('2026-03-01', $marchCharge->periodo_inicio->toDateString());
        $this->assertSame('2026-03-20', $marchCharge->periodo_fin->toDateString());
        $this->assertSame('2026-03-31', $marchCharge->fecha_vencimiento->toDateString());
    }

    public function test_active_billing_profile_requires_explicit_replacement(): void
    {
        $user = $this->userWithPermissions(['project-billing.manage']);
        $project = $this->project();

        ProyectoPlanCobro::query()->create([
            'proyecto_id' => $project->id,
            'cliente_id' => $project->client_id,
            'tipo_cobro' => 'mensual',
            'moneda' => 'MXN',
            'monto_mensual' => 1200,
            'dia_vencimiento' => 10,
            'fecha_inicio' => '2026-06-01',
            'periodicidad' => 'mensual',
            'activo' => true,
            'estado' => 'activo',
        ]);

        $this->actingAs($user)
            ->post(route('project-billing.profiles.store'), [
                'cliente_id' => $project->client_id,
                'proyecto_id' => $project->id,
                'tipo_cobro' => 'unico',
                'moneda' => 'MXN',
                'monto_total' => 2500,
            ])
            ->assertSessionHasErrors(['reemplazar_plan_activo']);
    }

    public function test_charge_can_be_created_with_generated_folio_and_balance(): void
    {
        $user = $this->userWithPermissions(['project-billing.charges.manage']);
        $project = $this->project();

        $this->actingAs($user)
            ->post(route('proyectos.billing.charges.store', $project), [
                'cliente_id' => $project->client_id,
                'concepto' => 'Cargo inicial',
                'fecha_emision' => '2026-05-01',
                'fecha_vencimiento' => '2026-05-15',
                'moneda' => 'MXN',
                'monto' => 1500,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('proyecto_cargos', [
            'proyecto_id' => $project->id,
            'folio' => 'CARGO-000001',
            'saldo' => 1500,
            'estado' => 'vencido',
        ]);
    }

    public function test_payment_can_be_registered_with_generated_folio(): void
    {
        $user = $this->userWithPermissions(['project-billing.payments.manage']);
        $project = $this->project();

        $this->actingAs($user)
            ->post(route('project-billing.payments.store'), [
                'cliente_id' => $project->client_id,
                'proyecto_id' => $project->id,
                'fecha_pago' => '2026-05-20',
                'moneda' => 'MXN',
                'monto' => 1000,
                'metodo_pago' => 'transferencia',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('proyecto_pagos', [
            'proyecto_id' => $project->id,
            'folio' => 'PAGO-000001',
            'monto' => 1000,
            'estado' => 'registrado',
        ]);
    }

    public function test_payment_application_recalculates_charge_balance(): void
    {
        $user = $this->userWithPermissions(['project-billing.payments.manage']);
        $project = $this->project();
        $charge = $this->charge($project, 800);
        $payment = $this->payment($project, 500);

        $this->actingAs($user)
            ->post(route('project-billing.payments.allocations.store', $payment), [
                'pago_id' => $payment->id,
                'cargo_id' => $charge->id,
                'monto_aplicado' => 500,
            ])
            ->assertRedirect();

        $charge->refresh();

        $this->assertSame('500.00', $charge->monto_pagado);
        $this->assertSame('300.00', $charge->saldo);
        $this->assertSame('pagado_parcial', $charge->estado);
    }

    public function test_monthly_command_generates_charges_without_duplicates(): void
    {
        $project = $this->project();

        ProyectoPlanCobro::query()->create([
            'proyecto_id' => $project->id,
            'cliente_id' => $project->client_id,
            'tipo_cobro' => 'mensual',
            'moneda' => 'MXN',
            'monto_mensual' => 1200,
            'dia_vencimiento' => 10,
            'fecha_inicio' => '2026-05-01',
            'fecha_fin' => '2026-12-31',
            'periodicidad' => 'mensual',
            'activo' => true,
            'estado' => 'activo',
        ]);

        $this->artisan('project-billing:generate-monthly-charges', ['--month' => '2026-06'])->assertExitCode(0);
        $this->artisan('project-billing:generate-monthly-charges', ['--month' => '2026-06'])->assertExitCode(0);

        $this->assertSame(1, ProyectoCargo::query()->where('proyecto_id', $project->id)->count());
        $this->assertDatabaseHas('proyecto_cargos', [
            'proyecto_id' => $project->id,
            'concepto' => 'Mensualidad junio 2026 - '.$project->nombre,
            'monto' => 1200,
        ]);
    }

    public function test_due_soon_command_notifies_super_admins_without_duplicates(): void
    {
        Mail::fake();
        config(['integrations.email.enabled' => true]);

        $adminRole = Role::query()->firstOrCreate(['name' => 'super admin', 'guard_name' => 'web']);
        $admin = User::factory()->create();
        $admin->assignRole($adminRole);
        $project = $this->project();

        ProyectoCargo::query()->create([
            'folio' => 'CARGO-DUE-001',
            'cliente_id' => $project->client_id,
            'proyecto_id' => $project->id,
            'concepto' => 'Cargo por vencer',
            'fecha_emision' => now()->toDateString(),
            'fecha_vencimiento' => now()->addDays(2)->toDateString(),
            'moneda' => 'MXN',
            'monto' => 1500,
            'monto_pagado' => 0,
            'saldo' => 1500,
            'estado' => 'pendiente',
        ]);

        $this->artisan('notifications:check-project-payments-due')->assertExitCode(0);
        $this->artisan('notifications:check-project-payments-due')->assertExitCode(0);

        Mail::assertSent(\App\Mail\ProjectBilling\ProjectChargesDueSoonMail::class, 1);
        $this->assertSame(1, $admin->notifications()->count());
        $this->assertDatabaseCount('notification_logs', 1);
    }

    private function userWithPermissions(array $permissions): User
    {
        foreach ($permissions as $permission) {
            Permission::query()->firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $user = User::factory()->create();
        $user->givePermissionTo($permissions);

        return $user;
    }

    private function client(): Client
    {
        return Client::query()->create([
            'nombre' => 'Cliente Cobranza',
            'email' => 'cobranza@example.test',
            'is_active' => true,
            'estatus' => 'activo',
        ]);
    }

    private function project(): Proyecto
    {
        return Proyecto::query()->create([
            'client_id' => $this->client()->id,
            'nombre' => 'Proyecto Cobranza',
            'estado' => 'mantenimiento',
            'criticidad' => 'media',
        ]);
    }

    private function charge(Proyecto $project, float $amount): ProyectoCargo
    {
        return ProyectoCargo::query()->create([
            'folio' => 'CARGO-TEST-001',
            'cliente_id' => $project->client_id,
            'proyecto_id' => $project->id,
            'concepto' => 'Cargo de prueba',
            'fecha_emision' => '2026-05-01',
            'fecha_vencimiento' => '2026-05-15',
            'moneda' => 'MXN',
            'monto' => $amount,
            'monto_pagado' => 0,
            'saldo' => $amount,
            'estado' => 'pendiente',
        ]);
    }

    private function payment(Proyecto $project, float $amount): ProyectoPago
    {
        return ProyectoPago::query()->create([
            'folio' => 'PAGO-TEST-001',
            'cliente_id' => $project->client_id,
            'proyecto_id' => $project->id,
            'fecha_pago' => '2026-05-20',
            'moneda' => 'MXN',
            'monto' => $amount,
            'estado' => 'registrado',
        ]);
    }
}
