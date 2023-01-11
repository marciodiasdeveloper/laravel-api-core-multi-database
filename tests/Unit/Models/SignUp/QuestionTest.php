<?php

namespace Tests\Unit\Models\SignUp;

use Tests\TestCase;
use App\Models\SignUp\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SignUpTest extends TestCase
{
    use RefreshDatabase;

    public function test_models_can_be_persisted()
    {
        $module = Question::factory()->create();
        $this->assertModelExists($module);
    }
}
