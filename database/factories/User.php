<?php

namespace Database\Factories;

use Core\Models\Auth\User as Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class User extends Factory
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
        $password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

        $role = 'customer';

        $random = rand(1, 100);

        if ($random < 20) {
            $role = 'admin';
        } else if ($random < 30) {
            $role = 'writer';
        } else if ($random < 60) {
            $role = 'order-tracker';
        } else {
            $role = 'customer';
        }

        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->e164PhoneNumber,
            'role' => $role,
            'activation_code' => md5('supersecret_string' . rand() . date('h:i:s.Y')),
            'email_verified_at' => now(),
            'password' => $password,
            'remember_token' => Str::random(10)
        ];
    }
}
