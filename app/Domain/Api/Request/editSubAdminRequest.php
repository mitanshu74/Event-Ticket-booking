<?php

namespace App\Domain\Api\Request;

use App\Http\Requests\ApiRequest;

class editSubAdminRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name'  => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'regex:/^[A-Za-z0-9._%+-]+@gmail\.com$/',
                'unique:admins,email,' . $id . ',id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Please enter the name.',
            'email.required' => 'Please enter an email.',
            'email.email'    => 'Please enter a valid email.',
            'email.unique'   => 'This email is already taken.',
        ];
    }
}
