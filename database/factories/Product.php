<?php

namespace Database\Factories;

use Core\Models\Product\Product as Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class Product extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->city,
            'slug' => $this->faker->unique()->word,
            'description' => $this->faker->paragraph,
            'short_description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(1, 20, 30),
            'product_category_id' => 1,
            'subcategory_id' => 1,
            'meta' => [
                'available_branches' => [],
                'online_orderable' => true
            ],
        ];
    }
}
