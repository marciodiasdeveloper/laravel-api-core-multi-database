<?php

namespace Tests\Unit\Models\Verification;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

use App\Models\Customer\Verification\Verification;
use App\Models\Customer\Verification\VerificationSend;
use App\Models\Customer\Customer;
use App\Models\Catalog\Catalog;

class VerificationSendTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_has_expected_columns()
    {
        $schema = Schema::hasColumns('customers_verifications_sends', [
            'id', 'uuid', 'customer_verification_id', 'secret_code', 'contact_value',
        ]);

        $this->assertTrue($schema, 1);
    }

    public function test_database_create_register()
    {
        $verificationSend = VerificationSend::factory()->create();
        $this->assertModelExists($verificationSend);
    }

    public function test_model_missing()
    {
        $verificationSend = VerificationSend::factory()->create();
        $verificationSend->delete();
        $this->assertModelMissing($verificationSend);
    }

    public function test_model_count()
    {
        VerificationSend::factory()->create();
        $this->assertDatabaseCount('customers_verifications_sends', 1);
    }

    public function test_models_can_be_persisted()
    {
        VerificationSend::factory()->count(10)->create();
        $this->assertDatabaseCount('customers_verifications_sends', 10);
    }

    public function test_model_belongs_to_verification()
    {
        $verification_send = VerificationSend::factory()->create();

        $this->assertModelExists($verification_send);
        $this->assertEquals(1, $verification_send->verification->count());
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

        $customer_verification = app(Verification::class)->createVerification($customer, $data);

        $this->assertModelExists($customer_verification);

        $data = [
            'value' => '3732128406'
        ];

        $verification_send = app(VerificationSend::class)->createVerificationSend($customer_verification, $data);

        $this->assertModelExists($verification_send);
    }
}
