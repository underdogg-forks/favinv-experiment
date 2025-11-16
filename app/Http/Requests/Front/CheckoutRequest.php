<?php

namespace App\Http\Requests\Front;

use App\Http\Requests\Request;

class CheckoutRequest extends Request
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
        //dd($this->method() );
        if ($this->method() == 'POST') {
            return [
                'first_name' => 'required',
                'last_name' => 'required',
                'company' => 'required',
                'mobile' => 'regex:/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/',
                'address' => 'required',
                'zip' => 'required|min:5|numeric',
                'email' => 'required|email|unique:users,email',
                //'payment_gateway' => 'required',
            ];
        } elseif ($this->method() == 'PATCH') {
            return [
                'first_name' => 'required',
                'last_name' => 'required',
                'company' => 'required',
                'mobile' => 'regex:/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/',
                'address' => 'required',
                'zip' => 'required|min:5|numeric',
                'email' => 'required|email',
                //'payment_gateway' => 'required',
            ];
        }
    }

    public function messages()
    {
        return [
            'payment_gatway.required' => trans('message.choose_one_payment_gateway'),
            'first_name.required' => trans('validation.customer_form.first_name.required'),
            'last_name.required' => trans('validation.customer_form.last_name.required'),
            'company.required' => trans('validation.customer_form.company.required'),
            'mobile.regex' => trans('validation.customer_form.mobile.regex'),
            'address.required' => trans('validation.customer_form.address.required'),
            'zip.required' => trans('validation.customer_form.zip.required'),
            'zip.min' => trans('validation.customer_form.zip.min'),
            'zip.numeric' => trans('validation.customer_form.zip.numeric'),
            'email.required' => trans('validation.customer_form.email.required'),
            'email.email' => trans('validation.customer_form.email.email'),
            'email.unique' => trans('validation.customer_form.email.unique'),
        ];
    }
}
