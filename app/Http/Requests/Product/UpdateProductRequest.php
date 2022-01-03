<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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

        $rules = [
            "name" => ["required", "string", "max: 255", "unique:products,name,".request()->id],
            "description" => ["required"],
            "price" => ["required", "numeric"],
            "qty" => ["required", "numeric"],
        ];

        if(request()->hasFile("image")){
            $rules["image"] = ["nullable","mimes:jpeg,jpg,png,gif", "max:1000"];
        }

        return $rules;
    }
}
