<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BannerEditRequest extends FormRequest
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
            'begin'                  => 'nullable|date_format:d/m/Y H:i',
            'end'                    => 'nullable|date_format:d/m/Y H:i',
            'photo'                  => 'nullable|image|max:2000',
            'state'                  => [
                'required',
                Rule::exists('states', 'id'),
            ],
            'text_spa'               => 'nullable|max:2000',
            'text_eng'               => 'nullable|max:2000',
            'link'                   => 'nullable|url|max:3000',
            'font_size_mobile'       => 'required|min:1',
            'font_size_tablet'       => 'required|min:1',
            'font_size_desktop'      => 'required|min:1',
            'line_height_mobile'     => 'required|min:1',
            'line_height_tablet'     => 'required|min:1',
            'line_height_desktop'    => 'required|min:1',
            'letter_spacing_mobile'  => 'required|min:1',
            'letter_spacing_tablet'  => 'required|min:1',
            'letter_spacing_desktop' => 'required|min:1',
        ];
    }
}
