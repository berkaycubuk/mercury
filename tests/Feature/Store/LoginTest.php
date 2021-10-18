<?php

namespace Tests\Feature\Store;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Core\Models\Auth\User;

class LoginTest extends TestCase
{
    public function testItShouldSeeLoginPage()
    {
        $response = $this->get(route('store.login'));
        $response->assertStatus(200);
    }

    public function testAttemptLogin()
    {
        $user = User::factory()->create([
            'role' => 'customer'
        ]);
        
        $data = [
            'email' => $user->email,
            'password' => 'password'
        ]; 

        $response = $this->post(route('store.auth.login'), $data);

        $response->assertRedirect(route('store.index'));
        $this->assertAuthenticatedAs($user);
    }

    public function testAttemptLoginWithWrongInformation()
    {
        $data = [
            'email' => 'randomemailaddr@gmail.com',
            'password' => 'password123'
        ]; 

        $this->post(route('store.auth.login'), $data)
            ->assertRedirect(route('store.login'));

        $this->assertGuest();
    }
}
