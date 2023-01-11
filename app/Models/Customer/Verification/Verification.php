<?php

namespace App\Models\Customer\Verification;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Customer\Customer;
use App\Models\Customer\Verification\VerificationSend;

class Verification extends Model
{
    use HasFactory;

    protected $table = 'customers_verifications';
    protected $primaryKey = 'id';

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function sends()
    {
        return $this->hasMany(VerificationSend::class, 'customer_verification_id');
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function createVerification($customer, $data)
    {
        $verification = new Verification;
        $verification->customer_id = $customer->id;
        $verification->method = $data['method'];
        $verification->type = $data['type'];
        $verification->status = 'disabled';
        $verification->save();

        return $verification;
    }
}
