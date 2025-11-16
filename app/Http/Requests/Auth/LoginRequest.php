<?php

namespace App\Http\Requests\Auth;

use App\Rules\Honeypot;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email_username' => ['required', 'string'],
            'password1' => ['required', 'string'],
            'login' => [new Honeypot()],
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email_username.required' => trans('message.password_email'),
            'password1.required' => trans('message.please_enter_password'),
        ];
    }
}
