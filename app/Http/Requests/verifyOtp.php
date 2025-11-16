<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class verifyOtp extends FormRequest
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
        $email = $this->request->get('newemail');
        $pass = User::where('email', $email)->value('password');

        return [
            'verify_email' => 'sometimes|required|verify_email|email',
            'verify_email' => 'sometimes|required||verify_country_code|numeric',
            'verify_email' => 'sometimes|required|verify_number|numeric',
            'password' => [

                function ($attribute, $value, $fail) use ($pass) {
                    if (! Hash::check($value, $pass)) {
                        return $fail(trans('validation.password_otp.invalid'));
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'verify_email.required' => trans('validation.verify_email.required'),
            'verify_email.email' => trans('validation.verify_email.email'),
            'verify_email.verify_email' => trans('validation.verify_email.verify_email'), // Custom validation rule message
            'verify_country_code.required' => trans('validation.verify_country_code.required'),
            'verify_country_code.numeric' => trans('validation.verify_country_code.numeric'),
            'verify_country_code.verify_country_code' => trans('validation.verify_country_code.verify_country_code'), // Custom validation rule message
            'verify_number.required' => trans('validation.verify_number.required'),
            'verify_number.numeric' => trans('validation.verify_number.numeric'),
            'verify_number.verify_number' => trans('validation.verify_number.verify_number'), // Custom validation rule message
            'password.required' => trans('validation.password_otp.required'),
        ];
    }
}
