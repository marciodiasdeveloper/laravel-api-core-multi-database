<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\Customer\Customer;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'customers_subscriptions';
    protected $primaryKey = 'id';

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function createTrialSubscription($customer, $data)
    {
        $customer_subscription = new Subscription;
        $customer_subscription->customer_id = $customer->id;
        $customer_subscription->type = $data['type'];
        $customer_subscription->trial_ends_at = $data['trial_ends_at'];
        $customer_subscription->ends_at = $data['ends_at'];
        $customer_subscription->status = $customer_subscription->status ? $customer_subscription->status : 'enabled';
        $customer_subscription->save();

        return $customer_subscription;
    }
}
