<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddEventRequest extends FormRequest
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
            'total_tickets' => 'required|integer|min:1',
            'price'         => 'required|integer|min:1',
            'EventImages'    => 'required|array|min:1|max:5',
            'EventImages.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // max 5MB
        ];
    }

    public function messages(): array
    {
        return [
            'EventImages.required'        => 'Please upload at least one image.',
            'EventImages.array'           => 'Invalid images upload.',
            'EventImages.max'             => 'You may upload up to 5 images.',
            'EventImages.*.image'         => 'Each file must be an image.',
            'EventImages.*.mimes'         => 'Only jpeg, png, jpg and gif formats are allowed.',
            'EventImages.*.max'           => 'Each image must not be larger than 5MB.',
            'end_time.after'              => 'End time must be after start time.',
            'start_time.date_format'      => 'Start time must be a valid time.',
            'end_time.date_format'        => 'End time must be a valid time.',
        ];
    }
}
