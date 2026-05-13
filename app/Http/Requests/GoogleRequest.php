<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use ILluminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GoogleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'google_id' => 'required|string',
            'avatar' => 'nullable|url',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'google_id.required' => 'Google ID harus diisi.',
            'google_id.string' => 'Google ID harus berupa teks.',
            'avatar.url' => 'Avatar harus berupa URL yang valid.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $validator->errors()->first(),
        ], 422));
    }
}