<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\Http\FormRequest;

// use Illuminate\Validation\Rules\Password;

class AddSubAdminRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->guard('admin')->check();
    }

    public function rules()
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => [
                'required',
                'email',
                'unique:admins,email',
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Name is required.',
            'email.required'    => 'Email is required.',
            'email.email'       => 'Please enter a valid email address.',
            'email.unique'      => 'This email is already registered.',
            'email.regex'       => 'Only Gmail addresses are allowed.',
        ];
    }
}
