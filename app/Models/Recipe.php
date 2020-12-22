<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int id
 * @property string name
 * @property string description
 * @property int servings
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
        'description',
        'servings',
    ];

    /**
     * The attributes that should be cast.
     */
    protected array $casts = [
        'servings' => 'int',
    ];

    /**
     * @inheritdoc
     */
    protected array $with = ['steps', 'ingredientAmounts'];

    /**
     * Get the steps for this Recipe.
     */
    public function steps(): HasMany {
        return $this->hasMany(RecipeStep::class)->orderBy('number');
    }

    /**
     * Get the Ingredient Amounts used for this Recipe.
     */
    public function ingredientAmounts(): HasMany {
        return $this->hasMany(IngredientAmount::class)->orderBy('weight');
    }

    /**
     * Get total calories.
     */
    public function caloriesTotal(): float {
        return $this->sumNutrient('calories');
    }

    /**
     * Get per serving calories.
     */
    public function caloriesPerServing(): float {
        return $this->caloriesTotal() / $this->servings;
    }

    /**
     * Get total protein.
     */
    public function proteinTotal(): float {
        return $this->sumNutrient('protein');
    }

    /**
     * Get per serving protein.
     */
    public function proteinPerServing(): float {
        return $this->proteinTotal() / $this->servings;
    }

    /**
     * Get total fat.
     */
    public function fatTotal(): float {
        return $this->sumNutrient('fat');
    }

    /**
     * Get per serving fat.
     */
    public function fatPerServing(): float {
        return $this->fatTotal() / $this->servings;
    }

    /**
     * Get total carbohydrates.
     */
    public function carbohydratesTotal(): float {
        return $this->sumNutrient('carbohydrates');
    }

    /**
     * Get per serving carbohydrates.
     */
    public function carbohydratesPerServing(): float {
        return $this->carbohydratesTotal() / $this->servings;
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
