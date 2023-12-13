<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
                'name'           => 'required|string|unique:products,name',
                'section_id'     => 'required',
                'category_id'    => 'required',
                'status'         => 'required',
                'featured_image' => 'required|image',
                'url'            => 'required',
                'code'           => 'required',
                'price'          => 'required',
                'description'    => 'required',
        ];
    }
}
