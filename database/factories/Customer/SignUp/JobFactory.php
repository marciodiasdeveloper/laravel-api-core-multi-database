<?php

namespace Database\Factories\Customer\SignUp;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Customer\Customer;
use App\Models\Customer\SignUp\Job;
use App\Models\SignUp\Job as SignUpJob;

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
            'customer_id' => Customer::factory(),
            'signup_job_id' => SignUpJob::factory(),
        ];
    }
}
