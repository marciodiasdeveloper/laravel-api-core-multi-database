<?php

namespace App\Models\Customer\SignUp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\Customer\Customer;
use App\Models\Customer\SignUp\Job as CustomerSignUpJob;
use App\Models\SignUp\Job as SignUpJob;

class Job extends Model
{
    use HasFactory;

    protected $table = 'customers_signup_jobs';
    protected $primaryKey = 'id';
    protected $fillable = ['uuid', 'customer_id', 'signup_job_id'];

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

    public function createCustomerSignUpJob($customer, $data)
    {

        if (!isset($customer) || !$customer) {
            return false;
        }

        if (!isset($data['signup_job_id'])) {
            return false;
        }

        if (!$signup_job = SignUpJob::where('id', $data['signup_job_id'])->first()) {
            return false;
        }

        if (!$customer_signup_job = CustomerSignUpJob::where([['customer_id', '=', $customer->id], ['signup_job_id', '=', $data['signup_job_id']]])->first()) {
            $customer_signup_job = new CustomerSignUpJob;
        }

        $customer_signup_job->customer_id = $customer->id;
        $customer_signup_job->signup_job_id = $signup_job->id;
        $customer_signup_job->save();

        return $customer_signup_job;
    }
}
