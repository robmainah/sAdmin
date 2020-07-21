<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:customers,email',
            'id_number' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'password' => 'required|min:6|confirmed',
            "password_confirmation" => "required",
        ];
    }
}
