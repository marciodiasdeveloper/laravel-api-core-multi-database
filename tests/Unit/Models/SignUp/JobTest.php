<?php

namespace Tests\Unit\Models\SignUp;

use App\Models\SignUp\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JobTest extends TestCase
{
    use RefreshDatabase;

    public function test_models_can_be_persisted()
    {
        $module = Job::factory()->create();
        $this->assertModelExists($module);
    }
}
