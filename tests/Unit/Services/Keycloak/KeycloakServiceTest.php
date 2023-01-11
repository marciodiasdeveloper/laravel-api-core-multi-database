<?php

namespace Tests\Unit\Services\Keycloak;

use Tests\TestCase;
use Illuminate\Http\Client\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

use App\Services\Keycloak\KeycloakService;
use App\Models\Tenant\Keycloak;
use App\Models\Tenant\Database;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Promise\RejectedPromise;

class KeycloakServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $db_database;
    protected $keycloak_realm;

    public function constructor()
    {
        $this->db_database = null;
        $this->keycloak_realm = null;
    }

    public function test_method_create_realm()
    {

        $database = Database::factory()->create();
        $this->assertModelExists($database);

        $this->db_database = $database->db_database;

        Http::fake();

        $response = app(KeycloakService::class)->createRealm($database->tenant);

        Http::assertSent(function (Request $request): bool {
            return $request->url() == 'realm' && $request['keycloak_realm_id'] == $this->db_database;
        });

        $this->assertEquals(200, $response->status());
    }

    public function test_method_create_realm_force_exception()
    {

        $database = Database::factory()->create();
        $this->assertModelExists($database);

        $this->db_database = $database->db_database;

        Http::fake([
            env('MICROSERVICES_API_AUTH').'/realm' => fn ($request) => new RejectedPromise(new ConnectException('Connection error', $request)),
        ]);

        $response = app(KeycloakService::class)->createRealm($database->tenant);

        $this->assertFalse($response);
    }

    public function test_method_create_client()
    {
        $database = Database::factory()->create();
        $this->assertModelExists($database);

        $this->db_database = $database->db_database;

        Http::fake();

        $response = app(KeycloakService::class)->createClient($database->tenant);

        Http::assertSent(function (Request $request): bool {
            return $request->url() == 'client/'.$this->db_database && $request['keycloak_client_id'] == 'Planeasy-WEB';
        });

        $this->assertEquals(200, $response->status());
    }

    public function test_method_create_client_force_exception()
    {
        $database = Database::factory()->create();
        $this->assertModelExists($database);

        $this->db_database = $database->db_database;

        Http::fake([
            env('MICROSERVICES_API_AUTH').'/client' => fn ($request) => new RejectedPromise(new ConnectException('Connection error', $request)),
        ]);

        $response = app(KeycloakService::class)->createClient($database->tenant);

        $this->assertFalse($response);
    }

    public function test_method_create_user()
    {
        $keycloak = Keycloak::factory()->create();
        $this->assertModelExists($keycloak);

        $this->keycloak_realm = $keycloak->realm;

        $data = [
            'name' => 'Foo bar',
            'username' => 'foobar',
            'email' => 'foo@bar.com.br',
            'password' => '123456'
        ];

        Http::fake();

        $response = app(KeycloakService::class)->createUser($data, $keycloak);

        Http::assertSent(function (Request $request): bool {
            return $request->url() == 'user/create/'.$this->keycloak_realm
            && $request['name'] == 'Foo bar'
            && $request['username'] == 'foobar'
            && $request['email'] == 'foo@bar.com.br'
            && $request['password'] == '123456';
        });

        $this->assertEquals(200, $response->status());
    }

    public function test_method_create_user_force_exception()
    {
        $keycloak = Keycloak::factory()->create();
        $this->assertModelExists($keycloak);

        $this->keycloak_realm = $keycloak->realm;

        $data = [
            'name' => 'Foo bar',
            'username' => 'foobar',
            'email' => 'foo@bar.com.br',
            'password' => '123456'
        ];

        Http::fake([
            'user/create/'.$this->keycloak_realm => fn ($request) => new RejectedPromise(new ConnectException('Connection error', $request)),
        ]);

        $response = app(KeycloakService::class)->createUser($data, $keycloak);

        $this->assertFalse($response);
    }

}
