<?php
namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class PelanggaranResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'karyawan' => $this->karyawan ? $this->karyawan->nama_karyawan : null,
            'jenis_pelanggaran' => $this->jenisPelanggaran ? $this->jenisPelanggaran->nama_pelanggaran : null,
            'tanggal_pelanggaran' => $this->tanggal_pelanggaran,
            'keterangan_pelanggaran' => $this->keterangan_pelanggaran,
            'bukti_pelanggaran' => $this->bukti_pelanggaran ? asset('storage/' . $this->bukti_pelanggaran) : null,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}