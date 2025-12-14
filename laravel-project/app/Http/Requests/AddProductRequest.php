<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
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
    public function rules()
    {
        return [
            //
            'name' => 'required|max:255|unique:products',
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
            'color_id' => 'required',
            'size_id' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'desc' => 'required|max:5000',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'first_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'second_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'third_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'color_id.required' => 'The color field is required.',
            'size_id.required' => 'The size field is required.',
            'category_id.required' => 'The category field is required.',
            'brand_id.required' => 'The brand field is required.',
            'desc.required' => 'The desciption field is required.',
            'desc.max' => 'The desciption field must not be greater than 5000 characters.',
            'qty.required' => 'The qty field is required.',
            //thumbnail
            'thumbnail.max' => 'The thumbnail field must not be greater than 2 MB.',
            'thumbnail.image' => 'The thumbnail field must be an image.',
            //first image
            'first_image.required' => 'The first image field is required.',
            'first_image.max' => 'The first_image field must not be greater than 2 MB.',
            'first_image.image' => 'The first_image field must be an image.',
            //second image
            'second_image.required' => 'The second_image field is required.',
            'second_image.max' => 'The second_image field must not be greater than 2 MB.',
            'second_image.image' => 'The second_image field must be an image.',
            //third image
            'third_image.required' => 'The third_image field is required.',
            'third_image.max' => 'The third_image field must not be greater than 2 MB.',
            'third_image.image' => 'The third_image field must be an image.',


        ];
    }
}
