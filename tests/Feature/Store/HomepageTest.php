<?php

namespace Tests\Feature\Store;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Core\Models\Auth\User;

class HomepageTest extends TestCase
{
    public function testUserShouldSeeHomepage()
    {
        $user = User::factory()->make([
            'role' => 'customer',
        ]);

        $response = $this->actingAs($user)
             ->get('/');

        $response->assertStatus(200);
    }

    public function testVisitorShouldSeeHomepage()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
