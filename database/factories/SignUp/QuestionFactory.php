<?php

namespace Database\Factories\SignUp;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\SignUp\Question;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid(),
            'title' => $this->faker->title(),
            'status' => 'enabled',
        ];
    }
}
