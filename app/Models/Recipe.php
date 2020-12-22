<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property \App\Models\IngredientAmount[] ingredientAmounts
 */
class Recipe extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected array $fillable = [
        'name',
    ];

    /**
     * @inheritdoc
     */
    protected array $with = ['ingredientAmounts'];

    /**
     * Get the Ingredient Amounts used for this Recipe.
     */
    public function ingredientAmounts(): HasMany {
        return $this->hasMany(IngredientAmount::class);
    }

    /**
     * Get total recipe calories.
     */
    public function calories(): float {
        return $this->sumNutrient('calories');
    }

    /**
     * Get total recipe protein.
     */
    public function protein(): float {
        return $this->sumNutrient('protein');
    }

    /**
     * Get total recipe fat.
     */
    public function fat(): float {
        return $this->sumNutrient('fat');
    }

    /**
     * Get total recipe carbohydrates.
     */
    public function carbohydrates(): float {
        return $this->sumNutrient('carbohydrates');
    }

    /**
     * Sum a specific nutrient for all ingredient amounts.
     *
     * @param string $nutrient
     *   Nutrient to sum ("calories", "protein", "fat", or "carbohydrates").
     *
     * @return float
     */
    private function sumNutrient(string $nutrient): float {
        $sum = 0;
        foreach ($this->ingredientAmounts as $ingredientAmount) {
            $sum += $ingredientAmount->{$nutrient}();
        }
        return $sum;
    }
}
