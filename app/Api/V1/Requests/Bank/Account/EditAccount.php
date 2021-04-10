<?php

namespace App\Api\V1\Requests\Bank\Account;

use Illuminate\Foundation\Http\FormRequest;

class EditAccount extends FormRequest
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
            'id' => 'required|exists:accounts',
            'overdraft' => 'required'
        ];
    }
}
