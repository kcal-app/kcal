<?php

namespace App\Support;

use App\Models\Food;
use App\Models\Recipe;
use Illuminate\Support\Collection;

class Nutrients
{
    public static float $gramsPerOunce = 28.349523125;

    /**
     * Get all supported units and metadata.
     *
     * Each entry has two keys:
     *  - value: Machine name for the unit.
     *  - label: Human-readable name for the unit.
     *  - plural: Human-readable plural form of the unit name.
     *  - type: Unit type -- matching types can be converted.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function units(): Collection {
        return new Collection([
            'cup' => [
                'value' => 'cup',
                'label' => 'cup',
                'plural' => 'cups',
                'type' => 'volume',
            ],
            'gram' => [
                'value' => 'gram',
                'label' => 'gram',
                'plural' => 'grams',
                'type' => 'weight',
            ],
            'oz' => [
                'value' => 'oz',
                'label' => 'oz',
                'plural' => 'oz',
                'type' => 'weight',
            ],
            'serving' => [
                'value' => 'serving',
                'label' => 'serving',
                'plural' => 'servings',
                'type' => 'division',
            ],
            'tbsp' => [
                'value' => 'tbsp',
                'label' => 'tbsp.',
                'plural' => 'tbsp.',
                'type' => 'volume',
            ],
            'tsp' => [
                'value' => 'tsp',
                'label' => 'tsp.',
                'plural' => 'tsp.',
                'type' => 'volume',
            ],
        ]);
    }

    /**
     * Get all trackable "nutrients" (calories are not technically a nutrient).
     *
     * Each entry has four keys:
     *  - value: Machine name for the entry.
     *  - label: Human-readable name for the entry.
     *  - unit: Unit of measure for the entry.
     *  - weight: Sort weight for presentation.
     *  - rdi: US FDA's recommended daily intake for adults (https://www.fda.gov/media/99059/download).
     */
    public static function all(): Collection {
        return new Collection([
            'calories' => [
                'value' => 'calories',
                'label' => 'calories',
                'unit' => null,
                'weight' => 0,
                'rdi' => 2000,
            ],
            'carbohydrates' => [
                'value' => 'carbohydrates',
                'label' => 'carbohydrates',
                'unit' => 'g',
                'weight' => 40,
                'rdi' => 275,
            ],
            'cholesterol' => [
                'value' => 'cholesterol',
                'label' => 'cholesterol',
                'unit' => 'mg',
                'weight' => 20,
                'rdi' => 300,
            ],
            'fat' => [
                'value' => 'fat',
                'label' => 'fat',
                'unit' => 'g',
                'weight' => 10,
                'rdi' => 78,
            ],
            'protein' => [
                'value' => 'protein',
                'label' => 'protein',
                'unit' => 'g',
                'weight' => 50,
                'rdi' => 50,
            ],
            'sodium' => [
                'value' => 'sodium',
                'label' => 'sodium',
                'unit' => 'mg',
                'weight' => 30,
                'rdi' => 2300,
            ],
        ]);
    }

    /**
     * Calculate a nutrient multiplier for a Food.
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

        // @todo Determine if `empty($food->serving_unit)` case makes sense.
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
     * Weight base unit is grams, volume base unit is cups.
     */
    public static function calculateRecipeNutrientAmount(
        Recipe $recipe,
        string $nutrient,
        float $amount,
        string $fromUnit
    ): float {
        if ($fromUnit === 'serving') {
            // Use "per serving" methods directly.
            return $recipe->{"{$nutrient}PerServing"}() * $amount;
        }
        $multiplier = match ($fromUnit) {
            'oz' => $amount * self::$gramsPerOunce / $recipe->weight,
            'gram' => $amount / $recipe->weight,
            'tsp' => $amount / 48 / $recipe->volume,
            'tbsp' => $amount / 16 / $recipe->volume,
            'cup' => $amount / $recipe->volume,
            default => throw new \DomainException("Unsupported recipe unit: {$fromUnit}"),
        };
        return $multiplier * $recipe->{"{$nutrient}Total"}();
    }

    /**
     * Round a nutrient amount according to FDA guidelines.
     *
     * Note: this stays mostly true to the guidelines except that carbohydrates
     * and protein are meant to state "less than 1 gram" when the amount is less
     * than 1 gram. Instead, this method treats anything less than 1 gram as
     * zero.
     *
     * @url https://labelcalc.com/food-labeling/a-guide-to-using-fda-rounding-rules-for-your-food-label/
     *
     * @throws \InvalidArgumentException
     */
    public static function round(float $amount, string $nutrient): float {
        return match ($nutrient) {

            /*
             * Calories:
             *  - Less than 5 goes to zero.
             *  - Between 5 and 50 rounds to nearest number divisible by 5.
             *  - Greater than 50 rounds to nearest number divisible by 10.
             */
            'calories' => ($amount < 5 ? 0 : ($amount <= 50 ? round($amount / 5 ) * 5 : round($amount / 10 ) * 10)),

            /*
             * Carbohydrates and protein:
             *  - Less than 1 goes to zero.
             *  - Greater than 1 rounds to nearest whole.
             */
            'carbohydrates', 'protein' => ($amount < 1 ? 0 : round($amount)),

            /*
             * Cholesterol and fat:
             *  - Less than 0.5 goes to zero.
             *  - Between 0.5 and 5 rounds to nearest half.
             *  - Greater than 5 rounds to nearest whole.
             */
            'cholesterol', 'fat'  => ($amount < 0.5 ? 0 : ($amount <= 5 ? round($amount / 5, 1 ) * 5 : round($amount))),

            /*
             * Sodium:
             *  - Less than 5 goes to zero.
             *  - Between 5 and 140 rounds to nearest number divisible by 5.
             *  - Greater than 140 rounds to nearest number divisible by 10.
             */
            'sodium' => ($amount < 5 ? 0 : ($amount <= 140 ? round($amount / 5 ) * 5 : round($amount / 10 ) * 10)),

            /*
             * Anything else excepts!
             */
            default => throw new \InvalidArgumentException("Unrecognized nutrient {$nutrient}.")
        };
    }
}
