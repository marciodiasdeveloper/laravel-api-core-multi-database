<?php

namespace App\Models\SignUp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WorkArea extends Model
{
    use HasFactory;

    protected $table = 'signup_work_areas';
    protected $primaryKey = 'id';
    protected $fillable = ['uuid', 'name'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
}
