<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Set to true if all users can make this request
        return true;
    }

    public function rules(): array
    {
        return [
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'razorpay_payment_id.required' => 'Payment ID is required.',
            'razorpay_order_id.required' => 'Order ID is required.',
        ];
    }
}
