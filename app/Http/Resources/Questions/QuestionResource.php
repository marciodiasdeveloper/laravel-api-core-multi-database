<?php

namespace App\Http\Resources\Questions;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'title' => $this->title,
        ];
    }
}
