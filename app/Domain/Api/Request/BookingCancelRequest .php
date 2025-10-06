<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BookingCancelRequest extends FormRequest
{
    public function authorize()
    {
        // Only allow logged-in admin
        return Auth::guard('admin')->check();
    }

    public function rules()
    {
        return [
            // This is optional because we get ID from route
            'booking_id' => 'sometimes|exists:booking,id',
        ];
    }
}
