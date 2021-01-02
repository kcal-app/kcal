<?php

namespace App\Models;

use App\Support\NutrientCalculator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property float amount Amount of food.
 * @property ?string unit Food unit (tsp, tbsp, cup, or grams).
 * @property int weight Weight of food in full food list (lowest first).
 * @property \App\Models\Food food
 * @property \App\Models\Recipe recipe
 * @property \Illuminate\Support\Carbon created_at
 * @property \Illuminate\Support\Carbon updated_at
 * @method float calories Get total calories.
 * @method float carbohydrates Get total carbohydrates.
 * @method float cholesterol Get total cholesterol.
 * @method float fat Get total fat.
 * @method float protein Get total protein.
 * @method float sodium Get total sodium.
 */
class FoodAmount extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'amount',
        'unit',
        'weight',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'amount' => 'float',
        'weight' => 'int',
    ];

    /**
     * @inheritdoc
     */
    protected $with = ['food'];

    /**
     * Nutrient calculation methods.
     */
    private array $nutrientMethods = [
        'calories',
        'carbohydrates',
        'cholesterol',
        'fat',
        'protein',
        'sodium',
    ];

    /**
     * Get the Food this amount belongs to.
     */
    public function food(): BelongsTo {
        return $this->belongsTo(Food::class);
    }

    /**
     * Get the Recipe this amount belongs to.
     */
    public function recipe(): BelongsTo {
        return $this->belongsTo(Recipe::class);
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
        if (in_array($method, $this->nutrientMethods)) {
            return $this->food->{$method} * NutrientCalculator::calculateFoodNutrientMultiplier(
                $this->food,
                $this->amount,
                $this->unit
            );
        }
        else {
            return parent::__call($method, $parameters);
        }
    }
}
