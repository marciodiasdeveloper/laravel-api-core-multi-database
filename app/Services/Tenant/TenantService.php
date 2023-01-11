<?php

namespace App\Services\Tenant;

use Illuminate\Support\Facades\Log;

use App\Models\Tenant\Tenant;
use App\Models\Tenant\Keycloak;
use App\Models\Tenant\Database;
use App\Tenant\Database\DatabaseManager;
use App\Services\Keycloak\KeycloakService;
use App\Services\Tenant\DatabaseService;

use App\Events\Tenant\TenantCreatedEvent;

class TenantService
{
    public function save($customer, $data)
    {

        try {
            if (!$tenant = app(Tenant::class)->createTenant($customer, $data)) {
                return false;
            }

            $database_values = [
                'type' => 'mysql',
                'db_host' => '127.0.0.1',
                'db_username' => 'root',
                'db_password' => 'root',
                'db_port' => '3336',
            ];

            if(!$database = app(Database::class)->createOrUpdate($tenant, $database_values)) {
                return false;
            }

            $tenant = Tenant::where('id', $tenant->id)->first();

            app(DatabaseManager::class)->createDatabase($tenant);

            if (!app(KeycloakService::class)->createRealm($tenant)) {
                return false;
            }

            if (!$client = app(KeycloakService::class)->createClient($tenant)) {
                return false;
            }

            if (isset($client['client_secret'])) {
                $keycloak = app(Keycloak::class)->createOrUpdate($tenant, $client);

                if (!$keycloak || app(KeycloakService::class)->createUser($data, $keycloak)) {
                    return false;
                }
            }
        } catch (\Exception $e) {
            Log::info('exception TenantService: '.json_encode($e->getMessage()));
            return false;
        }

        // Enviar e-mail para administradores do planeasy informando os dados do tenant do novo cliente.
        // event(new TenantCreatedEvent($tenant));

        return $tenant;
    }
}
