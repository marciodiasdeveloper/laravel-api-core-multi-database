<?php

namespace Tests\Feature\Api\SignUp;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;

class CheckEmailExistsTest extends TestCase
{
    use RefreshDatabase;

    protected $endpoint = '/signup/check-email?email=eu@marciodias.me';

    public function test_email_not_params()
    {
        $response = $this->get('/signup/check-email');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertExactJson([
            'error' => 'not_found_email_params',
        ]);
    }

    public function test_field_email_exists()
    {
        $response = $this->get('/signup/check-email?email=eu@marciodias.me');
        $response->assertStatus(401);
        $response->assertEquals('email_exists', $response['error']);
        $response->assertExactJson([
            'error' => 'email_exists',
        ]);
    }

    public function test_email_available()
    {
        $response = $this->get($this->endpoint);
        $response->assertEquals(true, $response['success']);
        $response->assertExactJson([
            'success' => true,
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }


    // /**
    //  * Test Auth user profile data
    //  *
    //  * @return void
    //  */
    // public function testProfileData()
    // {
    //     $user = factory(User::class)->create();

    //     $response = $this->actingAs($user, 'api')
    //         ->getJson('/api/profile');

    //     $response
    //         ->assertStatus(200)
    //         ->assertJson([
    //             'success' => true,
    //             'data' => true,
    //         ]);
    // }

    // /**
    //  * Test profile data without Auth
    //  *
    //  * @return void
    //  */
    // public function testProfileDataWithoutAuth()
    // {
    //     $user = factory(User::class)->create();

    //     $response = $this->getJson('/api/profile');

    //     $response->assertStatus(401);
    // }

    // /**
    //  * Test Update Profile Success
    //  *
    //  * @return void
    //  */
    // public function testUpdateProfile()
    // {
    //     $user = factory(User::class)->create();

    //     $response = $this->actingAs($user, 'api')
    //         ->putJson('/api/profile', ['email' => $this->faker->email, 'name' => $this->faker->name]);

    //     $response
    //         ->assertStatus(200)
    //         ->assertJson([
    //             'success' => true
    //         ]);
    // }

    // /**
    //  * Test Update Profile Validation Error
    //  *
    //  * @return void
    //  */
    // public function testUpdateProfileValidationError()
    // {
    //     $user = factory(User::class)->create();

    //     $response = $this->actingAs($user, 'api')
    //         ->putJson('/api/profile', ['name' => $this->faker->name]);

    //     $response->assertStatus(422);
    // }

    // /**
    //  * Test Change Password Success
    //  *
    //  * @return void
    //  */
    // public function testChangePassword()
    // {
    //     $user = factory(User::class)->create();

    //     $response = $this->actingAs($user, 'api')
    //         ->postJson('/api/change-password', [
    //             'current_password' => 123456,
    //             'new_password' => 123456789,
    //             'confirm_password' => 123456789
    //         ]);

    //     $response->assertStatus(200)
    //         ->assertJson([
    //             'success' => true,
    //             'message' => true
    //         ]);
    // }


    // /**
    //  * Test Change Password Validation Error
    //  *
    //  * @return void
    //  */
    // public function testChangePasswordValidationError()
    // {
    //     $user = factory(User::class)->create();

    //     $response = $this->actingAs($user, 'api')
    //         ->postJson('/api/change-password', ['current_password' => $this->faker->password]);

    //     $response->assertStatus(422);
    // }

}
