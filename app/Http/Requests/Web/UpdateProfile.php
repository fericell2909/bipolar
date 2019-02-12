<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfile extends FormRequest
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
        $rules = [
            'name'     => 'required|string|between:3,255',
            'lastname' => 'nullable|string|between:3,255',
            'email'    => 'required|string|between:3,255',
            'birthday' => 'nullable|date_format:Y-m-d',
        ];

        if ($this->filled('old_password')) {
            $rules = array_merge($rules, [
                'old_password'              => 'nullable|string',
                'new_password'              => 'required_with:old_password|confirmed',
                'new_password_confirmation' => 'required_with:old_password',
            ]);
        }

        return $rules;
    }
}
