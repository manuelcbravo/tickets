<?php

namespace Tests\Feature\Tickets;

use App\Models\CatTicketEstado;
use App\Models\CatTicketPrioridad;
use App\Models\CatTicketTipo;
use App\Models\Client;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class TicketCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_permission_can_view_ticket_index(): void
    {
        $user = $this->userWithPermission('tickets.view');

        $this->actingAs($user)
            ->get(route('tickets.index'))
            ->assertOk();
    }

    public function test_user_with_permission_can_create_ticket(): void
    {
        $user = $this->userWithPermission('tickets.create');
        $responsable = User::factory()->create();
        $client = $this->client();
        $tipo = CatTicketTipo::query()->create(['nombre' => 'Soporte', 'orden' => 1, 'activo' => true]);
        $prioridad = CatTicketPrioridad::query()->create(['nombre' => 'P2 - Media', 'orden' => 1, 'activo' => true]);
        CatTicketEstado::query()->create(['nombre' => 'Nuevo', 'orden' => 1, 'activo' => true]);

        $this->actingAs($user)
            ->post(route('tickets.store'), [
                'cliente_id' => $client->id,
                'titulo' => 'Error al generar reporte',
                'descripcion' => 'El reporte mensual no termina de generar.',
                'tipo_id' => $tipo->id,
                'prioridad_id' => $prioridad->id,
                'responsable_id' => $responsable->id,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('tickets', [
            'cliente_id' => $client->id,
            'titulo' => 'Error al generar reporte',
        ]);

        $this->assertDatabaseHas('ticket_activity_logs', [
            'accion' => 'ticket_created',
        ]);

        $this->assertDatabaseHas('notifications', [
            'notifiable_type' => User::class,
            'notifiable_id' => $responsable->id,
        ]);

        $this->assertDatabaseHas('ticket_activity_logs', [
            'accion' => 'notification_ticket_assigned_sent',
        ]);
    }

    public function test_user_without_permission_cannot_create_ticket(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('tickets.create'))
            ->assertForbidden();
    }

    public function test_ticket_requires_client_title_description_type_and_priority(): void
    {
        $user = $this->userWithPermission('tickets.create');

        $this->actingAs($user)
            ->post(route('tickets.store'), [])
            ->assertSessionHasErrors(['cliente_id', 'titulo', 'descripcion', 'tipo_id', 'prioridad_id']);
    }

    public function test_ticket_cannot_be_closed_without_resolution(): void
    {
        $user = $this->userWithPermission('tickets.close');
        $ticket = $this->ticket(['responsable_id' => $user->id]);

        $this->actingAs($user)
            ->patch(route('tickets.close', $ticket), ['resolution' => ''])
            ->assertSessionHasErrors(['resolution']);
    }

    public function test_closing_ticket_sets_closed_at(): void
    {
        $user = $this->userWithPermission('tickets.close');
        $ticket = $this->ticket(['responsable_id' => $user->id]);
        CatTicketEstado::query()->create(['nombre' => 'Cerrado', 'orden' => 2, 'activo' => true]);

        $this->actingAs($user)
            ->patch(route('tickets.close', $ticket), ['resolution' => 'Se corrigio el reporte.'])
            ->assertRedirect(route('tickets.show', $ticket));

        $this->assertNotNull($ticket->refresh()->closed_at);
        $this->assertDatabaseHas('ticket_activity_logs', [
            'ticket_id' => $ticket->id,
            'accion' => 'ticket_closed',
        ]);
    }

    public function test_priority_change_is_recorded_in_history(): void
    {
        $user = $this->userWithPermission('tickets.manage');
        $ticket = $this->ticket();
        $newPriority = CatTicketPrioridad::query()->create(['nombre' => 'P1 - Alta', 'orden' => 2, 'activo' => true]);

        $this->actingAs($user)
            ->put(route('tickets.update', $ticket), [
                ...$ticket->only([
                    'cliente_id',
                    'proyecto_id',
                    'proyecto_modulo_id',
                    'contacto_id',
                    'ambiente_id',
                    'titulo',
                    'descripcion',
                    'tipo_id',
                    'estado_id',
                    'impacto_id',
                    'urgencia_id',
                    'riesgo_id',
                    'dificultad',
                    'responsable_id',
                    'fecha_objetivo',
                    'tiempo_estimado_min',
                    'requires_code_change',
                    'requires_quote',
                    'is_internal',
                ]),
                'prioridad_id' => $newPriority->id,
            ])
            ->assertRedirect(route('tickets.show', $ticket));

        $this->assertDatabaseHas('ticket_activity_logs', [
            'ticket_id' => $ticket->id,
            'accion' => 'priority_changed',
        ]);
    }

    public function test_responsible_change_notifies_new_responsible_once(): void
    {
        $user = $this->userWithPermission('tickets.manage');
        $oldResponsible = User::factory()->create();
        $newResponsible = User::factory()->create();
        $ticket = $this->ticket(['responsable_id' => $oldResponsible->id]);

        $this->actingAs($user)
            ->put(route('tickets.update', $ticket), [
                ...$ticket->only([
                    'cliente_id',
                    'proyecto_id',
                    'proyecto_modulo_id',
                    'contacto_id',
                    'ambiente_id',
                    'titulo',
                    'descripcion',
                    'tipo_id',
                    'estado_id',
                    'impacto_id',
                    'urgencia_id',
                    'riesgo_id',
                    'dificultad',
                    'fecha_objetivo',
                    'tiempo_estimado_min',
                    'requires_code_change',
                    'requires_quote',
                    'is_internal',
                ]),
                'prioridad_id' => $ticket->prioridad_id,
                'responsable_id' => $newResponsible->id,
                'requires_code_change' => false,
                'requires_quote' => false,
                'is_internal' => false,
            ])
            ->assertRedirect(route('tickets.show', $ticket));

        $this->actingAs($user)
            ->put(route('tickets.update', $ticket->refresh()), [
                ...$ticket->only([
                    'cliente_id',
                    'proyecto_id',
                    'proyecto_modulo_id',
                    'contacto_id',
                    'ambiente_id',
                    'titulo',
                    'descripcion',
                    'tipo_id',
                    'estado_id',
                    'impacto_id',
                    'urgencia_id',
                    'riesgo_id',
                    'dificultad',
                    'fecha_objetivo',
                    'tiempo_estimado_min',
                    'requires_code_change',
                    'requires_quote',
                    'is_internal',
                ]),
                'prioridad_id' => $ticket->prioridad_id,
                'responsable_id' => $newResponsible->id,
                'requires_code_change' => false,
                'requires_quote' => false,
                'is_internal' => false,
            ])
            ->assertRedirect(route('tickets.show', $ticket));

        $this->assertSame(1, $newResponsible->notifications()->count());
    }

    public function test_comment_addition_is_recorded_in_history(): void
    {
        $user = $this->userWithPermission('tickets.view');
        $ticket = $this->ticket();

        $this->actingAs($user)
            ->post(route('tickets.messages.store', $ticket), [
                'mensaje' => 'Se revisa con el equipo tecnico.',
                'es_interno' => true,
                'es_respuesta_cliente' => false,
            ])
            ->assertRedirect(route('tickets.show', $ticket));

        $this->assertDatabaseHas('ticket_activity_logs', [
            'ticket_id' => $ticket->id,
            'accion' => 'comment_added',
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
            'folio' => 'TCK-999999',
            'cliente_id' => $client->id,
            'titulo' => 'Ticket base',
            'descripcion' => 'Descripcion del ticket base.',
            'tipo_id' => $tipo->id,
            'estado_id' => $estado->id,
            'prioridad_id' => $prioridad->id,
            ...$overrides,
        ]);
    }
}
