<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class AddressNewRequest extends FormRequest
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
            'name'     => 'required|between:1,255',
            'lastname' => 'required|between:1,255',
            'email'    => 'required|email|between:1,255',
            'phone'    => 'required|between:1,255',
            'country'  => 'required',
            'state'    => 'required',
            'address'  => 'required|between:1,255',
            'zip'      => 'nullable|between:1,255',
        ];
    }
}
