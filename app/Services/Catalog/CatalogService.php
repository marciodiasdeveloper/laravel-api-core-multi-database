<?php

namespace App\Services\Catalog;

use App\Models\Catalog\Catalog;
use App\Models\Catalog\Phone as CatalogPhone;

class CatalogService
{
    private $catalog;

    public function __construct(Catalog $catalog)
    {
        $this->catalog = $catalog;
    }

    public function save($data)
    {

        $catalog = $this->catalog->getOrNew($data);
        $catalog->saveCatalog($data);

        // app(CatalogPhone::class)->savePhone($catalog, $data['phone']);
        // $catalog->documents->saveDocument($catalog, $data);

        return $catalog;
    }
}
