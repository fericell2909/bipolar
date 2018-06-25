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
            'begin' => 'nullable|date_format:Y-m-d H:i',
            'end'   => 'nullable|date_format:Y-m-d H:i',
            'photo' => 'required|image|max:2000',
            'state' => [
                'required',
                Rule::exists('states', 'id'),
            ],
        ];
    }
}
