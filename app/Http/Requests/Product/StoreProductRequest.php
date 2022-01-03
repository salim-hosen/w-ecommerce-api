<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->role == "admin";
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => ["required", "string", "max: 255", "unique:products"],
            "description" => ["required"],
            "price" => ["required", "numeric"],
            "qty" => ["required", "numeric", "min: 1"],
            "image" => ["required","mimes:jpeg,jpg,png,gif", "max:1000"]
        ];
    }
}
