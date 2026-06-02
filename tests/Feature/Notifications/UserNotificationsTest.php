<?php

namespace Tests\Feature\Notifications;

use App\Models\User;
use App\Notifications\ProjectBilling\ProjectChargesDueSoonNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserNotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_and_mark_own_notification_as_read(): void
    {
        $user = User::factory()->create();
        $user->notify(new ProjectChargesDueSoonNotification(2, route('project-billing.charges.index'), now()->toDateString()));

        $notification = $user->notifications()->firstOrFail();

        $this->actingAs($user)
            ->get(route('notifications.index'))
            ->assertOk();

        $this->actingAs($user)
            ->patch(route('notifications.read', $notification->id))
            ->assertRedirect();

        $this->assertNotNull($notification->refresh()->read_at);
    }

    public function test_user_cannot_mark_another_user_notification_as_read(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $owner->notify(new ProjectChargesDueSoonNotification(1, route('project-billing.charges.index'), now()->toDateString()));

        $notification = $owner->notifications()->firstOrFail();

        $this->actingAs($other)
            ->patch(route('notifications.read', $notification->id))
            ->assertNotFound();
    }
}
