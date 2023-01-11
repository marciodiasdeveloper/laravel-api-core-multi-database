<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckApiOnlineTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_api_online()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertExactJson([
            'message' => 'success',
        ]);
    }
}
