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
        return !empty(array_filter($value));
    }

    /**
     * {@inheritdoc}
     */
    public function message(): string
    {
        return 'At least one :attribute must be set.';
    }
}
