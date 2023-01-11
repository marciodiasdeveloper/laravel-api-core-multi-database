<?php

namespace Database\Factories\SignUp;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\SignUp\Job;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'status' => 'enabled',
        ];
    }
}
