<?php 
namespace App\Resources;
use Illuminate\Http\Resources\Json\JsonResource;


class KaryawanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama_karyawan' => $this->nama_karyawan,
            'alamat_karyawan' => $this->alamat_karyawan,
            'departemen' => $this->departemen ? $this->departemen->nama_departemen : null,
            'email_karyawan' => $this->email_karyawan,
            'jabatan_karyawan' => $this->jabatan_karyawan,
            'status' => $this->status,
            'foto_karyawan' => $this->foto_karyawan ? asset('storage/' . $this->foto_karyawan) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}