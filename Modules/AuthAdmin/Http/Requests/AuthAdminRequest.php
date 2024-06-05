<?php

namespace Modules\AuthAdmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthAdminRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'login' => 'required|string',
            'password' => 'required|string',
        ];
    }
}
