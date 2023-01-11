<?php

namespace Database\Factories\Customer\SignUp;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Customer\SignUp\Answer;
use App\Models\Customer\Customer;
use App\Models\SignUp\Question;

class AnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Answer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'signup_question_id' => Question::factory(),
        ];
    }
}
