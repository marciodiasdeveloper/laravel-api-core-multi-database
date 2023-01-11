<?php

namespace App\Events\Customer;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Customer\Customer;

class SignUpEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function customer()
    {
        return $this->customer;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
