<?php

namespace App\Services\Keycloak;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Request;

class KeycloakService
{
    private $api_auth;

    public function __construct()
    {
        $this->api_auth = env('MICROSERVICES_API_AUTH');
    }

    public function createRealm($tenant)
    {
        try {
            $response = Http::post($this->api_auth . '/realm', [
                'keycloak_realm_id' => $tenant->database->db_database,
            ]);
            return $response;
        } catch (\Exception $th) {
            return false;
        }
    }

    public function createClient($tenant)
    {
        try {
            $response = Http::post($this->api_auth . '/client/' . $tenant->database->db_database, [
                'keycloak_client_id' => 'Planeasy-WEB',
            ]);

            return $response;
        } catch (\Exception $th) {
            return false;
        }
    }

    public function createUser($data, $keycloak)
    {
        try {
            $response = Http::post($this->api_auth . '/user/create/' . $keycloak->realm, [
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $data['password']
            ]);
            return $response;
        } catch (\Throwable $th) {
            return false;
        }
    }

    // public function updateRealm($tenant, $data)
    // {

    // }

    // public function deleteRealm($tenant)
    // {
    //     $response = Http::delete($this->api_auth . '/keycloak/realm', [
    //         'keycloak_realm_id' => $tenant->keycloak_realm_id,
    //     ]);

    //     return $response;
    // }

    // public function logoutAllRealm($tenant)
    // {
    //     $response = Http::post($this->api_auth . '/keycloak/users/logout', [
    //         'keycloak_realm_id' => $tenant->keycloak_realm_id,
    //     ]);

    //     return $response;
    // }

    // public function logoutUser($tenant, $user)
    // {
    //     $response = Http::post($this->api_auth . '/keycloak/realm/logout', [
    //         'keycloak_realm_id' => $tenant->keycloak_realm_id,
    //         'email' => $user->email
    //     ]);

    //     return $response;
    // }
}
