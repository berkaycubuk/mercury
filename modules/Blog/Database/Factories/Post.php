<?php

namespace Blog\Database\Factories;

use Blog\Models\Post as Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class Post extends Factory
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
            'author' => 1,
        ];
    }
}
