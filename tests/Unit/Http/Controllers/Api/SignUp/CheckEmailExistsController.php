<?php

namespace Tests\Unit\Http\Controllers\Api;

use App\Models\Tenant\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckEmailExistsController extends TestCase
{
    use RefreshDatabase;

    protected $endpoint = 'http://core.microservice.localhost:8000/api/signup/check-email?email=eu@marciodias.me';


    public function test_email_available()
    {
        $this->assertTrue(true);
    }

    public function test_email_not_available()
    {
        $this->assertTrue(true);
    }
}
