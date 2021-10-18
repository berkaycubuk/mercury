<?php

namespace Tests\Feature\Store;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Core\Models\Auth\User;

class AuthTest extends TestCase
{
    public function testUserCantSeeAccountPageWithoutLogin()
    {
        $this->get(route('store.account'))
             ->assertStatus(302);
    }

    public function testUserCanSeeAccountPage()
    {
        $user = User::factory()->make([
            'role' => 'customer',
        ]);

        $this->actingAs($user)
            ->get(route('store.account'))
            ->assertStatus(200);
    }

    public function testUserCanSeeAccountSettings()
    {
        $user = User::factory()->make([
            'role' => 'customer',
        ]);

        $this->actingAs($user)
            ->get(route('store.settings.index'))
            ->assertStatus(200);
    }
}
