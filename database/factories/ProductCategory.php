<?php

namespace Database\Factories;

use Core\Models\Product\ProductCategory as Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductCategory extends Factory
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
            'name' => $this->faker->city,
            'slug' => $this->faker->unique()->word
        ];
    }
}
