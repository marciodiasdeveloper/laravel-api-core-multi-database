<?php

namespace Tests\Feature\Api\SignUp;

use App\Models\Tenant\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SignUpTest extends TestCase
{

    protected $endpoint = 'http://core.microservice.localhost:8000/api/signup';

    public function test_validations_failed_api_signup_store_not_send_password()
    {

        $attributes = [
            'step1' => [
                'personal' => [
                    'catalog' => [
                        'name' => 'Márcio Dias',
                        'phone' => [
                            'mobile' => '(37) 98417-1388',
                        ]
                    ],
                    'user' => [
                        'email' => 'marcio@marciodias.me',
                        'password' => '123456'
                    ],
                    'job' => '41b0d307-e4db-4716-86b9-5f03663e4657'
                ]
            ],
            'step2' => [
                'company' => [
                    'name' => '',
                    'phone' => '',
                    'occupation_area' => '',
                    'employees_number' => 1
                ]
            ],
            'step3' => [
                "c907489-bed4-4d25-be72-7f2a440a0846",
                "c907489-bed4-4d25-be72-7f2a440a0846"
            ],
            'step4' => [
                'domain' => 'marciodias'
            ],
            'step5' => [
                'method' => 'sms',
                'type' => 'personal'
            ]
        ];

        $response = $this->postJson($this->endpoint, $attributes);

        $response->dump();
        // $this->assertDatabaseHas('catalogs', $attributes);
        $response->assertStatus(500);
    }

    public function test_api_signup_store()
    {
        $response = $this->postJson($this->endpoint, [
            'catalog' => [
                'name' => 'Márcio Dias',
                'phone' => [
                    'mobile' => '3732128406'
                ]
            ],
            'user' => [
                'email' => 'eu@marciodias.me',
                'password' => '123456'
            ]
        ]);

        $response->dump();
        $response->assertStatus(200);
        $response->dd();
    }

    public function test_validations_failed_api_signup_store_email_already_exists()
    {

        $response = $this->postJson($this->endpoint, [
            'catalog' => [
                'name' => 'Márcio Dias',
                'phone' => [
                    'mobile' => '(37) 3212-8406'
                ]
            ],
            'user' => [
                'email' => 'eu@marciodias.me',
                'password' => '12321332144'
            ]
        ]);

        $response->dump();
        $response->assertStatus(500);
    }
}
