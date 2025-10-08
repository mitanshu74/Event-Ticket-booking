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
            'EventImages.*' => 'image|mimes:jpeg,png,jpg,gif',
        ];
    }

    public function messages(): array
    {
        return [
            'end_time.after'        => 'End time must be after start time.',
            'start_time.date_format' => 'Start time must be a valid time.',
            'end_time.date_format'   => 'End time must be a valid time.',
        ];
    }
}
