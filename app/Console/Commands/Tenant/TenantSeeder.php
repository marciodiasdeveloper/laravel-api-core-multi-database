<?php

namespace App\Console\Commands\Tenant;

use App\Models\Tenant\Tenant;
use App\Tenant\ManagerTenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TenantSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:seeder {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Seeder tenants';

    private $tenant;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ManagerTenant $tenant)
    {
        parent::__construct();

        $this->tenant = $tenant;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
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

        return 0;
    }

    public function execCommand(Tenant $tenant)
    {

        $this->tenant->setConnection($tenant);

        $this->info("Connecting Tenant {$tenant->name}.");

        $command = Artisan::call('db:seed', [
            '--class' => 'TenantsTableSeeder'
        ]);

        if ($command === 0) {
            $this->info("Sucesso, Tenant {$tenant->name}.");
        }

        $this->info("End Connecting Tenant {$tenant->name}.");
        $this->info("----------------------------------------");
    }
}
