<?php

namespace App\Support;

use App\Models\Food;
use App\Models\Recipe;
use Illuminate\Support\Collection;

class Nutrients
{
    public static float $gramsPerOunce = 28.349523125;

    public static array $units = [
        'cup' => ['value' => 'cup', 'label' => 'cup'],
        'gram' => ['value' => 'gram', 'label' => 'grams'],
        'oz' => ['value' => 'oz', 'label' => 'oz'],
        'serving' => ['value' => 'serving', 'label' => 'servings'],
        'tbsp' => ['value' => 'tbsp', 'label' => 'tbsp.'],
        'tsp' => ['value' => 'tsp', 'label' => 'tsp.'],
    ];

    /**
     * Get all trackable "nutrients" (calories are not technically a nutrient).
     *
     * Each entry has four keys:
     *  - value: Machine name for the entry.
     *  - label: Human-readable name for the entry.
     *  - unit: Unit of measure for the entry.
     *  - weight: Sort weight for presentation.
     */
    public static function all(): Collection {
        return new Collection([
            'calories' => [
                'value' => 'calories',
                'label' => 'calories',
                'unit' => null,
                'weight' => 0,
            ],
            'carbohydrates' => [
                'value' => 'carbohydrates',
                'label' => 'carbohydrates',
                'unit' => 'g',
                'weight' => 40,
            ],
            'cholesterol' => [
                'value' => 'cholesterol',
                'label' => 'cholesterol',
                'unit' => 'mg',
                'weight' => 20,
            ],
            'fat' => [
                'value' => 'fat',
                'label' => 'fat',
                'unit' => 'g',
                'weight' => 10,
            ],
            'protein' => [
                'value' => 'protein',
                'label' => 'protein',
                'unit' => 'g',
                'weight' => 50,
            ],
            'sodium' => [
                'value' => 'sodium',
                'label' => 'sodium',
                'unit' => 'mg',
                'weight' => 30,
            ],
        ]);
    }

    /**
     * Calculate a nutrient multiplier for a Food.
     *
     * @param \App\Models\Food $food
     * @param float $amount
     * @param string|null $fromUnit
     *
     * @return float
     */
    public static function calculateFoodNutrientMultiplier(
        Food $food,
        float $amount,
        string|null $fromUnit
    ): float {
        if ($fromUnit === 'oz') {
            return $amount * self::$gramsPerOunce / $food->serving_weight;
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

    /**
     * Calculate a nutrient amount for a recipe.
     *
     * @param \App\Models\Recipe $recipe
     * @param string $nutrient
     * @param float $amount
     * @param string $fromUnit
     *
     * @return float
     */
    public static function calculateRecipeNutrientAmount(
        Recipe $recipe,
        string $nutrient,
        float $amount,
        string $fromUnit
    ): float {
        if ($fromUnit === 'oz') {
            return $amount * self::$gramsPerOunce / $recipe->weight * $recipe->{"{$nutrient}Total"}();
        }
        elseif ($fromUnit === 'serving') {
            return $recipe->{"{$nutrient}PerServing"}() * $amount;
        }
        elseif ($fromUnit === 'gram') {
            return $amount / $recipe->weight * $recipe->{"{$nutrient}Total"}();
        }
        else {
            throw new \DomainException("Unsupported recipe unit: {$fromUnit}");
        }
    }
}
