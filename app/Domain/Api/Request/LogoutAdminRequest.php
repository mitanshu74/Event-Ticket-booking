<?php

namespace App\Domain\Api\Request;

use App\Http\Requests\ApiRequest;

class LogoutAdminRequest extends ApiRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }
}
