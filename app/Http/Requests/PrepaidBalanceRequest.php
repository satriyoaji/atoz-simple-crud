<?php

namespace App\Http\Requests;

use App\Rules\PhonePrefix;
use Illuminate\Foundation\Http\FormRequest;

class PrepaidBalanceRequest extends FormRequest
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
            'mobile_phone' => ['required','digits_between:7,12', new PhonePrefix],
            'value' => 'required|numeric|in:10000,50000,100000',
        ];
    }
}
