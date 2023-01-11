<?php

namespace Database\Factories\Customer;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Customer\Customer;
use App\Models\Customer\Subscription;
use App\Models\Catalog\Catalog;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $customer = Customer::factory()->create();

        return [
            'uuid' => $this->faker->uuid(),
            'customer_id' => $customer->id,
            'type' => 'trial',
            'trial_ends_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'ends_at' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s'),
            'status' => 'enabled'
        ];
    }
}
