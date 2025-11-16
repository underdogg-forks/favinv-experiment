<?php

namespace App\Http\Requests\Payment;

use App\Http\Requests\Request;

class PromotionRequest extends Request
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
        $rules = [
            'code' => 'required',
            'type' => 'required',
            'applied' => 'required',
            'uses' => 'required|numeric',
            'start' => 'required',
            'expiry' => 'required|after:start',
        ];
        // If 'type' is 'percentage', add additional validation for 'value'
        if ($this->input('type') === '1') {
            $rules['value'] = 'required|numeric|between:1,100';
        } else {
            $rules['value'] = 'required|numeric';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'code.required' => trans('validation.coupon_form.code.required'),
            'code.string' => trans('validation.coupon_form.code.string'),
            'code.max' => trans('validation.coupon_form.code.max'),
            'type.required' => trans('validation.coupon_form.type.required'),
            'type.in' => trans('validation.coupon_form.type.in'),
            'applied.required' => trans('validation.coupon_form.applied.required'),
            'applied.date' => trans('validation.coupon_form.applied.date'),
            'uses.required' => trans('validation.coupon_form.uses.required'),
            'uses.numeric' => trans('validation.coupon_form.uses.numeric'),
            'uses.min' => trans('validation.coupon_form.uses.min'),
            'start.required' => trans('validation.coupon_form.start.required'),
            'start.date' => trans('validation.coupon_form.start.date'),
            'expiry.required' => trans('validation.coupon_form.expiry.required'),
            'expiry.date' => trans('validation.coupon_form.expiry.date'),
            'expiry.after' => trans('validation.coupon_form.expiry.after'),
            'value.required' => trans('validation.coupon_form.value.required'),
            'value.numeric' => trans('validation.coupon_form.value.numeric'),
            'value.between' => trans('validation.coupon_form.value.between'),
        ];
    }
}
