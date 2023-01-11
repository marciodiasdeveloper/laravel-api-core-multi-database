<?php

namespace Tests\Unit\Models\Catalog;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Models\Catalog\Catalog;
use App\Models\Catalog\Phone;

use App\Models\Catalog\Phone as CatalogPhone;

class PhoneTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_has_expected_columns()
    {
        $schema = Schema::hasColumns('catalogs_phones', [
            'id', 'catalog_id', 'uuid', 'phone_type', 'phone_number'
        ]);

        $this->assertTrue($schema, 1);
    }

    public function test_belongs_to_a_catalog()
    {
        $catalog = Catalog::factory()->create();
        $this->assertModelExists($catalog);

        $phone = Phone::factory()->create(['catalog_id' => $catalog->id, 'phone_type' => 'personal', 'phone_number' => '(37) 98417-1388']);

        $this->assertNotNull($phone);
        $this->assertEquals(1, $phone->catalog->count());
        $this->assertInstanceOf(Catalog::class, $phone->catalog);
    }


    public function test_database_create_register()
    {
        $catalog_phone = CatalogPhone::factory()->create();
        $this->assertModelExists($catalog_phone);
    }

    public function test_model_missing()
    {
        $catalog_phone = CatalogPhone::factory()->create();
        $catalog_phone->delete();
        $this->assertModelMissing($catalog_phone);
    }

    public function test_model_count()
    {
        CatalogPhone::factory()->create();
        $this->assertDatabaseCount('catalogs_phones', 1);
    }

    public function test_models_can_be_persisted()
    {
        CatalogPhone::factory()->count(6)->create();
        $this->assertDatabaseCount('catalogs_phones', 6);
    }

    public function test_model_method_save_phone()
    {
        $catalog = Catalog::factory()->create();
        $this->assertModelExists($catalog);

        $data = [
            'phone_type' => 'personal',
            'phone_number' => '(37) 3212-8406'
        ];

        $phone = app(Phone::class)->savePhone($catalog, $data);
        $this->assertModelExists($phone);
    }
}
