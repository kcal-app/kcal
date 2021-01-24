<?php

namespace App\Rules;

use App\Support\Number;
use Illuminate\Contracts\Validation\Rule;

class StringIsDecimalOrFraction implements Rule
{
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function message(): string
    {
        return 'The :attribute must be a decimal or fraction.';
    }
}
