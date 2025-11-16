<?php

namespace App\Http\Requests\Common;

use Illuminate\Foundation\Http\FormRequest;

class SystemManagerSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'existingAccManager' => 'required_with:newAccManager|integer',
            'newAccManager' => 'required_with:existingAccManager|integer|different:existingAccManager',
            'existingSaleManager' => 'required_with:newSaleManager|integer',
            'newSaleManager' => 'required_with:existingSaleManager|integer|different:existingSaleManager',
            'autoAssignAccount' => 'required|boolean',
            'autoAssignSales' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'existingAccManager.required_with' => trans('message.existingAccManager_required'),
            'newAccManager.required_with' => trans('message.newAccManager_required'),
            'newAccManager.different' => trans('message.same_account_manager_error'),
            'existingSaleManager.required_with' => trans('message.select_system_sales_manager'),
            'newSaleManager.required_with' => trans('message.select_new_sales_manager'),
            'newSaleManager.different' => trans('message.sales_manager_must_be_different'),
        ];
    }
}
