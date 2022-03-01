<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CountryName implements Rule
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
        $countries = \Countries::getList();

        foreach($countries as $code => $name)
        {
            if($name === $value) return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please select a valid country name';
    }
}
