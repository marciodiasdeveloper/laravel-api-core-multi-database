<?php

namespace Tests\Feature\Api\Domain\Search;

use App\Models\Tenant\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckDomainExistsTest extends TestCase
{
    protected $endpoint = 'http://core.microservice.localhost:8000/api/signup/check-email?email=eu@marciodias.me';

    public function test_domain_not_params()
    {
        $response = $this->get($this->endpoint);
        $response->assertEquals('not_found_email_params', $response['error']);
        $response->assertStatus(404);
    }

    public function test_domain_exists()
    {
        $response = $this->get($this->endpoint . '&domain=marciodias');
        $response->assertEquals('email_exists', $response['error']);
        $response->assertStatus(401);
    }

    public function test_domain_not_exists()
    {
        $response = $this->get($this->endpoint);
        $response->assertEquals(true, $response['success']);
        $response->assertStatus(202);
    }
}
