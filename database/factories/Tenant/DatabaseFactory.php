<?php

namespace Database\Factories\Tenant;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Tenant\Tenant;
use App\Models\Tenant\Database;

class DatabaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Database::class;

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
            'type' => 'mysql',
            'db_database' => $this->faker->username(),
            'db_host' => $this->faker->url(),
            'db_username' => $this->faker->username(),
            'db_password' => $this->faker->password(),
            'db_port' => 3306,
        ];
    }
}
