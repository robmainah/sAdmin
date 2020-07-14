<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class EditProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'title' => 'required|max:255|unique:products,title,'. $this->product->id,
            'category' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required',
        ];
    }
}
