<?php

namespace App\Models\Traits;

use App\Models\IngredientAmount;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasIngredients
{
    /**
     * Nutrient total calculation methods.
     */
    protected array $nutrientTotalMethods = [
        'caloriesTotal',
        'carbohydratesTotal',
        'cholesterolTotal',
        'fatTotal',
        'proteinTotal',
        'sodiumTotal',
    ];

    /**
     * Get all of the ingredients.
     */
    public function ingredientAmounts(): MorphMany {
        return $this->morphMany(IngredientAmount::class, 'parent');
    }

    /**
     * Sum a specific nutrient for all ingredients.
     *
     * @param string $nutrient
     *   Nutrient to sum.
     *
     * @return float
     */
    private function sumNutrient(string $nutrient): float {
        $sum = 0;
        foreach ($this->ingredients as $ingredientAmount) {
            $sum += $ingredientAmount->{$nutrient}();
        }
        return $sum;
    }
}
