<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'otp' => 'required|numeric|digits:6',
        ];
    }

    public function messages()
    {
        return [
            'otp.required' => 'OTP is required.',
            'otp.numeric'  => 'OTP must be numeric.',
            'otp.digits'   => 'OTP must be exactly 6 digits.',
        ];
    }
}
