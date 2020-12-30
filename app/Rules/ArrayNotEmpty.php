<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ArrayNotEmpty implements Rule
{
    /**
     * Determine if the array is empty.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return !empty(array_filter($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'At least one :attribute must be set.';
    }
}
