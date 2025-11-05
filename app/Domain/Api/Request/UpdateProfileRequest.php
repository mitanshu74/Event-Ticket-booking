<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    public function rules(): array
    {
        $adminId = Auth::guard('admin')->id();

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email|ends_with:gmail.com,' . $adminId,
            'password' => ['nullable', Password::min(6)->letters()->numbers()->symbols()],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'  => 'Please enter the name.',
            'email.required' => 'Please enter an email.',
            'email.ends_with'    => 'Only Gmail addresses are allowed.',
            'email.unique'   => 'This email is already taken.',
        ];
    }
}
