<?php

namespace Tests\Feature\Panel;

use Core\Models\Auth\User;
use Blog\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use WithFaker;

    public function testItShouldCreatePost()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $data = [
            'title' => $this->faker->unique()->word,
            'content' => $this->faker->paragraph
        ];

        $this->actingAs($user)
            ->post(route('panel.blog.posts.store'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('panel.blog.posts.index'));
    }

    public function testItShouldReadPost()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $post = Post::factory()->create();

        $this->actingAs($user)
            ->get(route('panel.blog.posts.edit', ['id' => $post->id]))
            ->assertStatus(200);
    }

    public function testItShouldUpdatePost()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $post = Post::factory()->create();

        $data = [
            'id' => $post->id,
            'title' => $this->faker->word,
            'slug' => $this->faker->unique()->word,
            'content' => $this->faker->paragraph,
            'thumbnail' => 0
        ];

        $this->actingAs($user)
            ->post(route('panel.blog.posts.update'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('panel.blog.posts.edit', ['id' => $post->id]));
    }

    public function testItShouldDeletePost()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $post = Post::factory()->create();

        $this->actingAs($user)
            ->get(route('panel.blog.posts.delete', ['id' => $post->id]))
            ->assertStatus(302)
            ->assertRedirect(route('panel.blog.posts.index'));
    }
}
