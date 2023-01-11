<?php

namespace Tests\Unit\Models\SignUp;

use App\Models\SignUp\WorkArea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkAreaTest extends TestCase
{
    use RefreshDatabase;

    public function test_models_can_be_persisted()
    {
        $module = WorkArea::factory()->create();
        $this->assertModelExists($module);
    }
}
