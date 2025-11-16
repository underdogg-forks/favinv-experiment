<?php

namespace App\Http\Requests\Common;

use Illuminate\Foundation\Http\FormRequest;

class SocialMediaRequest extends FormRequest
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
        $regex = '/^(https?:\/\/)?([\w-]+\.)+([a-z]{2,6})(\/[\w-]*)*(\?.*)?(#.*)?$/i';

        if ($this->method() == 'POST') {
            return [
                'name' => 'required|unique:social_media|max:50',
                'link' => 'required|regex:'.$regex,
            ];
        } elseif ($this->method() == 'PATCH') {
            return [
                'name' => 'required',
                'link' => 'required|url|regex:'.$regex,
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => trans('validation.social_media_form.name.required'),
            'name.unique' => trans('validation.social_media_form.name.unique'),
            'name.max' => trans('validation.social_media_form.name.max'),
            'link.required' => trans('validation.social_media_form.link.required'),
            'link.url' => trans('validation.social_media_form.link.url'),
            'link.regex' => trans('validation.social_media_form.link.regex'),
        ];
    }
}
