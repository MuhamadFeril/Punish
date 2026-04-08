<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class PelanggaranRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->has('deskripsi_pelanggaran')) {
            $this->merge(['keterangan_pelanggaran' => $this->input('deskripsi_pelanggaran')]);
        }
    }

    public function rules()
    {
        return [
            'karyawan_id' => 'required|exists:karyawan,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'tanggal_pelanggaran' => 'required|date',
            'keterangan_pelanggaran' => 'nullable|string',
            'bukti_pelanggaran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }
}