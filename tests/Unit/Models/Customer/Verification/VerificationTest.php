<?php

namespace Tests\Unit\Models\Verification;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

use App\Models\Customer\Verification\Verification;
use App\Models\Customer\Verification\VerificationSend;
use App\Models\Customer\Customer;
use App\Models\Catalog\Catalog;

class VerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_has_expected_columns()
    {
        $schema = Schema::hasColumns('customers_verifications', [
            'id', 'uuid', 'customer_id', 'method', 'type', 'status'
        ]);

        $this->assertTrue($schema, 1);
    }

    public function test_database_create_register()
    {
        $verification = Verification::factory()->create();
        $this->assertModelExists($verification);
    }

    public function test_model_missing()
    {
        $verification = Verification::factory()->create();
        $verification->delete();
        $this->assertModelMissing($verification);
    }

    public function test_model_count()
    {
        Verification::factory()->create();
        $this->assertDatabaseCount('customers_verifications', 1);
    }

    public function test_models_can_be_persisted()
    {
        Verification::factory()->count(10)->create();
        $this->assertDatabaseCount('customers_verifications', 10);
    }

    public function test_model_belongs_to_customer()
    {
        $verification = Verification::factory()->create();

        $this->assertModelExists($verification);
        $this->assertEquals(1, $verification->customer->count());
        $this->assertInstanceOf(Customer::class, $verification->customer);
    }

    public function test_model_belogs_to_sends()
    {
        $verification = Verification::factory()->create();
        $this->assertModelExists($verification);

        $data = [
            'customer_verification_id' => $verification->id,
            'secret_code' => 45325,
        ];

        $verification_send = VerificationSend::factory()->create($data);
        $this->assertModelExists($verification_send);

        $this->assertModelExists($verification);
        $this->assertEquals(1, $verification->sends->count());
        $this->assertInstanceOf(VerificationSend::class, $verification->sends->first());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $verification->sends);

    }

    public function test_model_method_create_verification()
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

        $data = [
            'customer_id' => $customer->id,
            'method' => 'sms',
            'type' => 'personal',
            'status' => 'enabled'
        ];

        $verification = app(Verification::class)->createVerification($customer, $data);

        $this->assertModelExists($verification);

    }
}
