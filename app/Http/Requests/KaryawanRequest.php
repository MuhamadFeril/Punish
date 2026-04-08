<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class KaryawanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->has('jabatan')) {
            $this->merge(['jabatan_karyawan' => $this->input('jabatan')]);
        }
    }

    public function rules()
    {
        return [
            'nama_karyawan' => 'required|string|max:255',
            'jabatan_karyawan' => 'required|string|max:255',
            'alamat_karyawan' => 'required|string|max:255',
            'email_karyawan' => 'required|email|unique:karyawan,email_karyawan',
            'departemen_id' => 'required|exists:departemens,id',
            'foto_karyawan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:aktif,non-aktif',
        ];
    }
    public function messages()
    {
        return [
            'nama_karyawan.required' => 'Nama karyawan harus diisi.',
            'jabatan_karyawan.required' => 'Jabatan karyawan harus diisi.',
            'alamat_karyawan.required' => 'Alamat karyawan harus diisi.',
            'email_karyawan.required' => 'Email karyawan harus diisi.',
            'email_karyawan.email' => 'Email karyawan harus berupa alamat email yang valid.',
            'email_karyawan.unique' => 'Email karyawan sudah digunakan.',
            'departemen_id.required' => 'Departemen harus dipilih.',
            'departemen_id.exists' => 'Departemen yang dipilih tidak valid.',   
        ];
    }
}