<?php

namespace App\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class SanksiResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'pelanggaran' => $this->pelanggaran ? $this->pelanggaran->keterangan_pelanggaran : null,
            'jenis_sanksi' => $this->jenis_sanksi,
            'tanggal_sanksi' => $this->tanggal_sanksi,
            'keterangan_sanksi' => $this->keterangan_sanksi,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}