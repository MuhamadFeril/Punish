<?php 

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class JenisPelanggaranRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kategori_id' => 'required|exists:table_category,id',
            'nama_pelanggaran' => 'required|string|max:255|unique:jenis_pelanggaran,nama_pelanggaran',
            'tingkat_pelanggaran' => 'required|in:ringan,sedang,berat',
            'deskripsi_pelanggaran' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'nama_pelanggaran.required' => 'Nama pelanggaran harus diisi.',
            'nama_pelanggaran.string' => 'Nama pelanggaran harus berupa teks.',
            'nama_pelanggaran.max' => 'Nama pelanggaran tidak boleh lebih dari 255 karakter.',
            'nama_pelanggaran.unique' => 'Nama pelanggaran sudah digunakan.',
            'tingkat_pelanggaran.required' => 'Tingkat pelanggaran harus dipilih.',
            'tingkat_pelanggaran.in' => 'Tingkat pelanggaran harus salah satu dari: ringan, sedang, berat.',
            'deskripsi_pelanggaran.string' => 'Deskripsi pelanggaran harus berupa teks.',
        ];
    }
}