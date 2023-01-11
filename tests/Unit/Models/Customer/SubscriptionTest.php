<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

use App\Models\Customer\Subscription;
use App\Models\Catalog\Catalog;
use App\Models\Customer\Customer;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_has_expected_columns()
    {
        $schema = Schema::hasColumns('customers_subscriptions', [
            'id', 'uuid', 'customer_id', 'type', 'trial_ends_at', 'ends_at', 'status'
        ]);

        $this->assertTrue($schema, 1);
    }

    public function test_database_create_register()
    {
        $subscription = Subscription::factory()->create();
        $this->assertModelExists($subscription);
    }

    public function test_model_missing()
    {
        $subscription = Subscription::factory()->create();
        $subscription->delete();
        $this->assertModelMissing($subscription);
    }

    public function test_model_count()
    {
        Subscription::factory()->create();
        $this->assertDatabaseCount('customers_subscriptions', 1);
    }

    public function test_models_can_be_persisted()
    {
        Subscription::factory()->count(10)->create();
        $this->assertDatabaseCount('customers_subscriptions', 10);
    }

    public function test_model_belongs_to_customer()
    {
        $subscription = Subscription::factory()->create();

        $this->assertModelExists($subscription);
        $this->assertEquals(1, $subscription->customer->count());
        $this->assertInstanceOf(Customer::class, $subscription->customer);
    }

    public function test_model_method_create_subscription()
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
            'type' => 'trial',
            'trial_ends_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'ends_at' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s'),
            'status' => 'enabled',
        ];

        $subscription = app(Subscription::class)->createTrialSubscription($customer, $data);

        $this->assertModelExists($subscription);
    }
}
