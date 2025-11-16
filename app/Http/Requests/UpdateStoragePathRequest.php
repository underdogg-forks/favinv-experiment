<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoragePathRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'disk' => 'required|string',
            'path' => 'string|nullable',
        ];
    }

    public function messages()
    {
        return [
            'disk.required' => trans('validation.storage_path.disk.required'),
            'disk.string' => trans('validation.storage_path.disk.string'),
            'path.string' => trans('validation.storage_path.path.string'),
            'path.nullable' => trans('validation.storage_path.path.nullable'),
        ];
    }
}
