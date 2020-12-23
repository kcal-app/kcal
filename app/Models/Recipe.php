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
 * @property \App\Models\RecipeStep[] steps
 * @property \App\Models\IngredientAmount[] ingredientAmounts
 * @method float caloriesTotal Get total calories.
 * @method float caloriesPerServing Get per serving calories.
 * @method float carbohydratesTotal Get total carbohydrates.
 * @method float carbohydratesPerServing Get per serving carbohydrates.
 * @method float cholesterolTotal Get total cholesterol.
 * @method float cholesterolPerServing Get per serving cholesterol.
 * @method float fatTotal Get total fat.
 * @method float fatPerServing Get per serving fat.
 * @method float proteinTotal Get total protein.
 * @method float proteinPerServing Get per serving protein.
 * @method float sodiumTotal Get total sodium.
 * @method float sodiumPerServing Get per serving sodium.
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
     * Nutrient total calculation methods.
     */
    private array $nutrientTotalMethods = [
        'caloriesTotal',
        'carbohydratesTotal',
        'cholesterolTotal',
        'fatTotal',
        'proteinTotal',
        'sodiumTotal',
    ];

    /**
     * Nutrient per serving methods.
     */
    private array $nutrientPerServingMethods = [
        'caloriesPerServing',
        'carbohydratesPerServing',
        'cholesterolPerServing',
        'fatPerServing',
        'proteinPerServing',
        'sodiumPerServing',
    ];

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
     * Add nutrient calculations handling to overloading.
     *
     * @param string $method
     * @param array $parameters
     *
     * @return mixed
     *
     * @noinspection PhpMissingParamTypeInspection
     */
    public function __call($method, $parameters): mixed {
        if (in_array($method, $this->nutrientTotalMethods)) {
            return $this->sumNutrient(substr($method, 0, -5));
        }
        elseif (in_array($method, $this->nutrientPerServingMethods)) {
            return $this->sumNutrient(substr($method, 0, -10)) / $this->servings;
        }
        else {
            return parent::__call($method, $parameters);
        }
    }

    /**
     * Sum a specific nutrient for all ingredient amounts.
     *
     * @param string $nutrient
     *   Nutrient to sum.
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
