<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

use App\Models\Tenant\Tenant;

class Keycloak extends Model
{
    use HasFactory;

    protected $table = 'tenants_keycloaks';
    protected $primaryKey = 'id';

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
        if (!$keycloak = Keycloak::where('tenant_id', $tenant->id)->first()) {
            $keycloak = new Keycloak;
        }

        $keycloak->tenant_id = $tenant->id;
        $keycloak->realm = $data['realm'];
        $keycloak->client_id = $data['client_id'];
        $keycloak->client_secret = $data['client_secret'];
        $keycloak->save();

        return $keycloak;
    }
}
