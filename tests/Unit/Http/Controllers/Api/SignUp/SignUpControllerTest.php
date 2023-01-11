<?php

namespace Tests\Unit\Http\Controllers\Api;

use App\Models\Tenant\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Foundation\Testing\Mail;
use Illuminate\Support\Facades\Mail;

use Tests\TestCase;

use App\Services\Catalog\CatalogService;
use App\Services\Customer\CustomerService;
use App\Services\Tenant\TenantService;

use Mockery;
use Mockery\MockInterface;

class SignUpControllerTest extends TestCase
{

    protected $endpoint = 'http://core.microservice.localhost:8000/api/signup/check-email?email=eu@marciodias.me';

    private $catalogService;
    private $customerService;
    private $tenantService;


    public function test_signup_store()
    {

        // Mail::fake();
        // // content test
        // Mail::assertSent(SignUpMail::class, function($mail) {
            // return $mail->email === 'foo@bar.com.br'
        // });
        $this->assertTrue(true);
        // $attributes = [
        //     'step1' => [
        //         'personal' => [
        //             'catalog' => [
        //                 'name' => 'Márcio Dias',
        //                 'phone' => [
        //                     'mobile' => '(37) 98417-1388',
        //                 ]
        //             ],
        //             'user' => [
        //                 'email' => 'marcio@marciodias.me',
        //                 'password' => '123456'
        //             ],
        //             'job' => '41b0d307-e4db-4716-86b9-5f03663e4657'
        //         ]
        //     ],
        //     'step2' => [
        //         'company' => [
        //             'name' => '',
        //             'phone' => '',
        //             'occupation_area' => '',
        //             'employees_number' => 1
        //         ]
        //     ],
        //     'step3' => [
        //         "c907489-bed4-4d25-be72-7f2a440a0846",
        //         "c907489-bed4-4d25-be72-7f2a440a0846"
        //     ],
        //     'step4' => [
        //         'domain' => 'marciodias'
        //     ],
        //     'step5' => [
        //         'method' => 'sms',
        //         'type' => 'personal'
        //     ]
        // ];

        // // $spy = $this->spy(CustomerService::class);
        // // $spy->checkEmailExists($attributes['step1']['personal']['user']['email']);

        // // $a = $this->instance(
        // //     CustomerService::class,
        // //     Mockery::mock(CustomerService::class, function (MockInterface $mock) {
        // //         $mock->shouldReceive('process')->once();
        // //     })
        // // );

        // $a = $this->mock(CustomerService::class, function (MockInterface $mock) {
        //     $mock
        //         ->shouldReceive('execute')
        //         ->once()
        //         ->andReturn(true);
        // });

        // // dd($a);

        // // app(CreateOrderAction::class)->execute(/* ... */);

        // // dd($a);

        // // $mock = Mockery::spy(CustomerService::class)->checkEmailExists($attributes['step1']['personal']['user']['email']);
        // // // $mock->shouldReceive('findByCustomerId')->once();
        // // $this->app->instance(Organization::class, $mock);

        // // $customer_service = $this->prophesize(CustomerService::class);

        // // $customer_service->checkEmailExists($attributes['step1']['personal']['user']['email'])->willReturn(true);
        // // dd($customer_service);
        // // $customer_service->method('checkEmailExists')->will($this->returnArgument(0));

        // // // // Configure the stub.
        // // $customer_service->checkEmailExists($attributes['step1']['personal']['user']['email'])->willReturn(true);

        // // $this->assertEquals('true', $customer_service->checkEmailExists());

        // // // Calling $stub->doSomething() will now return
        // // // 'foo'.
        // // $this->assertEquals('foo', $catalog_service->doSomething());
    }
}
