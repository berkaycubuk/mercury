<?php

namespace Tests\Feature\Panel;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Core\Models\Auth\User;

class AuthTest extends TestCase
{
    use WithFaker;

    public function testUserCanSeeAccountSettings()
    {
        $user = User::factory()->make([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)
                         ->get(route('panel.auth.settings'));

        $response->assertStatus(200);
    }

    public function testUserCanUpdateAccountSettings()
    {
        $user = User::factory()->make([
            'role' => 'admin',
        ]);

        $newFirstName = $this->faker->firstName();
        $newLastName = $this->faker->lastName();
        $newEmail = $this->faker->unique()->safeEmail();

        $this->actingAs($user)
             ->post(route('panel.auth.settings.update'), [
                 'first-name' => $newFirstName,
                 'last-name' => $newLastName,
                 'email' => $newEmail,
                 'branch' => 'null',
                 'new-pass' => "",
                 'new-pass-confirmation' => "",
             ])
             ->assertRedirect(route('panel.auth.settings'));

        $this->assertSame($newFirstName, $user->first_name);
        $this->assertSame($newLastName, $user->last_name);
        $this->assertSame($newEmail, $user->email);
    }
}
