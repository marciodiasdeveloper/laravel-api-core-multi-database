<?php

namespace Tests\Unit\Models\SignUp;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

use App\Models\Customer\SignUp\Job as CustomerSignUpJob;
use App\Models\Customer\Customer;
use App\Models\Catalog\Catalog;
use App\Models\SignUp\Job;

class CustomerSignUpJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_has_expected_columns()
    {
        $schema = Schema::hasColumns('customers_signup_jobs', [
            'id', 'uuid', 'customer_id', 'signup_job_id'
        ]);

        $this->assertTrue($schema, 1);
    }

    public function test_database_create_register()
    {
        $customer_signup_job = CustomerSignUpJob::factory()->create();
        $this->assertModelExists($customer_signup_job);
    }

    public function test_model_missing()
    {
        $customer_signup_job = CustomerSignUpJob::factory()->create();
        $customer_signup_job->delete();
        $this->assertModelMissing($customer_signup_job);
    }

    public function test_model_count()
    {
        CustomerSignUpJob::factory()->create();
        $this->assertDatabaseCount('customers_signup_jobs', 1);
    }

    public function test_models_can_be_persisted()
    {
        CustomerSignUpJob::factory()->count(10)->create();
        $this->assertDatabaseCount('customers_signup_jobs', 10);
    }

    public function test_model_belongs_to_customer()
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
        $this->assertEquals(1, $customer->catalog->count());
        $this->assertInstanceOf(Catalog::class, $customer->catalog);

        $signup_job = Job::factory()->create();

        $customer_signup_job = CustomerSignUpJob::factory()->create([
            'customer_id' => $customer->id,
            'signup_job_id' => $signup_job->id,
        ]);

        $this->assertModelExists($customer_signup_job);
        $this->assertEquals(1, $customer_signup_job->customer->count());
        $this->assertInstanceOf(Customer::class, $customer_signup_job->customer);
    }

    public function test_model_method_create_customer_signup_job_not_send_customer()
    {
        $customer = false;

        $customer_signup_job = app(CustomerSignUpJob::class)->createCustomerSignUpJob($customer, null);

        $this->assertFalse($customer_signup_job);
    }

    public function test_model_method_create_customer_signup_job_not_send_signup_job_id()
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
        $this->assertEquals(1, $customer->catalog->count());
        $this->assertInstanceOf(Catalog::class, $customer->catalog);

        $data = ['customer_id' => $customer->id];

        $customer_signup_job = app(CustomerSignUpJob::class)->createCustomerSignUpJob($customer, $data);

        $this->assertFalse($customer_signup_job);
    }

    public function test_model_method_create_customer_signup_job_not_send_signup_job_id_invalid()
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
        $this->assertEquals(1, $customer->catalog->count());
        $this->assertInstanceOf(Catalog::class, $customer->catalog);

        $data = ['customer_id' => $customer->id, 'signup_job_id' => 123456];

        $customer_signup_job = app(CustomerSignUpJob::class)->createCustomerSignUpJob($customer, $data);

        $this->assertFalse($customer_signup_job);
    }


    public function test_model_method_create_customer_signup_job()
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
        $this->assertEquals(1, $customer->catalog->count());
        $this->assertInstanceOf(Catalog::class, $customer->catalog);

        $signup_job = Job::factory()->create();

        $data = [
            'customer_id' => $customer->id,
            'signup_job_id' => $signup_job->id,
        ];

        $customer_signup_job = app(CustomerSignUpJob::class)->createCustomerSignUpJob($customer, $data);

        $this->assertModelExists($customer_signup_job);
        $this->assertInstanceOf(CustomerSignUpJob::class, $customer_signup_job);
    }
}
