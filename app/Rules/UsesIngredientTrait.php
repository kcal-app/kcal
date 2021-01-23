<?php

namespace App\Rules;

use App\Models\Traits\Ingredient;
use Illuminate\Contracts\Validation\Rule;

class UsesIngredientTrait implements Rule
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
        return (
            class_exists($value)
            && in_array(Ingredient::class, class_uses_recursive($value))
        );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Invalid ingredient type :input.';
    }
}
