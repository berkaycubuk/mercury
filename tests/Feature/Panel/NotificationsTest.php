<?php

namespace Tests\Feature\Panel;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Core\Models\Auth\User;

class NotificationsTest extends TestCase
{
    public function testUserCanSeeNotificationsPage()
    {
        $user = User::factory()->make([
            'role' => 'admin',
        ]);

        $this->actingAs($user)
            ->get(route('panel.notifications'))
            ->assertStatus(200);
    }
}
