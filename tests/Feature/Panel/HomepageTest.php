<?php

namespace Tests\Feature\Panel;

use Core\Models\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    public function testItShouldntSeeHomepage()
    {
        $response = $this->get(route('panel.homepage.index'));
        $response->assertStatus(302);
    }

    public function testItShouldSeeHomepage()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $response = $this->actingAs($user)
            ->get(route('panel.homepage.index'));

        $response->assertStatus(200);
    }
}
