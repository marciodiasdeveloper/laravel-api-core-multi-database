<?php

namespace Tests\Unit\Models\Tenant;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

use App\Models\Tenant\Tenant;
use App\Models\Tenant\Keycloak;
use App\Models\Tenant\Database;
use App\Models\Tenant\Domain;
use App\Models\Catalog\Catalog;
use App\Models\Customer\Customer;

class TenantTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_has_expected_columns()
    {
        $schema = Schema::hasColumns('tenants', [
            'id', 'uuid', 'customer_id', 'status'
        ]);

        $this->assertTrue($schema, 1);
    }

    public function test_database_create_register()
    {
        $tenant = Tenant::factory()->create();
        $this->assertModelExists($tenant);
    }


    public function test_model_missing()
    {
        $tenant = Tenant::factory()->create();
        $tenant->delete();
        $this->assertModelMissing($tenant);
    }

    public function test_model_count()
    {
        Tenant::factory()->create();
        $this->assertDatabaseCount('tenants', 1);
    }

    public function test_models_can_be_persisted()
    {
        Tenant::factory()->count(10)->create();
        $this->assertDatabaseCount('tenants', 10);
    }

    public function test_model_belongs_to_customer()
    {
        $tenant = Tenant::factory()->create();

        $this->assertModelExists($tenant);
        $this->assertEquals(1, $tenant->customer->count());
        $this->assertInstanceOf(Customer::class, $tenant->customer);
    }

    public function test_model_has_one_keycloak()
    {
        $tenant = Tenant::factory()->create();
        $this->assertModelExists($tenant);

        $data = [
            'realm' => 'realm',
            'client_id' => 'client_id',
            'client_secret' => 'client_secret'
        ];

        app(Keycloak::class)->createOrUpdate($tenant, $data);
        $this->assertModelExists($tenant);
        $this->assertInstanceOf(Keycloak::class, $tenant->keycloak);
    }

    public function test_model_has_one_database()
    {
        $database = Database::factory()->create();
        $this->assertModelExists($database);
        $this->assertInstanceOf(Database::class, $database->tenant->database);
    }

    public function test_model_has_many_to_domains()
    {

        $tenant = Tenant::factory()->create();

        $this->assertModelExists($tenant);
        $this->assertEquals(1, $tenant->customer->count());
        $this->assertInstanceOf(Customer::class, $tenant->customer);

        $data = [
            'tenant_id' => $tenant->id,
            'domain' => 'foo.com',
            'status' => 'enabled'
        ];

        $domain = Domain::factory()->create($data);
        $this->assertModelExists($domain);
        $this->assertEquals(1, $tenant->domains->count());
    }

    public function test_model_create_tenant()
    {
        $catalog = Catalog::factory()->create();
        $this->assertModelExists($catalog);

        $data = [
            'catalog_id' => $catalog->id,
            'email' => 'test@planeasy.com.br',
            'branch_name' => 'Planeasy Test',
            'company_name' => 'Planeasy Test',
            'occupation_area' => 'Administrador',
            'employees_number' => 1,
            'observations' => 'Observações',
            'status' => 'enabled'
        ];

        $customer = Customer::factory()->create($data);
        $this->assertModelExists($customer);

        $tenant = app(Tenant::class)->createTenant($customer, []);
        $this->assertModelExists($tenant);

    }

    public function test_model_create_tenant_uuid_send()
    {
        $catalog = Catalog::factory()->create();
        $this->assertModelExists($catalog);

        $data = [
            'catalog_id' => $catalog->id,
            'email' => 'test@planeasy.com.br',
            'branch_name' => 'Planeasy Test',
            'company_name' => 'Planeasy Test',
            'occupation_area' => 'Administrador',
            'employees_number' => 1,
            'observations' => 'Observações',
            'status' => 'enabled'
        ];

        $customer = Customer::factory()->create($data);
        $this->assertModelExists($customer);

        $tenant = app(Tenant::class)->createTenant($customer, []);
        $this->assertModelExists($tenant);

        $data = [
            'uuid' => $tenant->uuid
        ];

        $tenant = app(Tenant::class)->createTenant($customer, $data);
        $this->assertModelExists($tenant);

    }
}
