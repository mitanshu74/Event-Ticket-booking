<?php

namespace App\Domain\Admin\Request;

use Illuminate\Foundation\Http\FormRequest;

class SubAdminRequest extends FormRequest
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
            'email' => 'required|email|unique:admins,email|ends_with:gmail.com,' . $id . 'id',
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
    public function persist()
    {
        return array_merge(($this->only('name', 'email')));
    }
}
