<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ShippingNewRequest extends FormRequest
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
            'title_spa'         => 'required|between:1,255',
            'title_eng'         => 'required|between:1,255',
            'include_countries' => 'nullable|array',
            'include_states'    => 'nullable|array',
            'exclude_countries' => 'nullable|array',
            'exclude_states'    => 'nullable|array',
            'allow_showroom'    => 'nullable'
        ];
    }
}
