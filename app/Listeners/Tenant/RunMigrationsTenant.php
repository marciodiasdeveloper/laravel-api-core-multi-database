<?php

namespace App\Listeners\Tenant;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;

use App\Events\Tenant\DatabaseCreatedEvent;

use App\Tenant\Database\DatabaseManager;

class RunMigrationsTenant
{

    private $database;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(DatabaseManager $database)
    {
        $this->database = $database;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(DatabaseCreatedEvent $event)
    {

        $tenant = $event->tenant();

        $migration = Artisan::call('tenants:migrations', [
            'id' => $tenant->id,
        ]);

        // if($migration === 0) {
        //     Artisan::call('db:seed',[
        //         '--class' => 'TenantsTableSeeder'
        //     ]);
        // }

        return $migration === 0;
    }
}
