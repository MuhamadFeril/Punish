<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CapctchaRule;

class SendOtpRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'captcha' => ['required', new CaptchaRule()],
        ];
    }
}
