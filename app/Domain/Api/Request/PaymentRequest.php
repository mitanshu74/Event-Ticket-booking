<?php

namespace App\Domain\Api\Request;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
        ];
    }
}
