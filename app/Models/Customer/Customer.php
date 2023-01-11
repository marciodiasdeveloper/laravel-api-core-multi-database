<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Catalog\CatalogDocument;
use App\Models\Catalog\Catalog;
use App\Models\Customer\Subscription;
use App\Models\Customer\Verification\Verification;
use App\Models\Customer\SignUp\Answer as CustomerSignUpAnswer;
use App\Models\Customer\SignUp\Job as CustomerSignUpJob;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $primaryKey = 'id';

    protected $fillable = ['uuid', 'email', 'observations', 'status'];

    public function catalog()
    {
        return $this->belongsTo(Catalog::class, 'catalog_id');
    }

    public function answers()
    {
        return $this->hasMany(CustomerSignUpAnswer::class, 'customer_id');
    }

    public function job()
    {
        return $this->hasOne(CustomerSignUpJob::class, 'customer_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'customer_id');
    }

    public function verifications()
    {
        return $this->hasMany(Verification::class, 'customer_id');
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function getOrNew($catalog, $data)
    {
        if (isset($data['uuid']) && $customer = Customer::where('uuid', $data['uuid'])->first()) {
            return $customer;
        } elseif ($customer = Customer::where('catalog_id', $catalog->id)->first()) {
            return $customer;
        } else {
            $customer = new Customer;
        }

        return $customer;
    }

    public function saveCustomer($catalog, $data)
    {
        $customer = app(Customer::class)->getOrNew($catalog, $data);
        $customer->catalog_id = $catalog->id;
        $customer->email = $data['email'];
        $customer->company_name = $data['company_name'];
        $customer->branch_name = $data['branch_name'];
        $customer->occupation_area = $data['occupation_area'];
        $customer->employees_number = $data['employees_number'];
        $customer->observations = isset($data['observations']) && $data['observations'] ? $data['observations'] : null;
        $customer->status = isset($data['status']) && $data['status'] ? $data['status'] : 'enabled';
        $customer->save();

        return $customer;
    }
}
