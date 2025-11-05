<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    public function rules()
    {
        $rules = [
            'name'                  => 'required|string|max:255',
            'date'                  => 'required|date|after_or_equal:today',
            'start_time'            => 'required|date_format:H:i',
            'end_time'              => 'required|date_format:H:i|after:start_time',
            'location'              => 'required|string|max:255',
            'price'                 => 'required|integer|min:1',
            'total_tickets'         => 'required|integer|min:1',
            'existing_images'       => 'nullable',
            'image'                 => 'nullable',
        ];

        if (empty(json_decode($this->input('existing_images', null)))) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:5120';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required'                   => 'Event name is required.',
            'date.required'                   => 'Event date is required.',
            'date.after_or_equal'             => 'Event date must be today or in the future.',
            'start_time.required'             => 'Start time is required.',
            'start_time.date_format'          => 'Start time must be in 24-hour format (HH:mm).',
            'end_time.required'               => 'End time is required.',
            'end_time.after'                  => 'End time must be after start time.',
            'location.required'               => 'Event location is required.',
            'price.required'                  => 'Event price is required.',
            'price.integer'                   => 'Price must be a number.',
            'price.min'                       => 'Price must be at least 1.',
            'total_tickets.required'          => 'Number of tickets is required.',
            'total_tickets.integer'           => 'Tickets must be a number.',
            'total_tickets.min'               => 'At least 1 ticket is required.',
            'image.required'                  => 'Please upload at least one event image.',
        ];
    }
}
