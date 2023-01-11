<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

use App\Models\Catalog\Catalog;
use App\Models\SignUp\Question;
use App\Models\Customer\Customer;
use App\Models\Customer\Subscription;
use App\Models\Customer\Verification\Verification;
use App\Models\Customer\SignUp\Answer;
use App\Models\Customer\SignUp\Job as CustomerSignUpJob;
use App\Models\SignUp\Job;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_has_expected_columns()
    {
        $schema = Schema::hasColumns('customers', [
            'id', 'uuid', 'catalog_id', 'email', 'branch_name', 'company_name', 'occupation_area',
            'employees_number', 'observations', 'status', 'updated_at', 'created_at'
        ]);

        $this->assertTrue($schema, 1);
    }

    public function test_database_create_register()
    {
        $customer = Customer::factory()->create();
        $this->assertModelExists($customer);
    }

    public function test_model_missing()
    {
        $customer = Customer::factory()->create();
        $customer->delete();
        $this->assertModelMissing($customer);
    }

    public function test_model_count()
    {
        Customer::factory()->create();
        $this->assertDatabaseCount('customers', 1);
    }

    public function test_models_can_be_persisted()
    {
        Customer::factory()->count(10)->create();
        $this->assertDatabaseCount('customers', 10);
    }

    public function test_model_belongs_to_catalog()
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
    }


    public function test_model_has_many_to_answers()
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

        $signup_question = Question::factory()->create();

        $data = [
            'customer_id' => $customer->id,
            'signup_question_id' => $signup_question->id,
        ];

        $answer = Answer::factory()->create($data);
        $this->assertModelExists($answer);
        $this->assertEquals(1, $customer->answers->count());
    }

    public function test_model_has_one_to_job()
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
        $this->assertInstanceOf(CustomerSignUpJob::class, $customer->job);
    }

    public function test_model_has_many_to_subscriptions()
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

        $data_subscription = [
            'customer_id' => $customer->id,
            'type' => 'trial',
            'trial_ends_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'ends_at' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s'),
            'status' => 'enabled',
        ];

        $subscription = Subscription::factory()->create($data_subscription);
        $this->assertModelExists($subscription);
        $this->assertEquals(1, $customer->subscriptions->count());
    }

    public function test_model_has_many_to_verifications()
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

        $data_verifications = [
            'customer_id' => $customer->id,
            'method' => 'sms',
            'type' => 'personal',
            'status' => 'disabled'
        ];

        $verification = Verification::factory()->create($data_verifications);
        $this->assertModelExists($verification);
        $this->assertEquals(1, $customer->verifications->count());
    }

    public function test_model_method_get_or_new_customer_not_exists()
    {
        $catalog = Catalog::factory()->create();
        $this->assertModelExists($catalog);

        $data = [];

        $data_method = app(Customer::class)->getOrNew($catalog, $data);

        $this->assertNotNull($data_method);
    }

    public function test_model_method_get_or_new_customer_exists()
    {
        $customer = Customer::factory()->create();
        $this->assertModelExists($customer);

        $data = [];

        $data_method = app(Customer::class)->getOrNew($customer->catalog, $data);

        $this->assertNotNull($data_method);
    }

    public function test_model_method_get_or_new_customer_send_data()
    {
        $customer = Customer::factory()->create();
        $this->assertModelExists($customer);

        $data = [
            'uuid' => $customer->uuid
        ];

        $data_method = app(Customer::class)->getOrNew($customer->catalog, $data);

        $this->assertNotNull($data_method);
    }

    public function test_model_method_get_or_new()
    {
        $catalog = Catalog::factory()->create();
        $this->assertModelExists($catalog);

        $data = [
            'email' => 'contato@marciodias.me',
            'company_name' => 'Planeasy Test',
            'branch_name' => 'Planeasy Test',
            'occupation_area' => 'Administrador',
            'employees_number' => 1,
            'observations' => 'test observations',
            'status' => 'enabled',
        ];

        $tableName = app(Customer::class)->getTable();

        $data_method = app(Customer::class)->getOrNew($catalog, $data);
        $this->assertNotNull($data_method);
        $this->assertEquals(new Customer, $data_method);
        $this->assertEquals($tableName, $data_method->getTable());
    }

    public function test_model_method_save_customer_new()
    {
        $catalog = Catalog::factory()->create();
        $this->assertModelExists($catalog);

        $data = [
            'email' => 'contato@marciodias.me',
            'company_name' => 'Planeasy Test',
            'branch_name' => 'Planeasy Test',
            'occupation_area' => 'Administrador',
            'employees_number' => 1,
            'observations' => 'test observations',
            'status' => 'enabled',
        ];

        $save_customer = app(Customer::class)->saveCustomer($catalog, $data);
        $this->assertNotNull($save_customer);
        $this->assertEquals($data['email'], $save_customer->email);
    }
}
