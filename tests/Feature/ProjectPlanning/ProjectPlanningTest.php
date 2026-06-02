<?php

namespace Tests\Feature\ProjectPlanning;

use App\Models\CatTicketEstado;
use App\Models\CatTicketPrioridad;
use App\Models\CatTicketTipo;
use App\Models\Client;
use App\Models\Proyecto;
use App\Models\ProyectoActividad;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ProjectPlanningTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_with_permission_can_view_planning_route(): void
    {
        $user = $this->userWithPermission('project-planning.view');
        $project = $this->project();

        $this->actingAs($user)
            ->get(route('proyectos.planning.show', $project))
            ->assertRedirect(route('proyectos.show', $project));
    }

    public function test_user_without_permission_cannot_view_planning_route(): void
    {
        $project = $this->project();

        $this->actingAs(User::factory()->create())
            ->get(route('proyectos.planning.show', $project))
            ->assertForbidden();
    }

    public function test_can_update_project_planning_description(): void
    {
        $user = $this->userWithPermission('project-planning.manage');
        $project = $this->project();

        $this->actingAs($user)
            ->patch(route('proyectos.planning.update', $project), [
                'objetivo' => 'Reducir tiempos de soporte',
                'alcance' => 'Modulo operativo',
                'fecha_inicio' => '2026-06-01',
                'fecha_objetivo' => '2026-06-30',
                'estado_planeacion' => 'planeado',
                'prioridad_planeacion' => 'alta',
                'avance_porcentaje' => 25,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'objetivo' => 'Reducir tiempos de soporte',
            'avance_porcentaje' => 25,
        ]);
    }

    public function test_can_upload_allowed_document_and_reject_executable(): void
    {
        Storage::fake('public');
        $user = $this->userWithPermission('project-planning.documents.manage');
        $project = $this->project();

        $this->actingAs($user)
            ->post(route('files.store'), [
                'related_table' => 'projects',
                'related_uuid' => $project->id,
                'file' => UploadedFile::fake()->create('contrato.pdf', 120, 'application/pdf'),
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('files', [
            'related_table' => 'projects',
            'related_uuid' => $project->id,
            'original_name' => 'contrato.pdf',
        ]);

        $this->actingAs($user)
            ->post(route('files.store'), [
                'related_table' => 'projects',
                'related_uuid' => $project->id,
                'file' => UploadedFile::fake()->create('deploy.sh', 1, 'text/x-shellscript'),
            ])
            ->assertSessionHasErrors(['file']);
    }

    public function test_can_create_activity_move_to_done_and_register_time(): void
    {
        $user = $this->userWithPermission('project-planning.activities.manage');
        $user->givePermissionTo($this->permission('project-planning.kanban.manage'));
        $user->givePermissionTo($this->permission('project-planning.activities.time'));
        $project = $this->project();

        $this->actingAs($user)
            ->post(route('proyectos.activities.store', $project), [
                'titulo' => 'Preparar plan tecnico',
                'tipo' => 'tarea',
                'prioridad' => 'media',
                'minutos_estimados' => 60,
            ])
            ->assertRedirect();

        $activity = ProyectoActividad::query()->firstOrFail();

        $this->actingAs($user)
            ->patch(route('proyectos.activities.kanban', [$project, $activity]), [
                'kanban_column' => 'terminado',
            ])
            ->assertRedirect();

        $this->assertSame('terminada', $activity->refresh()->estado);

        $this->actingAs($user)
            ->post(route('proyectos.activities.times.store', [$project, $activity]), [
                'descripcion' => 'Revision tecnica inicial',
                'minutos' => 45,
                'fecha' => '2026-06-01',
            ])
            ->assertRedirect();

        $this->assertSame(45, $activity->refresh()->minutos_reales);

        $this->actingAs($user)
            ->post(route('proyectos.activities.times.store', [$project, $activity]), [
                'descripcion' => 'Tiempo invalido',
                'minutos' => 0,
                'fecha' => '2026-06-01',
            ])
            ->assertSessionHasErrors(['minutos']);
    }

    public function test_can_view_and_create_activity_from_global_module(): void
    {
        $user = $this->userWithPermission('project-planning.activities.view');
        $user->givePermissionTo($this->permission('project-planning.activities.manage'));
        $responsable = User::factory()->create();
        $project = $this->project();

        $this->actingAs($user)
            ->get(route('activities.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('activities.dashboard'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('activities.completed'))
            ->assertOk();

        $this->actingAs($user)
            ->post(route('activities.store'), [
                'proyecto_id' => $project->id,
                'titulo' => 'Actividad desde modulo global',
                'tipo' => 'tarea',
                'prioridad' => 'alta',
                'responsable_id' => $responsable->id,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('proyecto_actividades', [
            'proyecto_id' => $project->id,
            'titulo' => 'Actividad desde modulo global',
            'responsable_id' => $responsable->id,
        ]);

        $this->assertDatabaseHas('notifications', [
            'notifiable_type' => User::class,
            'notifiable_id' => $responsable->id,
        ]);
    }

    public function test_can_link_activity_to_ticket_without_duplicates(): void
    {
        $user = $this->userWithPermission('project-planning.activities.manage');
        $project = $this->project();
        $ticket = $this->ticket($project);
        $activity = ProyectoActividad::query()->create([
            'proyecto_id' => $project->id,
            'titulo' => 'Actividad soporte',
            'tipo' => 'tarea',
            'estado' => 'pendiente',
            'prioridad' => 'media',
        ]);

        $payload = ['ticket_id' => $ticket->id, 'tipo_relacion' => 'seguimiento'];

        $this->actingAs($user)
            ->post(route('proyectos.activities.tickets.store', [$project, $activity]), $payload)
            ->assertRedirect();

        $this->actingAs($user)
            ->post(route('proyectos.activities.tickets.store', [$project, $activity]), $payload)
            ->assertRedirect();

        $this->assertDatabaseCount('proyecto_actividad_tickets', 1);
    }

    public function test_activity_actions_have_independent_pages(): void
    {
        $user = $this->userWithPermission('project-planning.activities.manage');
        $user->givePermissionTo($this->permission('project-planning.activities.time'));
        $user->givePermissionTo($this->permission('project-planning.kanban.manage'));
        $user->givePermissionTo($this->permission('tickets.create'));

        $project = $this->project();
        $ticket = $this->ticket($project);
        $activity = ProyectoActividad::query()->create([
            'proyecto_id' => $project->id,
            'ticket_id' => $ticket->id,
            'titulo' => 'Actividad con acciones',
            'tipo' => 'tarea',
            'estado' => 'pendiente',
            'prioridad' => 'media',
            'kanban_column' => 'backlog',
        ]);

        $this->actingAs($user)
            ->get(route('proyectos.activities.times.create', [$project, $activity]))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('activities/times/create'));

        $this->actingAs($user)
            ->get(route('proyectos.activities.kanban.edit', [$project, $activity]))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('activities/kanban/edit'));

        $this->actingAs($user)
            ->get(route('proyectos.activities.tickets.create', [$project, $activity]))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('activities/tickets/create'));

        $this->actingAs($user)
            ->get(route('proyectos.activities.create-ticket.create', [$project, $activity]))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('activities/tickets/from-activity'));
    }

    public function test_create_ticket_from_activity_requires_ticket_permission(): void
    {
        $project = $this->project();
        $activity = ProyectoActividad::query()->create([
            'proyecto_id' => $project->id,
            'titulo' => 'Crear ajuste',
            'tipo' => 'tarea',
            'estado' => 'pendiente',
            'prioridad' => 'media',
        ]);

        $tipo = CatTicketTipo::query()->create(['nombre' => 'Soporte', 'orden' => 1, 'activo' => true]);
        $prioridad = CatTicketPrioridad::query()->create(['nombre' => 'P2 - Media', 'orden' => 1, 'activo' => true]);
        CatTicketEstado::query()->create(['nombre' => 'Nuevo', 'orden' => 1, 'activo' => true]);

        $this->actingAs(User::factory()->create())
            ->post(route('proyectos.activities.create-ticket', [$project, $activity]), [
                'tipo_id' => $tipo->id,
                'prioridad_id' => $prioridad->id,
            ])
            ->assertForbidden();

        $user = $this->userWithPermission('tickets.create');

        $this->actingAs($user)
            ->post(route('proyectos.activities.create-ticket', [$project, $activity]), [
                'tipo_id' => $tipo->id,
                'prioridad_id' => $prioridad->id,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('tickets', [
            'proyecto_id' => $project->id,
            'titulo' => 'Crear ajuste',
        ]);
    }

    private function userWithPermission(string $permission): User
    {
        $user = User::factory()->create();
        $user->givePermissionTo($this->permission($permission));

        return $user;
    }

    private function permission(string $permission): Permission
    {
        return Permission::query()->firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
    }

    private function project(): Proyecto
    {
        $client = Client::query()->create([
            'nombre' => 'Cliente Demo',
            'first_name' => 'Cliente',
            'last_name' => 'Demo',
            'email' => 'cliente@example.test',
            'is_active' => true,
            'estatus' => 'activo',
        ]);

        return Proyecto::query()->create([
            'client_id' => $client->id,
            'nombre' => 'Proyecto Demo',
            'estado' => 'mantenimiento',
            'criticidad' => 'media',
        ]);
    }

    private function ticket(Proyecto $project): Ticket
    {
        $tipo = CatTicketTipo::query()->create(['nombre' => 'Bug', 'orden' => 1, 'activo' => true]);
        $estado = CatTicketEstado::query()->create(['nombre' => 'Nuevo', 'orden' => 1, 'activo' => true]);
        $prioridad = CatTicketPrioridad::query()->create(['nombre' => 'P2 - Media', 'orden' => 1, 'activo' => true]);

        return Ticket::query()->create([
            'folio' => 'TCK-999999',
            'cliente_id' => $project->client_id,
            'proyecto_id' => $project->id,
            'titulo' => 'Ticket base',
            'descripcion' => 'Descripcion del ticket base.',
            'tipo_id' => $tipo->id,
            'estado_id' => $estado->id,
            'prioridad_id' => $prioridad->id,
        ]);
    }
}
