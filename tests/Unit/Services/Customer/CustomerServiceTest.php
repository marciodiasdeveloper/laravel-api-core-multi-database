<?php

namespace Tests\Unit\Services\CustomerService;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\Models\Catalog\Catalog;
use App\Models\Customer\Customer;
use App\Services\Customer\CustomerService;


class CustomerServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_method_check_email_exists_and_new_email()
    {
        $email = 'foo@bar.com';

        $validated = app(CustomerService::class)->checkEmailExists($email);
        $this->assertFalse($validated);
    }

    public function test_method_check_email_exists_and_email_exists()
    {
        $customer = Customer::factory()->create();

        $validated = app(CustomerService::class)->checkEmailExists($customer->email);
        $this->assertTrue($validated);
    }

    public function test_save_customer()
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
            'type' => 'trial',
            'trial_ends_at' => '2022-01-01 10:20:20',
            'ends_at' => '2022-01-15 10:20:20',
            'uuid' => '12321'
        ];

        $customer = app(CustomerService::class)->save($catalog, $data);
        $this->assertNotNull($customer);
        $this->assertModelExists($customer);
    }
}
