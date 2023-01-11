<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Tenant\Tenant;

class Database extends Model
{
    use HasFactory;

    protected $table = 'tenants_databases';
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
        $model = Database::getOrNew($tenant->database);
        $model->tenant_id = $tenant->id;
        $model->type = $data['type'];
        $model->db_database = 'customers_' . str_pad($tenant->id, 4, '0', STR_PAD_LEFT);
        $model->db_host = $data['db_host'];
        $model->db_username = $data['db_username'];
        $model->db_password = $data['db_password'];
        $model->db_port = $data['db_port'];
        $model->save();

        return $model;
    }

    public static function getOrNew($database)
    {
        if (isset($database->uuid)) {
            if (!$model = $model = Database::where('uuid', $database->uuid)->first())
                $model = new Database;
        } else {
            $model = new Database;
        }

        return $model;
    }
}
