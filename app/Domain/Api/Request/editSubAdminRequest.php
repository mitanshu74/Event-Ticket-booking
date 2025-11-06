<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\Http\FormRequest;

class EditSubAdminRequest extends FormRequest
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
            'email' => 'required|email|ends_with:gmail.com|unique:admins,email,' . $id . 'id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Please enter the name.',
            'email.required' => 'Please enter an email.',
            'email.ends_with'    => 'Only Gmail addresses are allowed.',
            'email.unique'   => 'This email is already taken.',
        ];
    }
}
