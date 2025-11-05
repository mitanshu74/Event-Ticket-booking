<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BookingCancelRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    public function rules()
    {
        return [
            'booking_id' => 'exists:booking,id',
        ];
    }
}
