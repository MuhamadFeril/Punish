<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendGmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'to' => 'required|email',
            'subject' => 'required|string',
            'body' => 'required|string',
        ];
    }
}
