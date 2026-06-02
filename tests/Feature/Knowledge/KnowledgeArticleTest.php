<?php

namespace Tests\Feature\Knowledge;

use App\Models\CatTicketEstado;
use App\Models\CatTicketPrioridad;
use App\Models\CatTicketTipo;
use App\Models\Client;
use App\Models\KnowledgeArticle;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class KnowledgeArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_permission_can_view_articles(): void
    {
        $user = $this->userWithPermission('knowledge.view');

        $this->actingAs($user)
            ->get(route('knowledge.index'))
            ->assertOk();
    }

    public function test_user_without_permission_cannot_view_articles(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('knowledge.index'))
            ->assertForbidden();
    }

    public function test_user_can_create_article(): void
    {
        $user = $this->userWithPermission('knowledge.create');

        $this->actingAs($user)
            ->post(route('knowledge.store'), [
                'titulo' => 'Reiniciar cache de reportes',
                'contenido' => 'Procedimiento para limpiar cache y validar reportes.',
                'tipo' => 'procedimiento',
                'visibilidad' => 'interna',
                'estatus' => 'borrador',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('knowledge_articles', [
            'titulo' => 'Reiniciar cache de reportes',
            'visibilidad' => 'interna',
        ]);
    }

    public function test_article_requires_title_and_content(): void
    {
        $user = $this->userWithPermission('knowledge.create');

        $this->actingAs($user)
            ->post(route('knowledge.store'), [
                'tipo' => 'procedimiento',
                'visibilidad' => 'interna',
            ])
            ->assertSessionHasErrors(['titulo', 'contenido']);
    }

    public function test_user_without_publish_permission_cannot_publish_article(): void
    {
        $user = $this->userWithPermission('knowledge.manage');
        $article = $this->article();

        $this->actingAs($user)
            ->patch(route('knowledge.publish', $article))
            ->assertForbidden();
    }

    public function test_client_visibility_requires_client(): void
    {
        $user = $this->userWithPermission('knowledge.create');

        $this->actingAs($user)
            ->post(route('knowledge.store'), [
                'titulo' => 'Guia cliente',
                'contenido' => 'Contenido suficiente para validar la guia.',
                'tipo' => 'guia_usuario',
                'visibilidad' => 'cliente',
            ])
            ->assertSessionHasErrors(['cliente_id']);
    }

    public function test_can_link_article_to_ticket_and_prevent_duplicate_relation(): void
    {
        $user = $this->userWithPermission('knowledge.link');
        $ticket = $this->ticket();
        $article = $this->article();

        $payload = [
            'knowledge_article_id' => $article->id,
            'tipo_relacion' => 'relacionado',
        ];

        $this->actingAs($user)
            ->post(route('tickets.knowledge.link', $ticket), $payload)
            ->assertRedirect();

        $this->actingAs($user)
            ->post(route('tickets.knowledge.link', $ticket), $payload)
            ->assertSessionHasErrors(['knowledge_article_id']);
    }

    public function test_editing_published_article_stores_previous_version(): void
    {
        $user = $this->userWithPermission('knowledge.manage');
        $article = $this->article(['estatus' => 'publicado']);

        $this->actingAs($user)
            ->put(route('knowledge.update', $article), [
                'titulo' => 'Articulo actualizado',
                'contenido' => 'Contenido actualizado con suficiente longitud.',
                'tipo' => 'procedimiento',
                'visibilidad' => 'interna',
                'estatus' => 'publicado',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('knowledge_article_versions', [
            'knowledge_article_id' => $article->id,
            'version' => 1,
            'titulo' => $article->titulo,
        ]);
    }

    private function userWithPermission(string $permission): User
    {
        Permission::query()->firstOrCreate(['name' => $permission, 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->givePermissionTo($permission);

        return $user;
    }

    private function article(array $overrides = []): KnowledgeArticle
    {
        return KnowledgeArticle::query()->create([
            'titulo' => 'Articulo base',
            'slug' => 'articulo-base-'.str()->random(6),
            'contenido' => 'Contenido suficiente del articulo base.',
            'tipo' => 'procedimiento',
            'visibilidad' => 'interna',
            'estatus' => 'borrador',
            ...$overrides,
        ]);
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

        return Ticket::query()->create([
            'folio' => 'TCK-777777',
            'cliente_id' => $client->id,
            'titulo' => 'Ticket base',
            'descripcion' => 'Descripcion del ticket base.',
            'tipo_id' => $tipo->id,
            'estado_id' => $estado->id,
            'prioridad_id' => $prioridad->id,
        ]);
    }
}
