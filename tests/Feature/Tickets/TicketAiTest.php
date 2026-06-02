<?php

namespace Tests\Feature\Tickets;

use App\Models\AiAnalysis;
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

class TicketAiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_permission_can_request_ai_analysis_and_disabled_ai_fails_safely(): void
    {
        config(['ai.enabled' => false]);

        $user = $this->userWithPermissions(['tickets.ai.analyze', 'tickets.ai.view']);
        $ticket = $this->ticket();

        $this->actingAs($user)
            ->post(route('tickets.ai.analyze', $ticket), ['analysis_type' => 'full'])
            ->assertRedirect(route('tickets.ai.show', $ticket));

        $this->assertDatabaseHas('ai_analyses', [
            'ticket_id' => $ticket->id,
            'status' => 'failed',
        ]);
        $this->assertDatabaseHas('ticket_activity_logs', [
            'ticket_id' => $ticket->id,
            'accion' => 'ai_analysis_failed',
        ]);
    }

    public function test_user_without_permission_cannot_request_ai_analysis(): void
    {
        $ticket = $this->ticket();

        $this->actingAs(User::factory()->create())
            ->post(route('tickets.ai.analyze', $ticket), ['analysis_type' => 'full'])
            ->assertForbidden();
    }

    public function test_user_can_apply_priority_suggestion_manually(): void
    {
        $user = $this->userWithPermissions(['tickets.ai.apply']);
        $ticket = $this->ticket();
        $priority = CatTicketPrioridad::query()->create(['nombre' => 'P1 - Alta', 'orden' => 2, 'activo' => true]);
        $analysis = AiAnalysis::query()->create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'status' => 'completed',
            'analysis_type' => 'full',
            'suggested_priority_id' => $priority->id,
            'confidence' => 0.82,
        ]);

        $this->actingAs($user)
            ->patch(route('tickets.ai.analysis.apply', [$ticket, $analysis]), [
                'apply_priority' => true,
            ])
            ->assertRedirect(route('tickets.ai.show', $ticket));

        $this->assertSame($priority->id, $ticket->refresh()->prioridad_id);
        $this->assertDatabaseHas('ticket_activity_logs', [
            'ticket_id' => $ticket->id,
            'accion' => 'ai_suggestion_applied',
        ]);
    }

    public function test_user_can_reject_ai_suggestion(): void
    {
        $user = $this->userWithPermissions(['tickets.ai.apply']);
        $ticket = $this->ticket();
        $analysis = AiAnalysis::query()->create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'status' => 'completed',
            'analysis_type' => 'full',
        ]);

        $this->actingAs($user)
            ->patch(route('tickets.ai.analysis.reject', [$ticket, $analysis]), [
                'reason' => 'No aplica al contexto real.',
            ])
            ->assertRedirect(route('tickets.ai.show', $ticket));

        $this->assertSame('rejected', $analysis->refresh()->status);
        $this->assertDatabaseHas('ticket_activity_logs', [
            'ticket_id' => $ticket->id,
            'accion' => 'ai_suggestion_rejected',
        ]);
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

    private function ticket(): Ticket
    {
        $client = Client::query()->create([
            'nombre' => 'Cliente Demo',
            'email' => 'cliente@example.test',
            'is_active' => true,
            'estatus' => 'activo',
        ]);
        $tipo = CatTicketTipo::query()->create(['nombre' => 'Bug', 'orden' => 1, 'activo' => true]);
        $estado = CatTicketEstado::query()->create(['nombre' => 'Nuevo', 'orden' => 1, 'activo' => true]);
        $prioridad = CatTicketPrioridad::query()->create(['nombre' => 'P2 - Media', 'orden' => 1, 'activo' => true]);
        CatTicketImpacto::query()->create(['nombre' => 'Medio', 'orden' => 1, 'activo' => true]);
        CatTicketUrgencia::query()->create(['nombre' => 'Media', 'orden' => 1, 'activo' => true]);
        CatTicketRiesgo::query()->create(['nombre' => 'Medio', 'orden' => 1, 'activo' => true]);

        return Ticket::query()->create([
            'folio' => 'TCK-888888',
            'cliente_id' => $client->id,
            'titulo' => 'Error en reporte',
            'descripcion' => 'El reporte falla al exportar.',
            'tipo_id' => $tipo->id,
            'estado_id' => $estado->id,
            'prioridad_id' => $prioridad->id,
        ]);
    }
}
