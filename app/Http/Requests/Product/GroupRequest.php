<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\Request;

class GroupRequest extends Request
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
            // 'features.*.name' => 'required',
            // 'title'           => 'required_with:type,price,value',
            // 'type'            => 'required_with:title,price,value',
            // 'price.*.name'    => 'required_unless:type,1|numeric',
            // 'price.*.name'    => 'required_unless:type,2|numeric',
            // 'value.*.name'    => 'required_unless:type,1',
            // 'value.*.name'    => 'required_unless:type,2',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('validation.group.name.required'),
            'features.*.name.required' => trans('validation.group.features.name.required'),
            'price.*.name.required_unless' => trans('validation.group.price.name.required_unless'),
            'value.*.name.required_unless' => trans('validation.group.value.name.required_unless'),
            'type.required_with' => trans('validation.group.type.required_with'),
            'title.required_with' => trans('validation.group.title.required_with'),
        ];
    }
}
