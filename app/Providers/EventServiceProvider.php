<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
// use Illuminate\Support\Facades\Event;
// use Illuminate\Auth\Events\Registered;
// use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

use App\Events\Customer\SignUpEvent;
use App\Events\Tenant\TenantCreatedEvent;
use App\Events\Tenant\TenantDeletedEvent;

use App\Listeners\Customer\SignUpEvent\SendmailListener as CustomerSignUpEventSendmailListener;
use App\Listeners\Customer\SignUpEvent\SendSmsListener as CustomerSignUpEventSendSmsListener;

use App\Listeners\Tenant\CreatedEvent\SendmailListener as TenantCreatedEventSendmailListener;
use App\Listeners\Tenant\DeletedEvent\SendmailListener as TenantDeletedEventSendmailListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Default Laravel events
        // Registered::class => [
        //     SendEmailVerificationNotification::class,
        // ],

        // Planeasy Events
        SignUpEvent::class => [
            CustomerSignUpEventSendSmsListener::class,
            CustomerSignUpEventSendmailListener::class,
        ],
        TenantCreatedEvent::class => [
            TenantCreatedEventSendmailListener::class,
        ],
        TenantDeletedEvent::class => [
            TenantDeletedEventSendmailListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
