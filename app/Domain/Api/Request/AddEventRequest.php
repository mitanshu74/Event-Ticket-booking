<?php

namespace App\Domain\Api\Request;

// use App\Http\Requests\ApiRequest;
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
        ];
    }

    public function messages(): array
    {
        return [
            // Formats & types
            'date.after_or_equal'    => 'Event date must be today or a future date.',
            'end_time.after'         => 'End time must be after start time.',
            'total_tickets.integer'  => 'Total tickets must be an integer.',
            'total_tickets.min'      => 'Total tickets must be at least 1.',
            'price.numeric'          => 'Price must be a number.',
            'price.min'              => 'Price must be at least 1.',
        ];
    }
}
