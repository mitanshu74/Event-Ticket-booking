<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddSubAdminRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    public function rules()
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admins,email|ends_with:gmail.com',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Name is required.',
            'email.required'    => 'Email is required.',
            'email.email'       => 'Please enter a valid email address.',
            'email.unique'      => 'This email is already registered.',
            'email.ends_with'       => 'Only Gmail addresses are allowed.',
        ];
    }
}
