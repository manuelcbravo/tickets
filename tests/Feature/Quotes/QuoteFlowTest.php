<?php

namespace Tests\Feature\Quotes;

use App\Models\CatTicketEstado;
use App\Models\CatTicketPrioridad;
use App\Models\CatTicketTipo;
use App\Models\Client;
use App\Models\Cotizacion;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class QuoteFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_permission_can_view_quotes(): void
    {
        $user = $this->userWithPermissions(['quotes.view']);

        $this->actingAs($user)
            ->get(route('quotes.index'))
            ->assertOk();
    }

    public function test_quote_can_be_created_with_generated_folio(): void
    {
        $user = $this->userWithPermissions(['quotes.create']);
        $client = $this->client();

        $this->actingAs($user)
            ->post(route('quotes.store'), [
                'cliente_id' => $client->id,
                'titulo' => 'Nuevo modulo de reportes',
                'moneda' => 'MXN',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('cotizaciones', [
            'cliente_id' => $client->id,
            'titulo' => 'Nuevo modulo de reportes',
            'folio' => 'COT-000001',
        ]);
    }

    public function test_item_recalculates_quote_total(): void
    {
        $user = $this->userWithPermissions(['quotes.manage']);
        $quote = $this->quote();

        $this->actingAs($user)
            ->post(route('quotes.items.store', $quote), [
                'titulo' => 'Desarrollo',
                'tipo' => 'desarrollo',
                'cantidad' => 2,
                'unidad' => 'hora',
                'precio_unitario' => 500,
            ])
            ->assertRedirect();

        $quote->refresh();

        $this->assertSame('1000.00', $quote->subtotal);
        $this->assertSame('1000.00', $quote->total);
    }

    public function test_cannot_approve_internal_quote_without_items(): void
    {
        $user = $this->userWithPermissions(['quotes.approve.internal']);
        $quote = $this->quote();

        $this->actingAs($user)
            ->patch(route('quotes.approve-internal', $quote))
            ->assertSessionHasErrors('items');
    }

    public function test_approved_quote_can_be_converted_into_derived_ticket(): void
    {
        $user = $this->userWithPermissions([
            'quotes.approve.internal',
            'quotes.approve.client',
            'quotes.convert',
        ]);
        $quote = $this->quote();
        $quote->items()->create([
            'titulo' => 'Ejecucion',
            'tipo' => 'desarrollo',
            'cantidad' => 1,
            'unidad' => 'servicio',
            'precio_unitario' => 1000,
            'subtotal' => 1000,
        ]);
        $this->catalogs();

        $this->actingAs($user)->patch(route('quotes.approve-internal', $quote))->assertRedirect();
        $this->actingAs($user)->patch(route('quotes.approve-client', $quote))->assertRedirect();

        $this->actingAs($user)
            ->patch(route('quotes.convert', $quote), ['create_single_ticket' => true])
            ->assertRedirect();

        $this->assertDatabaseHas('cotizaciones', [
            'id' => $quote->id,
            'estado' => 'convertida',
        ]);

        $this->assertDatabaseHas('cotizacion_tickets', [
            'cotizacion_id' => $quote->id,
            'tipo_relacion' => 'derivado',
        ]);
    }

    public function test_quote_from_ticket_marks_ticket_and_links_quote(): void
    {
        $user = $this->userWithPermissions(['tickets.quote']);
        $ticket = $this->ticket();

        $this->actingAs($user)
            ->post(route('tickets.quote.store', $ticket), [
                'titulo' => 'Cotizacion especial',
                'alcance' => 'Alcance comercial inicial.',
                'incluir_descripcion_ticket' => true,
            ])
            ->assertRedirect();

        $ticket->refresh();

        $this->assertTrue($ticket->requires_quote);
        $this->assertSame('cotizado', $ticket->quote_status);
        $this->assertDatabaseHas('cotizacion_tickets', [
            'ticket_id' => $ticket->id,
            'tipo_relacion' => 'origen',
        ]);
        $this->assertDatabaseHas('ticket_activity_logs', [
            'ticket_id' => $ticket->id,
            'accion' => 'quote_created_from_ticket',
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

    private function client(): Client
    {
        return Client::query()->create([
            'nombre' => 'Cliente Demo',
            'email' => 'cliente@example.test',
            'is_active' => true,
            'estatus' => 'activo',
        ]);
    }

    private function quote(): Cotizacion
    {
        return Cotizacion::query()->create([
            'folio' => 'COT-TEST-001',
            'cliente_id' => $this->client()->id,
            'titulo' => 'Cotizacion base',
            'moneda' => 'MXN',
        ]);
    }

    private function ticket(): Ticket
    {
        $this->catalogs();
        $client = $this->client();

        return Ticket::query()->create([
            'folio' => 'TCK-QUOTE-001',
            'cliente_id' => $client->id,
            'titulo' => 'Nuevo desarrollo fuera de alcance',
            'descripcion' => 'Solicitan un modulo nuevo.',
            'tipo_id' => CatTicketTipo::query()->first()->id,
            'estado_id' => CatTicketEstado::query()->first()->id,
            'prioridad_id' => CatTicketPrioridad::query()->first()->id,
        ]);
    }

    private function catalogs(): void
    {
        CatTicketTipo::query()->firstOrCreate(['nombre' => 'Nuevo desarrollo'], ['orden' => 1, 'activo' => true]);
        CatTicketEstado::query()->firstOrCreate(['nombre' => 'Nuevo'], ['orden' => 1, 'activo' => true]);
        CatTicketPrioridad::query()->firstOrCreate(['nombre' => 'P2 - Media'], ['orden' => 1, 'activo' => true]);
    }
}
