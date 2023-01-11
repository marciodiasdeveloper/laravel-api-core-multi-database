<?php

namespace Database\Factories\Catalog;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Catalog\Catalog;
use App\Models\Catalog\Phone as CatalogPhone;

class PhoneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CatalogPhone::class;

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
            'phone_type' => 'personal',
            'phone_number' => '(37) 3212-8406'
        ];
    }
}
