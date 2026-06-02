<?php

namespace Tests\Feature\Config;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created_when_form_sends_empty_id(): void
    {
        Permission::query()->firstOrCreate(['name' => 'users.create', 'guard_name' => 'web']);

        $admin = User::factory()->create();
        $admin->givePermissionTo('users.create');

        $this->actingAs($admin)
            ->post(route('config.users.store'), [
                'id' => '',
                'name' => 'Manuel Cerda',
                'email' => 'manuel.cerda@fielgroup.com.mx',
                'password' => 'password123',
                'roles' => [],
            ])
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'name' => 'Manuel Cerda',
            'email' => 'manuel.cerda@fielgroup.com.mx',
        ]);
    }
}
