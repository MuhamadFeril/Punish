<?php

namespace App\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartemenResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama_departemen' => $this->nama_departemen,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}