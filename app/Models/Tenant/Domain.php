<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Tenant\Tenant;

class Domain extends Model
{
    use HasFactory;

    protected $table = 'tenants_domains';
    protected $primaryKey = 'id';
    protected $fillable = ['uuid', 'tenant_id', 'domain', 'status'];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class,  'tenant_id');
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function createOrUpdate($tenant, $data)
    {

        if(!isset($data['domain'])) {
            return false;
        }

        if(!isset($data['uuid'])) {
            $model = new Domain;
        }

        $domain_check = Domain::where('domain', $data['domain'])->first();

        if($domain_check && $domain_check->tenant_id !== $tenant->id) {
            return false;
        }

        if(isset($data['uuid']) && !$model = Domain::where([['domain', '=', $data['domain']],['tenant_id', '=', $tenant->id],['uuid', '=', $data['uuid']]])->first()) {
            $model = new Domain;
        }

        $domain = Str::of($data['domain'])->slug('-');

        $model->tenant_id = $tenant->id;
        $model->domain = $domain;
        $model->status = isset($data['status']) ? $data['status'] : ($model->status ? $model->status : 'enabled');
        $model->save();

        return $model;
    }

}
