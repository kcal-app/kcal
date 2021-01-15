<?php

namespace App\Rules;

use App\Support\Number;
use Illuminate\Contracts\Validation\Rule;

class StringIsDecimalOrFraction implements Rule
{
    /**
     * Determine if the string is a decimal or fraction, excluding zero.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        try {
            $result = Number::floatFromString($value);
            return $result != 0;
        }
        catch (\InvalidArgumentException $e) {
            // Allow to pass through, method will return false.
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute must be a decimal or fraction.';
    }
}
