<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class DepartemenRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama_departemen' => 'required|string|max:255|unique:departemens,nama_departemen',
        ];
    }

    public function messages()
    {
        return [
            'nama_departemen.required' => 'Nama departemen harus diisi.',
            'nama_departemen.string' => 'Nama departemen harus berupa teks.',
            'nama_departemen.max' => 'Nama departemen tidak boleh lebih dari 255 karakter.',
            'nama_departemen.unique' => 'Nama departemen sudah digunakan.',
        ];
    }
}