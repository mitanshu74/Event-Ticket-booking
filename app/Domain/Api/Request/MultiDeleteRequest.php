<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\http\FormRequest;

class MultiDeleteRequest  extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:bookings,id', // validate each id
        ];
    }

    public function messages(): array
    {
        return [
            'ids.required' => 'No bookings selected.',
            'ids.array'    => 'Invalid data format.',
            'ids.*.exists' => 'One or more booking IDs are invalid.',
        ];
    }
}
