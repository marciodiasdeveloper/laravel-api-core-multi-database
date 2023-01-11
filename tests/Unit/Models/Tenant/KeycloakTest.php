<?php

namespace Tests\Unit\Models\Tenant;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Models\Tenant\Tenant;
use App\Models\Tenant\Keycloak;
use Illuminate\Foundation\Testing\WithFaker;

class KeycloakTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_has_expected_columns()
    {
        $schema = Schema::hasColumns('tenants_keycloaks', [
            'id', 'tenant_id', 'uuid', 'realm', 'client_id', 'client_secret'
        ]);

        $this->assertTrue($schema, 1);
    }

    public function test_database_create()
    {
        $keycloak = Keycloak::factory()->create();
        $this->assertModelExists($keycloak);
    }

    public function test_model_missing()
    {
        $keycloak = Keycloak::factory()->create();
        $keycloak->delete();
        $this->assertModelMissing($keycloak);
    }

    public function test_model_count()
    {
        Keycloak::factory()->create();
        $this->assertDatabaseCount('tenants_keycloaks', 1);
    }

    public function test_models_can_be_persisted()
    {
        Keycloak::factory()->count(10)->create();
        $this->assertDatabaseCount('tenants_keycloaks', 10);
    }

    public function test_model_belongs_to_tenant()
    {
        $keycloak = Keycloak::factory()->create();

        $this->assertModelExists($keycloak);
        $this->assertEquals(1, $keycloak->tenant->count());
        $this->assertInstanceOf(Tenant::class, $keycloak->tenant);
    }

    public function test_model_create_or_update_keycloak()
    {
        $tenant = Tenant::factory()->create();
        $this->assertModelExists($tenant);

        $data = [
            'realm' => 'realm',
            'client_id' => 'client_id',
            'client_secret' => 'secret'
        ];

        $keycloak = app(Keycloak::class)->createOrUpdate($tenant, $data);
        $this->assertModelExists($keycloak);
    }
}
