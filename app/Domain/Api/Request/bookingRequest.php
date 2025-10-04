<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\Http\FormRequest;

class bookingRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->guard('admin')->check();
    }

    public function rules()
    {
        return [
            'user_id'        => 'required|exists:users,id',
            'event_id'       => 'required|exists:events,id',
            'tickets_booked' => 'required|integer|min:1|max:5',
            'total_price'    => 'required|numeric|min:1',
            'booking_type'   => 'required|in:offline',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required'        => 'Please select a user.',
            'event_id.required'       => 'Please select an event.',
            'tickets_booked.required' => 'Please enter number of tickets.',
            'tickets_booked.integer'  => 'Tickets must be a valid number.',
            'tickets_booked.min'      => 'At least 1 ticket is required.',
            'tickets_booked.max'      => 'You can book a maximum of 5 tickets.',
        ];
    }
}
