<?php

namespace App\Rules;

use App\Models\Traits\Ingredient;
use Illuminate\Contracts\Validation\Rule;

class UsesIngredientTrait implements Rule
{
    /**
     * {@inheritdoc}
     */
    public function passes($attribute, $value): bool
    {
        return (
            class_exists($value)
            && in_array(Ingredient::class, class_uses_recursive($value))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function message(): string
    {
        return 'Invalid ingredient type :input.';
    }
}
