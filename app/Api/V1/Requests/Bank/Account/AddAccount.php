<?php

namespace App\Api\V1\Requests\Bank\Account;

use Illuminate\Foundation\Http\FormRequest;

class AddAccount extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'account_type_id' => 'required',
            'branch_id' => 'required',
            'account_no' => 'required|max:11|min:11',
            'overdraft' => 'required'
        ];
    }
}
