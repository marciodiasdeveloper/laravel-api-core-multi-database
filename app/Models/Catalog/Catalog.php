<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Catalog\Document as CatalogDocument;
use App\Models\Catalog\Phone as CatalogPhone;

class Catalog extends Model
{
    use HasFactory;

    protected $table = 'catalogs';
    protected $primaryKey = 'id';
    protected $fillable = ['uuid', 'name', 'nick_name'];

    public function documents()
    {
        return $this->hasMany(CatalogDocument::class, 'catalog_id');
    }

    public function phones()
    {
        return $this->hasMany(CatalogPhone::class, 'catalog_id');
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
        if (isset($data['uuid']) && $catalog = Catalog::where('uuid', $data['uuid'])->first()) {
            return $catalog;
        } elseif (isset($data['documents']['inscription']) && $catalog_document = CatalogDocument::where('inscription', $data['documents']['inscription'])->first()) {
            return $catalog_document->catalog;
        } else {
            $catalog = new Catalog;
        }

        return $catalog;
    }

    public function saveCatalog($data)
    {
        $this->name = $data['name'];

        if (isset($data['nick_name'])) {
            $this->nick_name = $data['nick_name'];
        }

        $this->save();

        return $this;
    }
}
