<?php

namespace App\Http\Resources\Tenant;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
{
    // public function toArray($request)
    // {
    //     return parent::toArray($request);
    // }

    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'db_database' => $this->db_database,
            'db_host' => $this->db_host,
            'db_username' => $this->db_username,
            'db_password' => $this->db_password,
            'db_port' => $this->db_port,
            'status' => $this->status,
            'updated_at' => Carbon::make($this->updated_at)->format('d/m/Y H:i:s'),
            'created_at' => Carbon::make($this->created_at)->format('d/m/Y H:i:s')
        ];
    }

}
