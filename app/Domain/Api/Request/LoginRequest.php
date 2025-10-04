<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'Selected email is not registered.',
        ];
    }
}
