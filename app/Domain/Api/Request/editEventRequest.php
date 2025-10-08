<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class editEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only logged-in admin can add events
        return Auth::guard('admin')->check();
    }
    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'date'          => 'required|date|after_or_equal:today',
            'start_time'    => 'required|date_format:H:i',
            'end_time'      => 'required|date_format:H:i|after:start_time',
            'location'      => 'required|string|max:255',
            'price'         => 'required|integer|min:1',
            'total_tickets' => 'required|integer|min:1',
            'EventImages'    => 'nullable|array',
            'EventImages.*'  => 'image|mimes:jpeg,png,jpg,gif',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required'           => 'Event name is required.',
            'date.required'           => 'Event date is required.',
            'date.after_or_equal'     => 'Event date must be today or in the future.',
            'start_time.required'     => 'Start time is required.',
            'start_time.date_format'  => 'Start time must be in 24-hour format (HH:mm).',
            'end_time.required'       => 'End time is required.',
            'end_time.after'          => 'End time must be after start time.',
            'location.required'       => 'Event location is required.',
            'price.required'          => 'Event price is required.',
            'price.integer'           => 'Price must be a number.',
            'price.min'               => 'Price must be at least 1.',
            'total_tickets.required'  => 'Number of tickets is required.',
            'total_tickets.integer'   => 'Tickets must be a number.',
            'total_tickets.min'       => 'At least 1 ticket is required.',
            'EventImages.*.image'     => 'Each file must be an image.',
            'EventImages.*.mimes'     => 'Allowed types: jpeg, png, jpg, gif.',
        ];
    }
}
