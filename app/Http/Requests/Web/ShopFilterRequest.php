<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShopFilterRequest extends FormRequest
{
    protected $redirectRoute = 'home';

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
            'search'     => 'nullable|between:1,500',
            'orderBy'    => 'nullable|in:default,priceup,pricedown',
            'sizes'      => 'nullable|array',
            'sizes.*'    => Rule::exists('sizes', 'slug'),
            'subtypes'   => 'nullable|array',
            'subtypes.*' => Rule::exists('subtypes', 'slug'),
        ];
    }
}
