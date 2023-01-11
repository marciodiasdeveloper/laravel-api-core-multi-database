<?php

namespace Database\Factories\Customer\Verification;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Customer\Verification\VerificationSend;
use App\Models\Customer\Verification\Verification;

class VerificationSendFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VerificationSend::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid(),
            'customer_verification_id' => Verification::factory(),
            'secret_code' => 74568,
            'contact_value' => '3732128406'
        ];
    }
}
