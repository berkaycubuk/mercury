<?php

namespace Tests\Feature\Panel;

use Core\Models\Auth\User;
use Core\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use WithFaker;

    public function testItShouldSeePagesPage()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $response = $this->actingAs($user)
            ->get(route('panel.pages.index'));

        $response->assertStatus(200);
    }

    public function testItShouldCreatePage()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $data = [
            'title' => $this->faker->unique()->word,
            'content' => $this->faker->paragraph
        ];

        $this->actingAs($user)
            ->post(route('panel.pages.store'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('panel.pages.index'));
    }

    public function testItShouldUpdatePage()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $page = Page::factory()->create();

        $data = [
            'id' => $page->id,
            'title' => $this->faker->word,
            'slug' => $this->faker->unique()->word,
            'content' => $this->faker->paragraph,
        ];

        $this->actingAs($user)
            ->post(route('panel.pages.update'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('panel.pages.edit', ['id' => $page->id]));
    }

    public function testItShouldDeletePage()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $page = Page::factory()->create();

        $this->actingAs($user)
            ->get(route('panel.pages.delete', ['id' => $page->id]))
            ->assertStatus(302)
            ->assertRedirect(route('panel.pages.index'));
    }
}
