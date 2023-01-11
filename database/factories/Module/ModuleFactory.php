<?php

namespace Database\Factories\Module;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Module\Module;
use App\Models\Catalog\Catalog;

class ModuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Module::class;

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
            'slug' => $this->faker->slug(),
            'icon' => 'default',
            'order' => 1,
            'summary' => $this->faker->text(),
            'description' => $this->faker->text(),
            'status' => 'enabled',
            'public' => 1,
            'editable' => 1,
            'removable' => 'enabled'
        ];
    }
}
