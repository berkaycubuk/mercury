<?php

namespace Tests\Feature\Panel;

use Core\Models\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
    public function testItShouldSeeUsersPage()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $response = $this->actingAs($user)
            ->get(route('panel.users.index'));

        $response->assertStatus(200);
    }
}
