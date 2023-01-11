<?php

namespace Tests\Unit\Models\Tenant;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

use App\Models\Tenant\Domain;
use App\Models\Tenant\Tenant;
use App\Models\Catalog\Catalog;
use App\Models\Customer\Customer;

class DomainTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_has_expected_columns()
    {
        $schema = Schema::hasColumns('tenants_domains', [
            'id', 'tenant_id', 'uuid', 'domain', 'status'
        ]);

        $this->assertTrue($schema, 1);
    }

    public function test_database_create()
    {
        $domain = Domain::factory()->create();
        $this->assertModelExists($domain);
    }

    public function test_model_missing()
    {
        $domain = Domain::factory()->create();
        $domain->delete();
        $this->assertModelMissing($domain);
    }

    public function test_model_count()
    {
        Domain::factory()->create();
        $this->assertDatabaseCount('tenants_domains', 1);
    }

    public function test_models_can_be_persisted()
    {
        Domain::factory()->count(10)->create();
        $this->assertDatabaseCount('tenants_domains', 10);
    }

    public function test_model_belongs_to_tenant()
    {
        $domain = Domain::factory()->create();

        $this->assertModelExists($domain);
        $this->assertEquals(1, $domain->tenant->count());
        $this->assertInstanceOf(Tenant::class, $domain->tenant);
    }

    public function test_model_create_domain_not_send_domain_param()
    {
        $tenant = Tenant::factory()->create();
        $this->assertModelExists($tenant);

        $domain = app(Domain::class)->createOrUpdate($tenant, []);
        $this->assertFalse($domain);
    }

    public function test_model_create_domain_send_domain_not_send_uuid_param()
    {

        $tenant = Tenant::factory()->create();
        $this->assertModelExists($tenant);

        $data = [
            'domain' => 'foo.com'
        ];

        $domain = app(Domain::class)->createOrUpdate($tenant, $data);
        $this->assertModelExists($domain);
    }

    public function test_model_create_domain_send_domain_and_uuid_param()
    {
        $domain = Domain::factory()->create();
        $this->assertDatabaseCount('tenants', 1);

        $data = [
            'domain' => 'foo.com',
            'uuid' => $domain->uuid
        ];

        $domain = app(Domain::class)->createOrUpdate($domain->tenant, $data);
        $this->assertModelExists($domain);
    }

    public function test_model_create_domain_send_domain_and_tenant_differ_to_register()
    {
        $tenant = Tenant::factory()->create();
        $this->assertModelExists($tenant);

        $domain = Domain::factory()->create();
        $this->assertDatabaseCount('tenants_domains', 1);

        $data = [
            'domain' => $domain->domain
        ];

        $domain = app(Domain::class)->createOrUpdate($tenant, $data);
        $this->assertFalse($domain);
    }
}
