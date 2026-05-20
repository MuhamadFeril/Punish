<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'type' => ['required', 'in:register,login'],
            // Jika register, butuh email. Jika login, mungkin pake token (auth()->user()) jadi email opsional, tapi amannya kita buat email required saat register.
            'email' => ['required_if:type,register', 'email'],
            'otp' => ['required', 'digits:6'],
        ];
    }
}
