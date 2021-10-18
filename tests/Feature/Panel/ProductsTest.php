<?php

namespace Tests\Feature\Panel;

use Core\Models\Auth\User;
use Core\Models\Product\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use WithFaker;

    public function testItShouldSeeProductsPage()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $response = $this->actingAs($user)
            ->get(route('panel.products.products.index'));

        $response->assertStatus(200);
    }

    public function testItShouldCreateProduct()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $data = [
            'title' => $this->faker->unique()->word,
            'short_description' => $this->faker->paragraph,
            'description' => $this->faker->paragraph,
            'image' => 0,
            'price' => 20,
        ];

        $this->actingAs($user)
            ->post(route('panel.products.products.store'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('panel.products.products.index'));
    }

    public function testItShouldUpdateProduct()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $product = Product::factory()->create();

        $data = [
            'id' => $product->id,
            'title' => $this->faker->unique()->word,
            'short_description' => $this->faker->paragraph,
            'description' => $this->faker->paragraph,
            'image' => 0,
            'price' => 20,
        ];

        $this->actingAs($user)
            ->post(route('panel.products.products.update'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('panel.products.products.edit', ['id' => $product->id]));
    }

    public function testItShouldDeleteProduct()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $product = Product::factory()->create();

        $this->actingAs($user)
            ->get(route('panel.products.products.delete', ['id' => $product->id]))
            ->assertStatus(302)
            ->assertRedirect(route('panel.products.products.index'));
    }

    public function testItShouldSeeProductCategoriesPage()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $response = $this->actingAs($user)
            ->get(route('panel.products.categories.index'));

        $response->assertStatus(200);
    }

    public function testItShouldSeeProductSubcategoriesPage()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $response = $this->actingAs($user)
            ->get(route('panel.products.subcategories.index'));

        $response->assertStatus(200);
    }

    public function testItShouldSeeProductAttributesPage()
    {
        $user = User::factory()->create();
        $user->role = 'admin';

        $response = $this->actingAs($user)
            ->get(route('panel.products.attributes.index'));

        $response->assertStatus(200);
    }
}
