<?php

namespace App\Listeners\Customer\SignUpEvent;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\Customer\SignUpEvent;

use \App\Services\Sms\SmsService;

class SendSmsListener
{
    public function handle(SignUpEvent $event)
    {
        app(SmsService::class)->send('37984171388', 'testando');
    }
}
