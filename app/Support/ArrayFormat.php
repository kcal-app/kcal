<?php

namespace App\Support;

class ArrayFormat
{

    /**
     * Flip the parent and child keys of a two-dimensional array.
     *
     * The primary use case for this is to simplify the results of a form using
     * input names like `ingredient[]` and `amount[]`.
     *
     * E.g this array:
     *
     * $from = [
     *   'ingredient' => [
     *     0 => 'ingredient-0',
     *     1 => 'ingredient-1',
     *     2 => 'ingredient-2',
     *     3 => 'ingredient-3',
     *   ],
     *   'amount' => [
     *     0 => 'amount-0',
     *     1 => 'amount-1',
     *     2 => 'amount-2',
     *     3 => 'amount-3',
     *   ]
     * ]
     *
     * becomes:
     *
     * $to = [
     *   0 => ['ingredient' => 'ingredient-0', 'amount' => 'amount-0'],
     *   1 => ['ingredient' => 'ingredient-1', 'amount' => 'amount-1'],
     *   2 => ['ingredient' => 'ingredient-2', 'amount' => 'amount-2'],
     *   3 => ['ingredient' => 'ingredient-3', 'amount' => 'amount-3'],
     * ]
     *
     * @param array $array
     *   Two dimensional array to be "flipped".
     *
     * @return array
     *   The flipped array.
     *
     * @todo Return Collection instead of array.
     */
    public static function flipTwoDimensionalKeys(array $array): array {
        $flipped = [];
        foreach ($array as $parent_key => $parent_values) {
            foreach ($parent_values as $child_key => $child_value) {
                $flipped[$child_key][$parent_key] = $child_value;
            }
        }
        return $flipped;
    }
}
