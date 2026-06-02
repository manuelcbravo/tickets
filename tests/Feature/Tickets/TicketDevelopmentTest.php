<?php

namespace Tests\Feature\Tickets;

use App\Models\CatTicketEstado;
use App\Models\CatTicketPrioridad;
use App\Models\CatTicketTipo;
use App\Models\Client;
use App\Models\Proyecto;
use App\Models\Release;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class TicketDevelopmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_permission_can_view_releases(): void
    {
        $user = $this->userWithPermission('development.releases.view');

        $this->actingAs($user)
            ->get(route('development.releases.index'))
            ->assertOk();
    }

    public function test_user_can_create_development_task_and_mark_ticket_code_changes(): void
    {
        $user = $this->userWithPermission('tickets.development.manage');
        $ticket = $this->ticketWithProject();

        $this->actingAs($user)
            ->post(route('tickets.development.tasks.store', $ticket), [
                'titulo' => 'Corregir validacion de login',
                'tipo' => 'bugfix',
                'estado' => 'en_desarrollo',
                'proyecto_id' => $ticket->proyecto_id,
            ])
            ->assertRedirect();

        $ticket->refresh();

        $this->assertTrue($ticket->has_code_changes);
        $this->assertSame('en_desarrollo', $ticket->development_status);
        $this->assertDatabaseHas('ticket_activity_logs', [
            'ticket_id' => $ticket->id,
            'accion' => 'development_task_created',
        ]);
    }

    public function test_release_prevents_duplicate_ticket(): void
    {
        $user = $this->userWithPermission('development.releases.manage');
        $ticket = $this->ticketWithProject();
        $release = Release::query()->create([
            'proyecto_id' => $ticket->proyecto_id,
            'nombre' => 'Release demo',
            'estado' => 'borrador',
            'created_by_id' => $user->id,
        ]);

        $payload = ['ticket_id' => $ticket->id];

        $this->actingAs($user)
            ->post(route('development.releases.tickets.store', $release), $payload)
            ->assertRedirect();

        $this->actingAs($user)
            ->post(route('development.releases.tickets.store', $release), $payload)
            ->assertSessionHasErrors(['ticket_id']);
    }

    private function userWithPermission(string $permission): User
    {
        Permission::query()->firstOrCreate(['name' => $permission, 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->givePermissionTo($permission);

        return $user;
    }

    private function ticketWithProject(): Ticket
    {
        $client = Client::query()->create([
            'nombre' => 'Cliente Desarrollo',
            'email' => 'dev@example.test',
            'is_active' => true,
            'estatus' => 'activo',
        ]);

        $project = Proyecto::query()->create([
            'client_id' => $client->id,
            'nombre' => 'Proyecto desarrollo',
            'estado' => 'desarrollo',
            'criticidad' => 'media',
        ]);

        $tipo = CatTicketTipo::query()->create(['nombre' => 'Bug', 'orden' => 1, 'activo' => true]);
        $estado = CatTicketEstado::query()->create(['nombre' => 'Nuevo', 'orden' => 1, 'activo' => true]);
        $prioridad = CatTicketPrioridad::query()->create(['nombre' => 'P2 - Media', 'orden' => 1, 'activo' => true]);

        return Ticket::query()->create([
            'folio' => 'TCK-DEV-001',
            'cliente_id' => $client->id,
            'proyecto_id' => $project->id,
            'titulo' => 'Ticket con desarrollo',
            'descripcion' => 'Requiere trazabilidad tecnica.',
            'tipo_id' => $tipo->id,
            'estado_id' => $estado->id,
            'prioridad_id' => $prioridad->id,
        ]);
    }
}
