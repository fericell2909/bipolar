<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HomePostNewRequest extends FormRequest
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
            'name'       => 'required|between:1,255',
            'link'       => 'required|between:1,255|url',
            'state'      => ['required', Rule::exists('states', 'id')],
            'post_type'  => ['nullable', Rule::exists('post_types', 'id')],
            'begin_date' => 'nullable|date_format:d/m/Y H:i',
            'end_date'   => 'nullable|date_format:d/m/Y H:i',
        ];
    }
}
