<?php

namespace Tests\Feature\Tickets;

use App\Models\CatTicketEstado;
use App\Models\CatTicketPrioridad;
use App\Models\CatTicketTipo;
use App\Models\Client;
use App\Models\Ticket;
use App\Models\TicketTestResult;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class TicketQaTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_permission_can_view_qa_dashboard(): void
    {
        $user = $this->userWithPermission('tickets.qa.view');

        $this->actingAs($user)
            ->get(route('tickets.qa.index'))
            ->assertOk();
    }

    public function test_user_can_create_test_case_for_ticket(): void
    {
        $user = $this->userWithPermission('tickets.qa.manage');
        $ticket = $this->ticket(['responsable_id' => $user->id]);

        $this->actingAs($user)
            ->post(route('tickets.qa.test-cases.store', $ticket), [
                'titulo' => 'Validar correccion principal',
                'tipo' => 'manual',
                'activo' => true,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('test_cases', [
            'ticket_id' => $ticket->id,
            'titulo' => 'Validar correccion principal',
        ]);
    }

    public function test_failed_result_requires_obtained_result(): void
    {
        $user = $this->userWithPermission('tickets.qa.manage');
        $ticket = $this->ticket(['responsable_id' => $user->id]);

        $this->actingAs($user)
            ->post(route('tickets.qa.test-results.store', $ticket), [
                'titulo' => 'Validar flujo',
                'status' => 'fallido',
            ])
            ->assertSessionHasErrors(['resultado_obtenido']);
    }

    public function test_bug_cannot_be_closed_without_approved_test(): void
    {
        $user = $this->userWithPermission('tickets.close');
        $ticket = $this->ticket(['responsable_id' => $user->id]);
        CatTicketEstado::query()->create(['nombre' => 'Cerrado', 'orden' => 2, 'activo' => true]);

        $this->actingAs($user)
            ->patch(route('tickets.close', $ticket), ['resolution' => 'Se corrigio el bug reportado.'])
            ->assertSessionHasErrors(['qa']);
    }

    public function test_ticket_reopen_requires_reason_and_increments_counter(): void
    {
        $user = $this->userWithPermission('tickets.reopen');
        $ticket = $this->ticket([
            'responsable_id' => $user->id,
            'closed_at' => now(),
        ]);
        CatTicketEstado::query()->create(['nombre' => 'Reabierto', 'orden' => 3, 'activo' => true]);

        $this->actingAs($user)
            ->patch(route('tickets.reopen', $ticket), ['reason' => 'El cliente confirmo que el problema continua.'])
            ->assertRedirect(route('tickets.show', $ticket));

        $ticket->refresh();

        $this->assertSame(1, $ticket->reopen_count);
        $this->assertDatabaseHas('ticket_reopen_logs', [
            'ticket_id' => $ticket->id,
            'reason' => 'El cliente confirmo que el problema continua.',
        ]);
    }

    public function test_approved_result_allows_bug_close(): void
    {
        $user = $this->userWithPermission('tickets.close');
        $ticket = $this->ticket(['responsable_id' => $user->id]);
        CatTicketEstado::query()->create(['nombre' => 'Cerrado', 'orden' => 2, 'activo' => true]);

        TicketTestResult::query()->create([
            'ticket_id' => $ticket->id,
            'titulo' => 'Validar correccion',
            'resultado_obtenido' => 'El flujo corregido funciona.',
            'status' => 'aprobado',
            'executed_at' => now(),
            'executed_by_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->patch(route('tickets.close', $ticket), ['resolution' => 'Se corrigio y valido el flujo afectado.'])
            ->assertRedirect(route('tickets.show', $ticket));

        $this->assertNotNull($ticket->refresh()->closed_at);
        $this->assertDatabaseHas('ticket_activity_logs', [
            'ticket_id' => $ticket->id,
            'accion' => 'ticket_closed_with_qa',
        ]);
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
            'nombre' => 'Cliente QA',
            'email' => 'qa@example.test',
            'is_active' => true,
            'estatus' => 'activo',
        ]);

        $tipo = CatTicketTipo::query()->create(['nombre' => 'Bug', 'orden' => 1, 'activo' => true]);
        $estado = CatTicketEstado::query()->create(['nombre' => 'Nuevo', 'orden' => 1, 'activo' => true]);
        $prioridad = CatTicketPrioridad::query()->create(['nombre' => 'P2 - Media', 'orden' => 1, 'activo' => true]);

        return Ticket::query()->create([
            'folio' => 'TCK-QA-001',
            'cliente_id' => $client->id,
            'titulo' => 'Ticket QA',
            'descripcion' => 'Ticket para pruebas de QA.',
            'tipo_id' => $tipo->id,
            'estado_id' => $estado->id,
            'prioridad_id' => $prioridad->id,
            ...$overrides,
        ]);
    }
}
