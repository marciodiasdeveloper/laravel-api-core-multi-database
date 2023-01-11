<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Catalog\Catalog;

class Phone extends Model
{
    use HasFactory;

    protected $table = 'catalogs_phones';
    protected $primaryKey = 'id';

    protected $fillable = ['uuid', 'phone_type', 'phone_number'];


    public function catalog()
    {
        return $this->belongsTo(Catalog::class, 'catalog_id');
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function savePhone($catalog, $data)
    {
        $catalog_phone = Phone::where([
            ['catalog_id', '=', $catalog->id],
        ])->first();

        if (!$catalog_phone) {
            $catalog_phone = new Phone;
            $catalog_phone->catalog_id = $catalog->id;
        }

        $catalog_phone->phone_type = $data['phone_type'];
        $catalog_phone->phone_number = $data['phone_number'];
        $catalog_phone->save();

        return $catalog_phone;
    }
}
