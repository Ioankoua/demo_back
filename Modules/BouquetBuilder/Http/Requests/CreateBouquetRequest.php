<?php

namespace Modules\BouquetBuilder\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBouquetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'description' => 'nullable|string',
            'compound' => 'nullable|string',
            'phone' => 'nullable|string',
            'social' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
