<?php

namespace App\Models;

use App\Support\Number;
use App\Support\Nutrients;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IngredientAmount extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'amount',
        'unit',
        'detail',
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
    protected $with = ['ingredient'];

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
     * @inheritdoc
     */
    protected $appends = ['amount_formatted'];

    /**
     * Get the amount as a formatted string (e.g. 0.5 = 1/2).
     */
    public function getAmountFormattedAttribute(): string {
        return Number::fractionStringFromFloat($this->amount);
    }

    /**
     * Get the ingredient type (Food or Recipe).
     */
    public function ingredient(): BelongsTo {
        return $this->morphTo();
    }

    /**
     * Get the parent (Recipe or JournalEntry).
     */
    public function parent(): BelongsTo {
        return $this->morphTo();
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
            return $this->ingredient->{$method} * Nutrients::calculateFoodNutrientMultiplier(
                $this->ingredient,
                $this->amount,
                $this->unit
            );
        }
        else {
            return parent::__call($method, $parameters);
        }
    }
}
