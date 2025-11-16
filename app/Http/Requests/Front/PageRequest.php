<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        if ($this->method() == 'POST') {
            return [
                'name' => 'required|unique:frontend_pages,name|max:20|regex:/^[a-zA-Z\s]*$/',
                'publish' => 'required',
                'slug' => 'required',
                'url' => 'required|url|regex:'.$regex,
                'content' => 'required',
            ];
        } elseif ($this->method() == 'PATCH') {
            return [
                'name' => 'required|max:20',
                'publish' => 'required',
                'slug' => 'required',
                'url' => 'required|url|regex:'.$regex,
                'content' => 'required',
                'created_at' => 'required',
            ];
        }
    }

    public function messages()
    {
        return[
            'created_at.required' => trans('validation.publish_date_required'),
            'name.required' => trans('validation.frontend_pages.name.required'),
            'name.unique' => trans('validation.frontend_pages.name.unique'),
            'name.max' => trans('validation.frontend_pages.name.max'),
            'name.regex' => trans('validation.frontend_pages.name.regex'),

            'publish.required' => trans('validation.frontend_pages.publish.required'),

            'slug.required' => trans('validation.frontend_pages.slug.required'),

            'url.required' => trans('validation.frontend_pages.url.required'),
            'url.url' => trans('validation.frontend_pages.url.url'),
            'url.regex' => trans('validation.frontend_pages.url.regex'),

            'content.required' => trans('validation.frontend_pages.content.required'),
        ];
    }
}
