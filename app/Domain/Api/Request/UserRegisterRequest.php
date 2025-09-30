<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRegisterRequest  extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|regex:/@gmail\.com$/',
            'password' => [
                'required',
                Password::min(6)->letters()->numbers()->symbols() // ✅ Simple & Clean
            ],
            'number' => 'required|min:10',
            'address' => 'required|string',
            'gender' => 'required|in:male,female',
            'UserImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // matches form input
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'This email is already registered.',
            'email.regex' => 'Only Gmail addresses are allowed.',
            'UserImage.mimes' => 'Only JPG, JPEG, PNG, GIF formats are allowed.',
        ];
    }
}
