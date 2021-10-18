<?php

namespace Tests\Feature\Panel;

use Core\Models\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use WithFaker;

    public function testItShouldSeeGeneralPage()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $response = $this->actingAs($user)
            ->get(route('panel.settings.general'));

        $response->assertStatus(200);
    }

    public function testItShouldUpdateGeneral()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $data = [
            'title' => $this->faker->word,
            'description' => $this->faker->paragraph
        ];

        $this->actingAs($user)
            ->post(route('panel.settings.general.update'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('panel.settings.general'));
    }

    public function testItShouldSeeContactPage()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $response = $this->actingAs($user)
            ->get(route('panel.settings.contact'));

        $response->assertStatus(200);
    }

    public function testItShouldUpdateContact()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $data = [
            'email' => $this->faker->email,
            'phone' => $this->faker->e164PhoneNumber
        ];

        $this->actingAs($user)
            ->post(route('panel.settings.contact.update'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('panel.settings.contact'));
    }

    public function testItShouldSeeSocialPage()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $response = $this->actingAs($user)
            ->get(route('panel.settings.social'));

        $response->assertStatus(200);
    }

    public function testItShouldUpdateSocial()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $data = [
            'facebook_url' => 'https://facebook.com',
            'instagram_url' => 'https://instagram.com',
            'twitter_url' => 'https://twitter.com',
            'youtube_url' => 'https://youtube.com',
            'linkedin_url' => 'https://linkedin.com',
            'tiktok_url' => 'https://tiktok.com',
        ];

        $this->actingAs($user)
            ->post(route('panel.settings.social.update'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('panel.settings.social'));
    }

    public function testItShouldSeeFrontpage()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $response = $this->actingAs($user)
            ->get(route('panel.settings.frontpage'));

        $response->assertStatus(200);
    }

    public function testItShouldSeeMenuPage()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $response = $this->actingAs($user)
            ->get(route('panel.settings.menu'));

        $response->assertStatus(200);
    }

    public function testItShouldSeeShipmentPage()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $response = $this->actingAs($user)
            ->get(route('panel.settings.shipment'));

        $response->assertStatus(200);
    }
}
