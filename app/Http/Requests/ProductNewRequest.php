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
            'name'        => 'required|between:1,255|string',
            'description' => 'nullable|max:4000',
            'colors'      => 'nullable|array',
            'price'       => 'required|numeric|min:1',
            'weight'      => 'nullable|numeric|min:1',
            'salient'     => 'boolean',
            'subtype'     => 'nullable|array',
            'sizes'       => 'nullable|array',
            'state'       => 'required|string',
        ];
    }
}
