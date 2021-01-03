<?php

namespace App\Models;

use App\Support\Nutrients;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperFoodAmount
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
            return $this->food->{$method} * Nutrients::calculateFoodNutrientMultiplier(
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
