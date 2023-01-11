<?php

namespace Tests\Unit\Models\Module;

use App\Models\Module\Module;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_models_can_be_persisted()
    {
        $module = Module::factory()->create();
        $this->assertModelExists($module);
        $this->assertTrue(true);
    }
}
