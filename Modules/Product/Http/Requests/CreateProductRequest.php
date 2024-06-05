<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'part' => 'required|numeric',
            'priority' => 'nullable|numeric',
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'for_type' => 'nullable|integer',
            'main_image' => 'nullable|image',
            'category_ids.*' => 'nullable|integer',
            'secondary_images.*' => 'nullable|image',
        ];
    }
}
