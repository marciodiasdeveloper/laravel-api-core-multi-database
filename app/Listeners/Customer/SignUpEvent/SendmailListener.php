<?php

namespace App\Listeners\Customer\SignUpEvent;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\Customer\SignUpEvent;

use App\Jobs\Customer\SignUp\SendmailJob;

class SendmailListener
{
    public function handle(SignUpEvent $event)
    {
        SendmailJob::dispatch($event->customer->email)->onConnection('database')->onQueue('queue_mail');
    }
}
