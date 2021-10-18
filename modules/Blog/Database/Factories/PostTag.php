<?php

namespace Blog\Database\Factories;

use Blog\Models\PostTag as Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostTag extends Factory
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
            'name' => $this->faker->word,
            'slug' => $this->faker->city
        ];
    }
}
