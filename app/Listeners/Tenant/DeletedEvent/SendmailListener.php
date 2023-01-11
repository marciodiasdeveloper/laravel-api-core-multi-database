<?php

namespace App\Listeners\Tenant\DeletedEvent;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\Tenant\TenantDeletedEvent;

class SendmailListener
{

    // private $database;

    /**
     * Create the event listener.
     *
     * @return void
     */
    // public function __construct(DatabaseManager $database)
    // {
    //     $this->database = $database;
    // }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(TenantDeletedEvent $event)
    {
    }
}
