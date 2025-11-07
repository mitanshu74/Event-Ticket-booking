<?php

namespace App\Domain\Admin\Request;

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
            'email'         => 'required|email|exists:admins,email',
            'password'      => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'The selected email is invalid. ',
        ];
    }
}
