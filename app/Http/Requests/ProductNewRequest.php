<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductNewRequest extends FormRequest
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
            'name'                => 'required|between:1,255|string',
            'name_english'        => 'required|between:1,255|string',
            'description'         => 'nullable|max:4000',
            'description_english' => 'nullable|max:4000',
            'colors'              => 'nullable|array',
            'price'               => 'required|numeric',
            'weight'              => 'nullable|numeric',
            'free_shipping'       => 'boolean',
            'is_showroom_sale'    => 'boolean',
            'salient'             => 'boolean',
            'subtype'             => 'nullable|array',
            'sizes'               => 'nullable|array',
            'state'               => 'required|string',
        ];
    }
}
