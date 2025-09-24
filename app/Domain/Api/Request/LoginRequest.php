<?php

namespace App\Domain\Api\Request;

use App\Http\Requests\ApiRequest;

class LoginRequest extends ApiRequest
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
