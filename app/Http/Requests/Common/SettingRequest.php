<?php

namespace App\Http\Requests\Common;

use App\Http\Requests\Request;

class SettingRequest extends Request
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
            'company' => 'required',
            'website' => 'url',
            'phone' => 'regex:/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/',
            'address' => 'required|max:300',
            'logo' => 'mimes:png',
            'driver' => 'required',
            'port' => 'integer',
            'email' => 'required|email',
            'password' => 'required',
            'error_email' => 'email',

        ];
    }

    public function messages()
    {
        return [
            'company.required' => trans('validation.settings_form.company.required'),
            'website.url' => trans('validation.settings_form.website.url'),
            'phone.regex' => trans('validation.settings_form.phone.regex'),
            'address.required' => trans('validation.settings_form.address.required'),
            'address.max' => trans('validation.settings_form.address.max'),
            'logo.mimes' => trans('validation.settings_form.logo.mimes'),
            'driver.required' => trans('validation.settings_form.driver.required'),
            'port.integer' => trans('validation.settings_form.port.integer'),
            'email.required' => trans('validation.settings_form.email.required'),
            'email.email' => trans('validation.settings_form.email.email'),
            'password.required' => trans('validation.settings_form.password.required'),
            'error_email.email' => trans('validation.settings_form.error_email.email'),
        ];
    }
}
