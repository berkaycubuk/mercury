<?php

namespace Database\Factories\Product;

use Core\Models\Product\Subcategory as Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class Subcategory extends Factory
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
            'slug' => $this->faker->unique()->word,
            'product_category_id' => 1
        ];
    }
}
