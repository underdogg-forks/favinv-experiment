<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class ClientRequest extends Request
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'company' => 'required',
                    'email' => 'required|email|unique:users',
                    'address' => 'required',
                    'mobile' => 'required',
                    'country' => 'required|exists:countries,country_code_char2',
                    'timezone_id' => 'required',
                    'user_name' => 'unique:users,user_name',
                    'zip' => 'regex:/^[a-zA-Z0-9]+$/',
                    'position' => 'prohibited_if:role,user',
                ];

            case 'PATCH':
                $id = $this->segment(2);

                return [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required|email|unique:users,email,'.$this->getSegmentFromEnd().',id',
                    'company' => 'required',
                    'address' => 'required',
                    'mobile' => 'required',
                    'timezone_id' => 'required',
                    'user_name' => 'unique:users,user_name,'.$id,
                    'zip' => 'regex:/^[a-zA-Z0-9]+$/',
                    'position' => 'prohibited_if:role,user',
                ];

            default:
                break;
        }
    }

    public function messages()
    {
        return [
            'first_name.required' => trans('validation.users.first_name.required'),
            'last_name.required' => trans('validation.users.last_name.required'),
            'company.required' => trans('validation.users.company.required'),
            'email.required' => trans('validation.users.email.required'),
            'email.email' => trans('validation.users.email.email'),
            'email.unique' => trans('validation.users.email.unique'),
            'address.required' => trans('validation.users.address.required'),
            'mobile.required' => trans('validation.users.mobile.required'),
            'country.required' => trans('validation.users.country.required'),
            'country.exists' => trans('validation.users.country.exists'),
            'state.required_if' => trans('validation.users.state.required_if'),
            'timezone_id.required' => trans('validation.users.timezone_id.required'),
            'user_name.required' => trans('validation.users.user_name.required'),
            'user_name.unique' => trans('validation.users.user_name.unique'),
            'zip.regex' => trans('validation.users.zip.regex'),
            'position.prohibited_if' => trans('message.user_position_prohibited_if'),
        ];
    }

    private function getSegmentFromEnd($position_from_end = 1)
    {
        $segments = $this->segments();

        return $segments[count($segments) - $position_from_end];
    }
}
