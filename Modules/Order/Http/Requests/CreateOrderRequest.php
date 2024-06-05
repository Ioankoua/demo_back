<?php

namespace Modules\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'lastname' => 'required|string',
            'phone' => 'required|string',
            'product' => 'required|int',
            'comments' => 'nullable|string',
        ];
    }
}
