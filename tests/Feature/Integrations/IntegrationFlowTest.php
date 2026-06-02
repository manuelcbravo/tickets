<?php

namespace Tests\Feature\Integrations;

use App\Models\CatTicketEstado;
use App\Models\CatTicketPrioridad;
use App\Models\CatTicketTipo;
use App\Models\Client;
use App\Models\ExternalMessage;
use App\Models\Integracion;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class IntegrationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_permission_can_view_integrations(): void
    {
        $user = $this->userWithPermissions(['integrations.view']);

        $this->actingAs($user)
            ->get(route('integrations.index'))
            ->assertOk();
    }

    public function test_forbidden_messaging_provider_is_rejected(): void
    {
        $user = $this->userWithPermissions(['integrations.manage']);

        $this->actingAs($user)
            ->post(route('integrations.store'), [
                'nombre' => 'Canal WhatsApp',
                'tipo' => 'otro',
                'proveedor' => 'custom',
                'activo' => true,
            ])
            ->assertSessionHasErrors('tipo');
    }

    public function test_invalid_webhook_secret_returns_forbidden(): void
    {
        config(['integrations.webhooks.default_secret' => 'expected-secret']);
        $integration = Integracion::query()->create(['nombre' => 'Custom', 'tipo' => 'webhook', 'proveedor' => 'custom']);

        $this->postJson(route('webhooks.custom', $integration), ['message' => 'TCK-000001'], [
            'X-Webhook-Secret' => 'bad-secret',
        ])->assertForbidden();
    }

    public function test_valid_webhook_creates_event_and_links_ticket_by_folio(): void
    {
        config(['integrations.webhooks.default_secret' => 'expected-secret']);
        $ticket = $this->ticket('TCK-000001');
        $integration = Integracion::query()->create(['nombre' => 'Custom', 'tipo' => 'webhook', 'proveedor' => 'custom']);

        $this->postJson(route('webhooks.custom', $integration), [
            'event_type' => 'pull_request opened',
            'external_id' => 'evt-1',
            'title' => 'Fix TCK-000001 reportes',
        ], [
            'X-Webhook-Secret' => 'expected-secret',
        ])->assertAccepted();

        $this->assertDatabaseHas('webhook_events', [
            'provider' => 'custom',
            'external_id' => 'evt-1',
            'ticket_id' => $ticket->id,
            'status' => 'linked',
        ]);
    }

    public function test_ticket_email_notification_creates_log(): void
    {
        Mail::fake();
        $user = $this->userWithPermissions(['tickets.notifications.manage']);
        $ticket = $this->ticket('TCK-000002');

        $this->actingAs($user)
            ->post(route('tickets.notifications.email', $ticket), [
                'recipient' => 'cliente@example.test',
                'subject' => 'Actualizacion',
                'message' => 'Estamos revisando tu solicitud.',
                'save_as_public_comment' => false,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('notification_logs', [
            'ticket_id' => $ticket->id,
            'recipient' => 'cliente@example.test',
            'status' => 'sent',
        ]);
    }

    public function test_external_message_can_be_linked_and_converted_to_comment(): void
    {
        $user = $this->userWithPermissions(['integrations.manage']);
        $ticket = $this->ticket('TCK-000003');
        $message = ExternalMessage::query()->create([
            'channel' => 'email',
            'direction' => 'inbound',
            'sender' => 'cliente@example.test',
            'message' => 'Tengo mas informacion del ticket.',
        ]);

        $this->actingAs($user)
            ->patch(route('integrations.messages.link-ticket', $message), ['ticket_id' => $ticket->id])
            ->assertRedirect();

        $this->actingAs($user)
            ->post(route('integrations.messages.convert-comment', $message), ['es_interno' => true])
            ->assertRedirect();

        $this->assertDatabaseHas('ticket_messages', [
            'ticket_id' => $ticket->id,
            'mensaje' => 'Tengo mas informacion del ticket.',
            'es_interno' => true,
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

    private function ticket(string $folio): Ticket
    {
        $client = Client::query()->create(['nombre' => 'Cliente Demo', 'email' => 'cliente@example.test', 'is_active' => true, 'estatus' => 'activo']);
        $tipo = CatTicketTipo::query()->firstOrCreate(['nombre' => 'Soporte'], ['orden' => 1, 'activo' => true]);
        $estado = CatTicketEstado::query()->firstOrCreate(['nombre' => 'Nuevo'], ['orden' => 1, 'activo' => true]);
        $prioridad = CatTicketPrioridad::query()->firstOrCreate(['nombre' => 'P2 - Media'], ['orden' => 1, 'activo' => true]);

        return Ticket::query()->create([
            'folio' => $folio,
            'cliente_id' => $client->id,
            'titulo' => 'Ticket integracion',
            'descripcion' => 'Ticket para probar integraciones.',
            'tipo_id' => $tipo->id,
            'estado_id' => $estado->id,
            'prioridad_id' => $prioridad->id,
        ]);
    }
}
