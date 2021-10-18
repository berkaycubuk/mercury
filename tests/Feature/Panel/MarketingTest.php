<?php

namespace Tests\Feature\Panel;

use Core\Models\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MarketingTest extends TestCase
{
    use WithFaker;

    public function testItShouldSeeCouponsPage()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $response = $this->actingAs($user)
            ->get(route('panel.marketing.coupons.index'));

        $response->assertStatus(200);
    }
}
