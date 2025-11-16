<?php

namespace App\Http\Requests\Order;

use App\Http\Requests\Request;

class OrderRequest extends Request
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
            'client' => 'required',
            'payment_method' => 'required',
            'promotion_code' => 'required',
            'order_status' => 'required',
            'product' => 'required',
            //'domain'         => 'url',
            'subscription' => 'required',
            'price_override' => 'numeric',
            'qty' => 'integer',
        ];
    }

    public function messages()
    {
        return [
            'price_override.numeric' => trans('validation.price_numeric_value'),
            'qty.integer' => trans('validation.quantity_integer_value'),
            'client.required' => trans('validation.order_form.client.required'),
            'payment_method.required' => trans('validation.order_form.payment_method.required'),
            'promotion_code.required' => trans('validation.order_form.promotion_code.required'),
            'order_status.required' => trans('validation.order_form.order_status.required'),
            'product.required' => trans('validation.order_form.product.required'),
            'subscription.required' => trans('validation.order_form.subscription.required'),
        ];
    }
}
