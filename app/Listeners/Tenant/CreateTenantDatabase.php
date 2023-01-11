<?php

namespace App\Listeners\Tenant;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\Tenant\TenantCreatedEvent;
use App\Events\Tenant\DatabaseCreatedEvent;

use App\Tenant\Database\DatabaseManager;

class CreateTenantDatabase
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
    public function handle(TenantCreatedEvent $event)
    {
        $tenant = $event->tenant();

        if (!$this->database->createDatabase($tenant)) {
            throw new \Exception('Error create database.');
        }

        if (false) { // Verifica radio com permissão para criar banco de dados externo.
            event(new TenantCreatedEvent($tenant));
        } else {
            event(new DatabaseCreatedEvent($tenant));
        }
    }
}
