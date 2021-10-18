<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Core\Models\Auth\User;

class UpdateTest extends TestCase
{
    public function testUserCanSeeUpdatesPage()
    {
        $user = User::factory()->make([
            'role' => 'admin',
        ]);

        $this->actingAs($user)
            ->get(route('panel.updates'))
            ->assertStatus(200);
    }
}
