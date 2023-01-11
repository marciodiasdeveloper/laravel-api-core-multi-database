<?php

namespace Database\Factories\Catalog;

use App\Models\Catalog\Catalog;
use Illuminate\Database\Eloquent\Factories\Factory;

class CatalogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Catalog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName(),
            'nick_name' => $this->faker->unique()->safeEmail()
        ];
    }
}
