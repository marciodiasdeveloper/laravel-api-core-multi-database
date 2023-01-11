<?php

namespace Tests\Unit\Services\Catalog\CatalogService;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

use App\Services\Catalog\CatalogService;
use App\Models\Catalog\Catalog;
use App\Models\Catalog\CatalogPhone;


class CatalogServiceTest extends TestCase
{

    use RefreshDatabase;

    public function test_an_action_catalog_service()
    {

        $data = [
            'name' => 'Test Catalog',
            'nick_name' => 'Test Catalog',
            'phone' => [
                'phone_type' => 'personal',
                'phone_number' => '3732128406'
            ]
        ];

        $catalog = app(CatalogService::class)->save($data);
        $this->assertModelExists($catalog);
    }
}
