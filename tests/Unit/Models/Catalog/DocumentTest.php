<?php

namespace Tests\Unit\Models\Catalog;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Models\Catalog\Catalog;

use App\Models\Catalog\Document as CatalogDocument;

class DocumentTest extends TestCase
{
    use RefreshDatabase;

    const attributes = [
        'step1' => [
            'personal' => [
                'catalog' => [
                    'name' => 'Márcio Dias',
                    'phone' => [
                        'mobile' => '(37) 98417-1388',
                    ],
                    'documents' => [
                        'inscription' => '91762136171',
                        'company_name' => 'Planeasy Test',
                        'state_registration' => '',
                        'state_registration_abbreviation' => '',
                        'city_registration' => '',
                        'identity_document' => '',
                        'title_electoral' => '',
                    ]
                ],
                'user' => [
                    'email' => 'marcio@marciodias.me',
                    'password' => '123456'
                ],
            ]
        ],
    ];

    public function test_database_has_expected_columns()
    {
        $schema = Schema::hasColumns('catalogs_documents', [
            'id', 'uuid', 'type_entity', 'inscription', 'company_name', 'state_registration',
            'state_registration_abbreviation', 'city_registration', 'identity_document',
            'title_electoral', 'updated_at', 'created_at'
        ]);

        $this->assertTrue($schema, 1);
    }

    public function test_database_create_register()
    {
        $catalog_document = CatalogDocument::factory()->create();
        $this->assertModelExists($catalog_document);
    }

    public function test_model_missing()
    {
        $catalog_document = CatalogDocument::factory()->create();
        $catalog_document->delete();
        $this->assertModelMissing($catalog_document);
    }

    public function test_model_count()
    {
        CatalogDocument::factory()->create();
        $this->assertDatabaseCount('catalogs_documents', 1);
    }

    public function test_models_can_be_persisted()
    {
        CatalogDocument::factory()->count(6)->create();
        $this->assertDatabaseCount('catalogs_documents', 6);
    }

    public function test_model_method_save_document()
    {
        $catalog = Catalog::factory()->create();
        $this->assertModelExists($catalog);

        $save_catalog = app(CatalogDocument::class)->saveDocument($catalog, self::attributes['step1']['personal']['catalog']);
        $this->assertModelExists($save_catalog);
    }

    public function test_model_method_save_document_exists()
    {
        $catalog = Catalog::factory()->create();
        $this->assertModelExists($catalog);

        $catalog_document = CatalogDocument::factory()->create(['catalog_id' => $catalog->id, 'inscription' => '91762136171']);
        $this->assertModelExists($catalog_document);

        $save_catalog = app(CatalogDocument::class)->saveDocument($catalog, self::attributes['step1']['personal']['catalog']);
        $this->assertModelExists($save_catalog);
    }
}
