<?php

namespace App\Domain\Admin\Request;

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
            'ids.*' => 'integer|exists:bookings,id',
        ];
    }

    public function messages(): array
    {
        return [
            'ids.required' => 'No bookings selected.',
        ];
    }
}
