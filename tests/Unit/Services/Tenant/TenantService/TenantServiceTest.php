<?php

namespace Tests\Unit\Services\Tenant\TenantService;

use Tests\TestCase;

use App\Services\Tenant\TenantService;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

use App\Models\Customer\Customer;
use App\Models\Catalog\Catalog;
use App\Models\Tenant\Tenant;

use Mockery;
use Mockery\MockInterface;

class TenantServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_tenant_save_return_tenant_false()
    {
        $tenant = app(TenantService::class)->save([], []);
        $this->assertFalse($tenant);
    }

    public function test_tenant_save()
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

        $stub = $this->createMock(TenantService::class);
        $stub->method('save')->willReturn('foo');
        $this->assertEquals('foo', $stub->save($customer, []));

        $this->markTestIncomplete('This test has not been implemented yet.');

        // dd($stub->save($customer, []));

        // $mock = Mockery::mock(TenantService::class);

        // $mock = $this->mock(TenantService::class, function (MockInterface $mock) {
        //     $mock->shouldReceive('process')->once();
        // });

        // dd($mock->save($customer, []));

        // $tenant = app(TenantService::class)->save($customer, []);
        // $mock->shouldReceive('exists')->andReturn(true);
        // dd($mock->save($customer,[]));

        // $tenant = app(TenantService::class)->save($customer, []);

        // $spy = $this->spy(TenantService::class);
        // $spy->shouldHaveReceived('process');

        // Http::fake();

        // $response = app(KeycloakService::class)->createRealm($this->db_database);

        // Http::assertSent(function (Request $request): bool {
        //     return $request->url() == 'realm' && $request['keycloak_realm_id'] == $this->db_database;
        // });

        // $this->assertEquals(200, $response->status());

        // $mock = $this->mock(TenantService::class, function (MockInterface $mock) {
        //     $mock->shouldReceive('process')->once();
        // });

        // dd($mock);



        // $this->withoutExceptionHandling();


        //  // Arrange
        // $expected = 'does not matter it is a mock';
        // $statement = 'CREATE DATABASE planeasy CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci';

        // DB::shouldReceive('statement')->with($statement)->once()->andReturn($expected);

        // // Act
        // $actual = DB::statement($statement);

        // // Assert
        // $this->assertEquals($expected, $actual);

        // $tenant = app(TenantService::class)->save($customer, $data);

        // $tenant = app(Tenant::class)->createTenant($customer, []);
        // $this->assertModelExists($tenant);

        // $data = [
        //     'email' => 'contato@marciodias.me',
        //     'company_name' => 'Planeasy Test',
        //     'branch_name' => 'Planeasy Test',
        //     'occupation_area' => 'Administrador',
        //     'employees_number' => 1,
        //     'observations' => 'test observations',
        //     'status' => 'enabled',
        //     'type' => 'trial',
        //     'trial_ends_at' => '2022-01-01 10:20:20',
        //     'ends_at' => '2022-01-15 10:20:20',
        //     'uuid' => '12321'
        // ];

        // Http::fake();

        // // Http::assertSent(function (Request $request): bool {
        // //     return $request->url() == 'realm' && $request['keycloak_realm_id'] == $this->db_database;
        // // });

        // $tenant = app(TenantService::class)->save($customer, $data);

        // dd($tenant);
        // // $this->assertNotNull($tenant);
        // // $this->assertModelExists($tenant);

    }



}
