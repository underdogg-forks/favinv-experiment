<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\Request;

class AddonRequest extends Request
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
            'name' => 'required',
            'subscription' => 'required',
            'regular_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'products' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('validation.subscription_form.name.required'),
            'subscription.required' => trans('validation.subscription_form.subscription.required'),
            'regular_price.required' => trans('validation.subscription_form.regular_price.required'),
            'regular_price.numeric' => trans('validation.subscription_form.regular_price.numeric'),
            'selling_price.required' => trans('validation.subscription_form.selling_price.required'),
            'selling_price.numeric' => trans('validation.subscription_form.selling_price.numeric'),
            'products.required' => trans('validation.subscription_form.products.required'),
        ];
    }
}
