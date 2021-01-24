<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class InArray implements Rule
{

    /**
     * Array to validate against.
     */
    private array $array;

    /**
     * InArray constructor.
     *
     * @param array $array
     *   Array to use for validation.
     */
    public function __construct(array $array) {
        $this->array = $array;
    }

    /**
     * {@inheritdoc}
     */
    public function passes($attribute, $value): bool
    {
        return in_array($value, $this->array);
    }

    /**
     * {@inheritdoc}
     */
    public function message(): string
    {
        return 'Invalid :attribute value :input.';
    }
}
