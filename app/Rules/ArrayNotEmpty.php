<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ArrayNotEmpty implements Rule
{
    /**
     * {@inheritdoc}
     */
    public function passes($attribute, $value): bool
    {
        return !empty(array_filter($value, function ($value) {
            // Allow other "empty-y" values like false and 0.
            return $value !== null;
        }));
    }

    /**
     * {@inheritdoc}
     */
    public function message(): string
    {
        return 'At least one :attribute must be set.';
    }
}
