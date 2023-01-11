<?php

namespace Tests\Unit\Models\Tenant;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

use App\Models\Tenant\Tenant;
use App\Models\Tenant\Database;

class DatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_has_expected_columns()
    {
        $schema = Schema::hasColumns('tenants_databases', [
            'id', 'tenant_id', 'uuid', 'type', 'db_database', 'db_host', 'db_username', 'db_password', 'db_port'
        ]);

        $this->assertTrue($schema, 1);
    }

    public function test_database_create()
    {
        $database = Database::factory()->create();
        $this->assertModelExists($database);
    }

    public function test_model_missing()
    {
        $database = Database::factory()->create();
        $database->delete();
        $this->assertModelMissing($database);
    }

    public function test_model_count()
    {
        Database::factory()->create();
        $this->assertDatabaseCount('tenants_databases', 1);
    }

    public function test_models_can_be_persisted()
    {
        Database::factory()->count(10)->create();
        $this->assertDatabaseCount('tenants_databases', 10);
    }

    public function test_model_belongs_to_tenant()
    {
        $database = Database::factory()->create();

        $this->assertModelExists($database);
        $this->assertEquals(1, $database->tenant->count());
        $this->assertInstanceOf(Tenant::class, $database->tenant);
    }

    public function test_model_get_or_new_database_exists()
    {
        $database = Database::factory()->create();
        app(Database::class)->getOrNew($database);
        $this->assertModelExists($database);
    }

    public function test_model_get_or_new_database_not_exists()
    {
        $tenant = Tenant::factory()->create();
        $database = app(Database::class)->getOrNew($tenant->database);
        $this->assertInstanceOf(Database::class, $database);
    }

    public function test_model_create_or_update()
    {
        $tenant = Tenant::factory()->create();

        $data = [
            'type' => 'mysql',
            'db_database' => 'customer_001',
            'db_host' => 'localhost',
            'db_username' => 'user135',
            'db_password' => 'a9du4jn()',
            'db_port' => '3306',
        ];

        $database = app(Database::class)->createOrUpdate($tenant, $data);
        $this->assertInstanceOf(Database::class, $database);
    }
}
