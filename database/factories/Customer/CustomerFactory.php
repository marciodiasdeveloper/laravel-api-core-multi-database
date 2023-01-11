<?php

namespace Database\Factories\Customer;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Customer\Customer;
use App\Models\Catalog\Catalog;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'catalog_id' => Catalog::factory(),
            'uuid' => $this->faker->uuid(),
            'email' => $this->faker->unique()->safeEmail(),
            'observations' => $this->faker->paragraph(),
            'status' => 'enabled'
        ];
    }
}
