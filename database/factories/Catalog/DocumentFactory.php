<?php

namespace Database\Factories\Catalog;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Catalog\Catalog;
use App\Models\Catalog\Document as CatalogDocument;

class DocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CatalogDocument::class;

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
            'type_entity' => 'cpf',
            'inscription' => '',
            'company_name' => '',
            'state_registration' => '',
            'state_registration_abbreviation' => '',
            'city_registration' => '',
            'identity_document' => '',
            'title_electoral' => '',
        ];
    }
}
