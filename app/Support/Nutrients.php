<?php

namespace App\Support;

use App\Models\Food;

/**
 * TODO: Refactor for more general use.
 */
class Nutrients
{
    public static array $all = [
        ['value' => 'calories', 'unit' => null],
        ['value' => 'fat', 'unit' => 'g'],
        ['value' => 'cholesterol', 'unit' => 'mg'],
        ['value' => 'sodium', 'unit' => 'mg'],
        ['value' => 'carbohydrates', 'unit' => 'g'],
        ['value' => 'protein', 'unit' => 'g'],
    ];

    public static array $units = [
        ['value' => 'tsp', 'label' => 'tsp.'],
        ['value' => 'tbsp', 'label' => 'tbsp.'],
        ['value' => 'cup', 'label' => 'cup'],
        ['value' => 'oz', 'label' => 'oz'],
        ['value' => 'gram', 'label' => 'grams'],
        ['value' => 'serving', 'label' => 'servings'],
    ];

    public static function calculateFoodNutrientMultiplier(
        Food $food,
        float $amount,
        string|null $fromUnit
    ): float {
        if ($fromUnit === 'oz') {
            return $amount * 28.349523125 / $food->serving_weight;
        }
        elseif ($fromUnit === 'serving') {
            return $amount;
        }
        elseif ($fromUnit === 'gram') {
            return $amount / $food->serving_weight;
        }

        if (
            empty($fromUnit)
            || empty($food->serving_unit)
            || $food->serving_unit === $fromUnit
        ) {
            $multiplier = 1;
        }
        elseif ($fromUnit === 'tsp') {
            $multiplier = match ($food->serving_unit) {
                'tbsp' => 1/3,
                'cup' => 1/48,
                default => throw new \DomainException(),
            };
        }
        elseif ($fromUnit === 'tbsp') {
            $multiplier = match ($food->serving_unit) {
                'tsp' => 3,
                'cup' => 1/16,
                default => throw new \DomainException(),
            };
        }
        elseif ($fromUnit === 'cup') {
            $multiplier = match ($food->serving_unit) {
                'tsp' => 48,
                'tbsp' => 16,
                default => throw new \DomainException(),
            };
        }
        else {
            throw new \DomainException("Unhandled unit combination: {$fromUnit}, {$food->serving_unit} ({$food->name})");
        }

        return $multiplier / $food->serving_size * $amount;
    }
}
