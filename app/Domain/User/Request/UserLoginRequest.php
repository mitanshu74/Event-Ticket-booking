<?php

namespace App\Domain\User\Request;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'         => 'required|email',
            'password'      => 'required|string',
        ];
    }
    public function persist()
    {
        return array_merge(($this->only('email', 'password')));
    }
}
