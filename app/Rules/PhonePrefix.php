<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhonePrefix implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
//        $index = explode('.', $attribute)[1];
//        $prefix = request()->input("phones.{$index}.prefix");
        return substr($value, 0, 3) == "081";
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The number input must be prefixed with 081';
    }
}
