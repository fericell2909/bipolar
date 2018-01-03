<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BannerNewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'begin' => 'required|date_format:Y-m-d H:i',
            'end'   => 'required|date_format:Y-m-d H:i',
            'photo' => 'required|image',
            'state' => [
                'required',
                Rule::exists('states', 'id'),
            ],
        ];
    }
}
