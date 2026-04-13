<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JenisPelanggaranResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'kategori_id' => $this->kategori_id->$this->kategori ? $this->kategori->name : null,
            'nama_pelanggaran' => $this->nama_pelanggaran,
            'tingkat_pelanggaran' => $this->tingkat_pelanggaran,
            'deskripsi_pelanggaran' => $this->deskripsi_pelanggaran,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}