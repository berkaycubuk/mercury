<?php

namespace Database\Factories;

use Core\Models\Page as Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class Page extends Factory
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
            'title' => $this->faker->word,
            'slug' => $this->faker->unique()->word,
            'content' => $this->faker->paragraph
        ];
    }
}
