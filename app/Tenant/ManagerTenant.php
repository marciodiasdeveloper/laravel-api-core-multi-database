<?php

namespace App\Tenant;

use App\Models\Tenant\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ManagerTenant
{

    public function setConnection(Tenant $tenant)
    {

        DB::purge('tenant');

        config()->set('database.connections.tenant.host', $tenant->database->db_host);
        config()->set('database.connections.tenant.database', $tenant->database->db_database);
        config()->set('database.connections.tenant.username', $tenant->database->db_username);
        config()->set('database.connections.tenant.password', $tenant->database->db_password);
        config()->set('database.connections.tenant.port', $tenant->database->db_port);

        DB::reconnect('tenant');

        Schema::connection('tenant')->getConnection()->reconnect();
    }

    public function domainIsMain()
    {
        return request()->getHost() === config('tenant.domain_main');
    }

    public function destroyTenant(Tenant $tenant)
    {
        try {
            app(DatabaseManager::class)->dropDatabase($tenant);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return true;
    }
}
