<?php

namespace App\Models\Customer\Verification;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Customer\Verification\Verification;

class VerificationSend extends Model
{
    use HasFactory;

    protected $table = 'customers_verifications_sends';
    protected $primaryKey = 'id';

    public function verification()
    {
        return $this->belongsTo(Verification::class, 'customer_verification_id');
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function createVerificationSend($customer_verification, $data)
    {
        $verification_send = new VerificationSend;
        $verification_send->customer_verification_id = $customer_verification->id;
        $verification_send->contact_value = $data['value'];
        $verification_send->secret_code = rand(100000, 999999);
        $verification_send->save();

        return $verification_send;
    }
}
