<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code'        => ['required', Rule::unique('coupons', 'code')->ignore($this->route('coupon'), 'id')],
            'limit'       => 'required|integer|between:0,9999',
            'coupon_type' => ['required', 'integer', Rule::exists('coupon_types', 'id')],
            'amount'      => 'required|integer|min:1',
            'begin'       => 'required|date_format:d/m/Y',
            'end'         => 'required|date_format:d/m/Y',
        ];
    }
}
