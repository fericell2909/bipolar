<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ShippingEditPriceRequest extends FormRequest
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
            'g200'       => 'required|numeric',
            'g200_dolar' => 'required|numeric',
            'g500'       => 'required|numeric',
            'g500_dolar' => 'required|numeric',
            'kg1'        => 'required|numeric',
            'kg1_dolar'  => 'required|numeric',
            'kg2'        => 'required|numeric',
            'kg2_dolar'  => 'required|numeric',
            'kg3'        => 'required|numeric',
            'kg3_dolar'  => 'required|numeric',
            'kg4'        => 'required|numeric',
            'kg4_dolar'  => 'required|numeric',
            'kg5'        => 'required|numeric',
            'kg5_dolar'  => 'required|numeric',
            'kg6'        => 'required|numeric',
            'kg6_dolar'  => 'required|numeric',
            'kg7'        => 'required|numeric',
            'kg7_dolar'  => 'required|numeric',
            'kg8'        => 'required|numeric',
            'kg8_dolar'  => 'required|numeric',
            'kg9'        => 'required|numeric',
            'kg9_dolar'  => 'required|numeric',
            'kg10'       => 'required|numeric',
            'kg10_dolar' => 'required|numeric',
        ];
    }
}
