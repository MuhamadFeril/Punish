<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class SanksiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pelanggaran_id' => 'required|exists:pelanggaran,id',
            'jenis_sanksi' => 'required|in:peringatan,SP1,SP2,denda,skorsing,pemecatan',
            'tanggal_sanksi' => 'required|date',
            'keterangan_sanksi' => 'nullable|string',
        ];
    }
    public function messages()
    {
        return [
            'pelanggaran_id.required' => 'Pelanggaran harus dipilih.',
            'pelanggaran_id.exists' => 'Pelanggaran yang dipilih tidak valid.',
            'jenis_sanksi.required' => 'Jenis sanksi harus dipilih.',
            'jenis_sanksi.in' => 'Jenis sanksi harus salah satu dari: peringatan, SP1, SP2, denda, skorsing, pemecatan.',
            'tanggal_sanksi.required' => 'Tanggal sanksi harus diisi.',
            'tanggal_sanksi.date' => 'Tanggal sanksi harus berupa tanggal yang valid.',
            'keterangan_sanksi.string' => 'Keterangan sanksi harus berupa teks.',
        ];
    }
}