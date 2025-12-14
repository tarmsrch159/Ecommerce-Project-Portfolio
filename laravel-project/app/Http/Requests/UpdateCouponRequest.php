<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
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
            'name' => 'required|max:255|unique:coupons,name,' . $this->coupon->id,
            'discount' => 'required',
            'valid_until' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'valid_until.required' => 'The coupon validity is required'
        ];
    }
}
