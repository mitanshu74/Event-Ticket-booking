<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\Http\FormRequest;

class UserBookingRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'event_id'       => 'required|exists:events,id',
            'tickets_booked' => 'required|integer|min:1|max:5',
            'booking_type'   => 'required|in:online,',
        ];
    }

    public function messages()
    {
        return [
            'event_id.required'         => 'Please select an event.',
            'tickets_booked.required'   => 'Please enter number of tickets.',
            'tickets_booked.min'        => 'You must book at least 1 ticket.',
            'tickets_booked.max'        => 'You can book a maximum of 5 tickets.',
        ];
    }
}
