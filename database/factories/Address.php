<?php

namespace Database\Factories;

use Core\Models\Auth\Address as Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class Address extends Factory
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
        $shipping_details = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone' => $this->faker->e164PhoneNumber,
            'city' => $this->faker->city,
            'district' => $this->faker->state,
            'address' => $this->faker->address,
            'address_name' => $this->faker->word,
        ];

        $shipping_details = json_encode($shipping_details);

        $billing_details = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone' => $this->faker->e164PhoneNumber,
            'city' => $this->faker->city,
            'district' => $this->faker->state,
            'address' => $this->faker->address,
            'address_name' => $this->faker->word,
            'bill_type' => 'company',
            'company_name' => $this->faker->word,
            'company_tax_number' => $this->faker->numerify('########'),
            'company_tax_administration' => $this->faker->state,
            'e_bill_user' => true
        ];

        $billing_details = json_encode($billing_details);

        if (rand(1, 100) > 50) {
            return [
                'user_id' => 1,
                'details' => $shipping_details,
                'type' => 'shipping',
                'primary' => false
            ];
        }

        return [
            'user_id' => 1,
            'details' => $billing_details,
            'type' => 'billing',
            'primary' => false
        ];
    }
}
