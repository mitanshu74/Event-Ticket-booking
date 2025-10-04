<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only logged-in admin can update profile
        return Auth::guard('admin')->check();
    }

    public function rules(): array
    {
        $adminId = Auth::guard('admin')->id();

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $adminId,
            'password' => ['nullable', Password::min(6)->letters()->numbers()->symbols()],
        ];
    }
}
