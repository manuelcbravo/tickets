<?php

namespace Tests\Feature\Tickets;

use App\Models\CatTicketEstado;
use App\Models\CatTicketImpacto;
use App\Models\CatTicketPrioridad;
use App\Models\CatTicketRiesgo;
use App\Models\CatTicketTipo;
use App\Models\CatTicketUrgencia;
use App\Models\Client;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class TicketTriageTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_triage_permission_can_view_triage_index(): void
    {
        $user = $this->userWithPermission('tickets.triage');

        $this->actingAs($user)
            ->get(route('tickets.triage.index'))
            ->assertOk();
    }

    public function test_user_without_triage_permission_cannot_access_triage(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('tickets.triage.index'))
            ->assertForbidden();
    }

    public function test_new_ticket_can_start_triage(): void
    {
        $user = $this->userWithPermission('tickets.triage');
        $ticket = $this->ticket();
        $this->state('En triage');

        $this->actingAs($user)
            ->patch(route('tickets.triage.start', $ticket))
            ->assertRedirect(route('tickets.triage.show', $ticket));

        $this->assertDatabaseHas('ticket_activity_logs', [
            'ticket_id' => $ticket->id,
            'accion' => 'triage_started',
        ]);
    }

    public function test_cannot_complete_triage_without_required_classification(): void
    {
        $user = $this->userWithPermission('tickets.triage');
        $ticket = $this->ticket();

        $this->actingAs($user)
            ->patch(route('tickets.triage.complete', $ticket), [])
            ->assertSessionHasErrors(['tipo_id', 'impacto_id', 'urgencia_id', 'riesgo_id', 'prioridad_id']);
    }

    public function test_critical_incident_cannot_be_p3_or_p4(): void
    {
        $user = $this->userWithPermission('tickets.triage');
        $ticket = $this->ticket();
        $catalogs = $this->catalogs();

        $this->actingAs($user)
            ->patch(route('tickets.triage.complete', $ticket), [
                'tipo_id' => $catalogs['critical']->id,
                'impacto_id' => $catalogs['impact']->id,
                'urgencia_id' => $catalogs['urgency']->id,
                'riesgo_id' => $catalogs['risk']->id,
                'prioridad_id' => $catalogs['p3']->id,
                'next_status' => 'priorizado',
            ])
            ->assertSessionHasErrors(['prioridad_id']);
    }

    public function test_new_development_marks_code_change_and_commercial_marks_quote(): void
    {
        $user = $this->userWithPermission('tickets.triage');
        $ticket = $this->ticket();
        $catalogs = $this->catalogs();

        $this->actingAs($user)
            ->patch(route('tickets.triage.complete', $ticket), [
                'tipo_id' => $catalogs['development']->id,
                'impacto_id' => $catalogs['impact']->id,
                'urgencia_id' => $catalogs['urgency']->id,
                'riesgo_id' => $catalogs['risk']->id,
                'prioridad_id' => $catalogs['p2']->id,
                'next_status' => 'priorizado',
            ])
            ->assertRedirect(route('tickets.show', $ticket));

        $ticket->refresh();
        $this->assertTrue($ticket->requires_code_change);
        $this->assertTrue($ticket->requires_quote);
        $this->assertDatabaseHas('ticket_activity_logs', [
            'ticket_id' => $ticket->id,
            'accion' => 'triage_completed',
        ]);
    }

    public function test_cannot_relate_ticket_to_itself_or_duplicate_relation(): void
    {
        $user = $this->userWithPermission('tickets.manage');
        $ticket = $this->ticket();
        $related = $this->ticket(['folio' => 'TCK-888888']);

        $this->actingAs($user)
            ->post(route('tickets.relations.store', $ticket), [
                'related_ticket_id' => $ticket->id,
                'tipo' => 'relacionado_con',
            ])
            ->assertSessionHasErrors(['related_ticket_id']);

        $this->actingAs($user)
            ->post(route('tickets.relations.store', $ticket), [
                'related_ticket_id' => $related->id,
                'tipo' => 'relacionado_con',
            ])
            ->assertRedirect();

        $this->actingAs($user)
            ->post(route('tickets.relations.store', $ticket), [
                'related_ticket_id' => $related->id,
                'tipo' => 'relacionado_con',
            ])
            ->assertSessionHasErrors(['related_ticket_id']);
    }

    private function userWithPermission(string $permission): User
    {
        Permission::query()->firstOrCreate(['name' => $permission, 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->givePermissionTo($permission);

        return $user;
    }

    private function ticket(array $overrides = []): Ticket
    {
        $client = Client::query()->create([
            'nombre' => 'Cliente Demo',
            'email' => fake()->safeEmail(),
            'is_active' => true,
            'estatus' => 'activo',
        ]);

        $catalogs = $this->catalogs();

        return Ticket::query()->create([
            'folio' => $overrides['folio'] ?? 'TCK-999999',
            'cliente_id' => $client->id,
            'titulo' => 'Ticket base',
            'descripcion' => 'Descripcion del ticket base.',
            'tipo_id' => $catalogs['support']->id,
            'estado_id' => $catalogs['new']->id,
            'prioridad_id' => $catalogs['p2']->id,
            ...$overrides,
        ]);
    }

    private function catalogs(): array
    {
        return [
            'support' => CatTicketTipo::query()->firstOrCreate(['nombre' => 'Soporte'], ['orden' => 1, 'activo' => true]),
            'critical' => CatTicketTipo::query()->firstOrCreate(['nombre' => 'Incidente critico'], ['orden' => 2, 'activo' => true]),
            'development' => CatTicketTipo::query()->firstOrCreate(['nombre' => 'Nuevo desarrollo'], ['orden' => 3, 'activo' => true]),
            'new' => $this->state('Nuevo'),
            'impact' => CatTicketImpacto::query()->firstOrCreate(['nombre' => 'Medio'], ['orden' => 1, 'activo' => true]),
            'urgency' => CatTicketUrgencia::query()->firstOrCreate(['nombre' => 'Media'], ['orden' => 1, 'activo' => true]),
            'risk' => CatTicketRiesgo::query()->firstOrCreate(['nombre' => 'Medio'], ['orden' => 1, 'activo' => true]),
            'p2' => CatTicketPrioridad::query()->firstOrCreate(['nombre' => 'P2 - Media'], ['orden' => 1, 'activo' => true]),
            'p3' => CatTicketPrioridad::query()->firstOrCreate(['nombre' => 'P3 - Baja'], ['orden' => 2, 'activo' => true]),
        ];
    }

    private function state(string $name): CatTicketEstado
    {
        return CatTicketEstado::query()->firstOrCreate(['nombre' => $name], ['orden' => 1, 'activo' => true]);
    }
}
