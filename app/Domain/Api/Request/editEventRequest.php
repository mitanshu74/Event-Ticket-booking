<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\Http\FormRequest;

class editEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only logged-in admin can add events
        return auth()->guard('admin')->check();
    }
    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'date'          => 'required|date|after_or_equal:today',
            'location'      => 'required|string|max:255',
            'price'         => 'required|integer|min:1',
            'total_tickets' => 'required|integer|min:1',
            'EventImage'    => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required'          => 'Event name is required.',
            'date.required'          => 'Event date is required.',
            'date.after_or_equal'    => 'Event date must be today or in the future.',
            'location.required'      => 'Event location is required.',
            'price.required'         => 'Event price is required.',
            'price.integer'          => 'Price must be a number.',
            'price.min'              => 'Price must be at least 1.',
            'total_tickets.required' => 'Number of tickets is required.',
            'total_tickets.integer'  => 'Number of tickets must be a number.',
            'total_tickets.min'      => 'There must be at least 1 ticket.',
            'EventImage.required'    => 'Please upload an image for the event.',
            'EventImage.image'       => 'The file must be an image.',
            'EventImage.mimes'       => 'Allowed image types: jpeg, png, jpg, gif.',
        ];
    }
}
