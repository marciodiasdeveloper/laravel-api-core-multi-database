<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Catalog\Catalog;

class Document extends Model
{
    use HasFactory;

    protected $table = 'catalogs_documents';
    protected $primaryKey = 'id';

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

    public function saveDocument($catalog, $data)
    {

        $catalog_document = Document::where([
            ['catalog_id', '=', $catalog->id],
            ['inscription', '=', $data['documents']['inscription']]
        ])->first();

        if (!$catalog_document) {
            $catalog_document = new Document;
            $catalog_document->catalog_id = $catalog->id;
        }

        $catalog_document->inscription = $data['documents']['inscription'];
        $catalog_document->company_name = $data['documents']['company_name'];
        $catalog_document->state_registration = $data['documents']['state_registration'];
        $catalog_document->state_registration_abbreviation = $data['documents']['state_registration_abbreviation'];
        $catalog_document->city_registration = $data['documents']['city_registration'];
        $catalog_document->identity_document = $data['documents']['identity_document'];
        $catalog_document->title_electoral = $data['documents']['title_electoral'];
        $catalog_document->save();

        return $catalog_document;
    }
}
