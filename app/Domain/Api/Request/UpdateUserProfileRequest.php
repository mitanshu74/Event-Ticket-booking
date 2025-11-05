<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UpdateUserProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = Auth::guard('web')->id();

        return [
            'username' => 'required|string|max:255',
            'email' => 'required|email|ends_with:gmail.com|unique:users,email,' . $userId,
            'password' => ['nullable', Password::min(6)->letters()->numbers()->symbols()],
            'number' => 'required|digits:10',
            'address' => 'required|string',
            'gender' => 'required|in:male,female',
            'UserImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Please enter your username.',
            'email.required' => 'Please enter your email.',
            'email.email' => 'Enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.letters' => 'Password must contain at least one letter.',
            'password.numbers' => 'Password must contain at least one number.',
            'password.symbols' => 'Password must contain at least one special character.',
            'number.required' => 'Please enter your phone number.',
            'number.digits'    => 'Mobile number must be exactly 10 digits.',
            'address.required' => 'Please enter your address.',
            'gender.required' => 'Please select your gender.',
            'gender.in' => 'Gender must be either male or female.',
            'UserImage.image' => 'The file must be an image.',
            'UserImage.mimes' => 'Allowed image formats: jpeg, png, jpg, gif.',
            'UserImage.max'    => 'Image size must not exceed 2 MB.',

        ];
    }
}
