<?php

namespace Database\Factories\Tenant;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Tenant\Tenant;
use App\Models\Tenant\Domain;

class DomainFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Domain::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tenant_id' => Tenant::factory(),
            'uuid' => $this->faker->uuid(),
            'domain' => $this->faker->name(),
            'status' => 'enabled',
        ];
    }
}
