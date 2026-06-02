<?php

namespace Tests\Feature\Tickets;

use App\Models\CatTicketEstado;
use App\Models\CatTicketPrioridad;
use App\Models\CatTicketTipo;
use App\Models\Client;
use App\Models\SlaPolitica;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class TicketTimeSlaTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_permission_can_log_time_and_recalculate_ticket_total(): void
    {
        $user = $this->userWithPermission('tickets.time.manage');
        $ticket = $this->ticket();

        $this->actingAs($user)
            ->post(route('tickets.times.store', $ticket), [
                'descripcion' => 'Revision inicial del error.',
                'minutos' => 45,
                'fecha' => now()->toDateString(),
                'es_facturable' => true,
            ])
            ->assertRedirect();

        $this->assertSame(45, $ticket->refresh()->tiempo_real_min);
        $this->assertDatabaseHas('ticket_activity_logs', [
            'ticket_id' => $ticket->id,
            'accion' => 'time_logged',
        ]);
    }

    public function test_time_requires_positive_minutes(): void
    {
        $user = $this->userWithPermission('tickets.time.manage');
        $ticket = $this->ticket();

        $this->actingAs($user)
            ->post(route('tickets.times.store', $ticket), [
                'descripcion' => 'Ajuste invalido.',
                'minutos' => 0,
                'fecha' => now()->toDateString(),
            ])
            ->assertSessionHasErrors(['minutos']);
    }

    public function test_user_without_permission_cannot_log_time(): void
    {
        $ticket = $this->ticket();

        $this->actingAs(User::factory()->create())
            ->post(route('tickets.times.store', $ticket), [
                'descripcion' => 'Revision inicial.',
                'minutos' => 30,
                'fecha' => now()->toDateString(),
            ])
            ->assertForbidden();
    }

    public function test_ticket_creation_creates_sla_when_default_policy_exists(): void
    {
        $user = $this->userWithPermission('tickets.create');
        $client = $this->client();
        $tipo = CatTicketTipo::query()->create(['nombre' => 'Soporte', 'orden' => 1, 'activo' => true]);
        $prioridad = CatTicketPrioridad::query()->create(['nombre' => 'P2 - Media', 'orden' => 1, 'activo' => true]);
        CatTicketEstado::query()->create(['nombre' => 'Nuevo', 'orden' => 1, 'activo' => true]);
        $this->slaPolicy($prioridad);

        $this->actingAs($user)
            ->post(route('tickets.store'), [
                'cliente_id' => $client->id,
                'titulo' => 'No carga el dashboard',
                'descripcion' => 'El dashboard queda en blanco.',
                'tipo_id' => $tipo->id,
                'prioridad_id' => $prioridad->id,
            ])
            ->assertRedirect();

        $ticket = Ticket::query()->where('titulo', 'No carga el dashboard')->firstOrFail();

        $this->assertDatabaseHas('ticket_sla', [
            'ticket_id' => $ticket->id,
            'prioridad_id' => $prioridad->id,
        ]);
    }

    public function test_first_public_comment_sets_first_response(): void
    {
        $user = $this->userWithPermission('tickets.view');
        $ticket = $this->ticket();
        $this->slaPolicy($ticket->prioridad);
        app(\App\Services\Tickets\TicketSlaService::class)->createForTicket($ticket, $user->id);

        $this->actingAs($user)
            ->post(route('tickets.messages.store', $ticket), [
                'mensaje' => 'Ya estamos revisando tu solicitud.',
                'es_interno' => false,
                'es_respuesta_cliente' => false,
            ])
            ->assertRedirect();

        $this->assertNotNull($ticket->refresh()->primera_respuesta_at);
        $this->assertDatabaseHas('ticket_activity_logs', [
            'ticket_id' => $ticket->id,
            'accion' => 'sla_first_response_met',
        ]);
    }

    private function userWithPermission(string $permission): User
    {
        Permission::query()->firstOrCreate(['name' => $permission, 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->givePermissionTo($permission);

        return $user;
    }

    private function client(): Client
    {
        return Client::query()->create([
            'nombre' => 'Cliente Demo',
            'email' => 'cliente@example.test',
            'is_active' => true,
            'estatus' => 'activo',
        ]);
    }

    private function ticket(array $overrides = []): Ticket
    {
        $client = $this->client();
        $tipo = CatTicketTipo::query()->create(['nombre' => 'Bug', 'orden' => 1, 'activo' => true]);
        $estado = CatTicketEstado::query()->create(['nombre' => 'Nuevo', 'orden' => 1, 'activo' => true]);
        $prioridad = CatTicketPrioridad::query()->create(['nombre' => 'P2 - Media', 'orden' => 1, 'activo' => true]);

        return Ticket::query()->create([
            'folio' => 'TCK-888888',
            'cliente_id' => $client->id,
            'titulo' => 'Ticket base',
            'descripcion' => 'Descripcion del ticket base.',
            'tipo_id' => $tipo->id,
            'estado_id' => $estado->id,
            'prioridad_id' => $prioridad->id,
            ...$overrides,
        ]);
    }

    private function slaPolicy(CatTicketPrioridad $prioridad): SlaPolitica
    {
        $policy = SlaPolitica::query()->create([
            'nombre' => 'SLA prueba',
            'activo' => true,
            'es_default' => true,
        ]);

        $policy->prioridades()->create([
            'prioridad_id' => $prioridad->id,
            'tiempo_primera_respuesta_min' => 60,
            'tiempo_resolucion_min' => 480,
        ]);

        return $policy;
    }
}
