<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Core\Models\Auth\User;

class CartTest extends TestCase
{
    public function testUserCanSeeCartPage()
    {
        $user = User::factory()->make([
            'role' => 'customer',
        ]);

        $this->actingAs($user)
             ->get(route('store.cart'))
            ->assertStatus(200);
    }

    public function testVisitorCanSeeCartPage()
    {
        $this->get(route('store.cart'))
            ->assertStatus(200);
    }
}
