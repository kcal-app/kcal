<?php

namespace App\Support;

use App\Models\Food;

/**
 * TODO: Refactor for more general use.
 */
class Nutrients
{
    public static array $all = [
        'calories',
        'fat',
        'cholesterol',
        'sodium',
        'carbohydrates',
        'protein',
    ];

    public static function calculateFoodNutrientMultiplier(
        Food $food,
        float $amount,
        string|null $fromUnit
    ): float {
        if ($fromUnit === 'oz') {
            return $amount * 28.349523125 / $food->serving_weight;
        }
        elseif ($fromUnit === 'servings') {
            return $amount;
        }

        if ($food->serving_unit === $fromUnit) {
            $multiplier = 1;
        }
        elseif ($fromUnit === 'tsp') {
            $multiplier = match ($food->serving_unit) {
                'tbsp' => 1/3,
                'cup' => 1/48,
            };
        }
        elseif ($fromUnit === 'tbsp') {
            $multiplier = match ($food->serving_unit) {
                'tsp' => 3,
                'cup' => 1/16,
            };
        }
        elseif ($fromUnit === 'cup') {
            $multiplier = match ($food->serving_unit) {
                'tsp' => 48,
                'tbsp' => 16,
            };
        }
        else {
            throw new \DomainException("Unhandled unit combination: {$fromUnit}, {$food->serving_unit}");
        }

        return $multiplier / $food->serving_size * $amount;
    }
}
