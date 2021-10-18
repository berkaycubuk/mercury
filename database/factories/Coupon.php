<?php

namespace Database\Factories;

use Core\Models\Coupon as Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class Coupon extends Factory
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
            'code' => $this->faker->unique()->word,
            'description' => NULL,
            'discount_type' => 'fixed-cart',
            'discount' => 20,
            'expires_at' => $this->faker->dateTimeThisYear('+2 months')
        ];
    }
}
