<?php

namespace App\Http\Resources\WorkAreas;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkAreaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
        ];
    }
}
