<?php

namespace Database\Factories\Tenant;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Tenant\Tenant;
use App\Models\Tenant\Keycloak;

class KeycloakFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Keycloak::class;

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
            'realm' => 'mysql',
            'client_id' => $this->faker->userName(),
            'client_secret' => $this->faker->uuid()
        ];
    }
}
