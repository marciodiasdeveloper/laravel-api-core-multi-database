<?php

namespace Database\Factories\Customer\Verification;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Customer\Customer;
use App\Models\Customer\Verification\Verification;

class VerificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Verification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $customer = Customer::factory()->create();

        return [
            'customer_id' => $customer->id,
            'uuid' => $this->faker->uuid(),
            'method' => 'sms',
            'type' => 'personal',
            'status' => 'disabled'
        ];
    }
}
