<?php

namespace Tests\Feature\Store;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use WithFaker;

    public function testItShouldSeeRegisterPage()
    {
        $response = $this->get(route('store.register'));
        $response->assertStatus(200);
    }

    /*
    public function testAttemptRegister()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password'
        ]; 

        $this->post(route('store.auth.register'), $data)
            ->assertRedirect(route('store.register'));
    }
    */
}
