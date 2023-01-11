<?php

namespace Tests\Unit\Models\Catalog;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

use App\Models\Catalog\Catalog;
use App\Models\Catalog\Document;
use App\Models\Catalog\Phone;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    const attributes = [
        'step1' => [
            'personal' => [
                'catalog' => [
                    'name' => 'Márcio Dias',
                    'phone' => [
                        'mobile' => '(37) 98417-1388',
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
        $schema = Schema::hasColumns('catalogs', [
            'id', 'uuid', 'name', 'nick_name', 'updated_at', 'created_at'
        ]);

        $this->assertTrue($schema, 1);
    }

    public function test_database_create_register()
    {
        $catalog = Catalog::factory()->create();
        $this->assertModelExists($catalog);
    }

    public function test_model_missing()
    {
        $catalog = Catalog::factory()->create();
        $catalog->delete();
        $this->assertModelMissing($catalog);
    }

    public function test_model_count()
    {
        Catalog::factory()->create();
        $this->assertDatabaseCount('catalogs', 1);
    }

    public function test_models_can_be_persisted()
    {
        Catalog::factory()->count(6)->create();
        $this->assertDatabaseCount('catalogs', 6);
    }

    public function test_model_has_many_to_documents()
    {
        $catalog = Catalog::factory()->create();
        $this->assertModelExists($catalog);

        $document = Document::factory()->create(['catalog_id' => $catalog->id]);
        $this->assertTrue($catalog->documents->contains($document));
        $this->assertEquals(1, $catalog->documents->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $catalog->documents);
    }

    public function test_model_has_one_to_phones()
    {
        $catalog = Catalog::factory()->create();
        $this->assertModelExists($catalog);

        Phone::factory()->create(['catalog_id' => $catalog->id]);
        $this->assertEquals(1, $catalog->phones->count());
    }

    public function test_model_method_get_or_new_user_not_exists()
    {
        $data_method = app(Catalog::class)->getOrNew(self::attributes);
        $tableName = app(Catalog::class)->getTable();

        $this->assertNotNull($data_method);
        $this->assertEquals(new Catalog, $data_method);
        $this->assertEquals($tableName, $data_method->getTable());
    }

    public function test_model_method_get_or_new_user_exists_data_uuid_send()
    {

        $catalog = Catalog::factory()->create();
        $this->assertModelExists($catalog);

        $data = [
            'uuid' => $catalog->uuid
        ];

        $data_method = app(Catalog::class)->getOrNew($data);

        $this->assertNotNull($data_method);
        $this->assertModelExists($data_method);
        $this->assertArrayHasKey('uuid', $data_method);
    }

    public function test_model_method_get_or_new_user_exists_data_document_inscription_send()
    {
        $catalog = Catalog::factory()->create();
        $this->assertModelExists($catalog);

        $document = Document::factory()->create(['catalog_id' => $catalog->id, 'inscription' => '514.940.120-06']);
        $this->assertTrue($catalog->documents->contains($document));
        $this->assertEquals(1, $catalog->documents->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $catalog->documents);

        $data = [
            'documents' => [
                'inscription' => $document->inscription
            ]
        ];

        $data_method = app(Catalog::class)->getOrNew($data);

        $this->assertNotNull($data_method);
        $this->assertModelExists($data_method);
        $this->assertArrayHasKey('uuid', $data_method);
    }

    public function test_model_method_save_catalog()
    {
        $data = [
            'name' => 'Márcio Dias',
            'nick_name' => 'Márcio Dias Developer'
        ];

        $catalog = app(Catalog::class)->saveCatalog($data);
        $this->assertModelExists($catalog);
    }
}
