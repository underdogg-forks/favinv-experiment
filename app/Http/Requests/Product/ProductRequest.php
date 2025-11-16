<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\Request;

class ProductRequest extends Request
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
            'type' => 'required',
            'group' => 'required',
            'subscription' => 'required',
            'currency' => 'required',
            // 'price'             => 'required',
            'file' => 'required_without_all:github_owner,github_repository|mimes:zip',
            'image' => 'required_without_all:github_owner,github_repository|mimes:png',
            'github_owner' => 'required_without_all:file,image',
            'github_repository' => 'required_without_all:file,image|required_if:type,2',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('validation.product.name.required'),
            'type.required' => trans('validation.product.type.required'),
            'group.required' => trans('validation.product.group.required'),
            'subscription.required' => trans('validation.product.subscription.required'),
            'currency.required' => trans('validation.product.currency.required'),
            // 'price.required' => trans('validation.product.price.required'),
            'file.required_without_all' => trans('validation.product.file.required_without_all'),
            'file.mimes' => trans('validation.product.file.mimes'),
            'image.required_without_all' => trans('validation.product.image.required_without_all'),
            'image.mimes' => trans('validation.product.image.mimes'),
            'github_owner.required_without_all' => trans('validation.product.github_owner.required_without_all'),
            'github_repository.required_without_all' => trans('validation.product.github_repository.required_without_all'),
            'github_repository.required_if' => trans('validation.product.github_repository.required_if'),
        ];
    }
}
