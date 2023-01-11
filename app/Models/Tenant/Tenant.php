<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Tenant\Domain;
use App\Models\Tenant\Keycloak;
use App\Models\Tenant\Database;
use App\Models\Customer\Customer;

class Tenant extends Model
{
    use HasFactory;

    protected $table = 'tenants';
    protected $primaryKey = 'id';
    protected $fillable = ['uuid', 'customer_id', 'status'];

    public function customer()
    {
        return $this->belongsTo(Customer::class,  'customer_id');
    }

    public function domains()
    {
        return $this->hasMany(Domain::class,  'tenant_id');
    }

    public function keycloak()
    {
        return $this->hasOne(Keycloak::class,  'tenant_id');
    }

    public function database()
    {
        return $this->hasOne(Database::class,  'tenant_id');
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function getOrNew($data)
    {
        if (isset($data['uuid']) && $model = Tenant::where('uuid', $data['uuid'])->first()) {
            return $model;
        } else {
            $model = new Tenant;
        }

        return $model;
    }

    public function createTenant($customer, $data)
    {

        if(isset($customer) && !isset($customer->id)) {
            return false;
        }

        $model = $this->getOrNew($data);
        $model->customer_id = $customer->id;
        $model->save();

        return $model;
    }

}
