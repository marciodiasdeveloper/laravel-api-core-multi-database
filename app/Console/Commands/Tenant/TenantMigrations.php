<?php

namespace App\Console\Commands\Tenant;

use App\Models\Tenant\Tenant;
use App\Tenant\ManagerTenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TenantMigrations extends Command
{

    protected $signature = 'tenants:migrations {id?} {--refresh}';
    protected $description = 'Run migrations tenants';
    private $tenant;

    public function __construct(ManagerTenant $tenant)
    {
        parent::__construct();

        $this->tenant = $tenant;
    }

    public function handle()
    {
        if ($tenant_id = $this->argument('id')) {
            if ($tenant = Tenant::find($tenant_id)) {
                $this->execCommand($tenant);
            }
            return;
        }

        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            $this->execCommand($tenant);
        }

        return;
    }

    public function execCommand(Tenant $tenant)
    {

        $command = $this->option('refresh') ? 'migrate:refresh' : 'migrate';

        $this->tenant->setConnection($tenant);

        $this->info("Connecting Tenant {$tenant->database->db_database}.");

        $run = Artisan::call($command, [
            '--force' => true,
            '--path' => '/database/migrations/tenant',
            '--database' => 'tenant'
        ]);

        if ($run === 0) {
            Artisan::call('db:seed', [
                '--class' => 'TenantsTableSeeder'
            ]);

            $this->info("Success, Tenant {$tenant->database->db_database}.");
        }

        $this->info("End Connecting Tenant {$tenant->database->db_database}.");
        $this->info("----------------------------------------");
    }
}
