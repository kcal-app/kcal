<?php

namespace App\Models;

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
            return $this->food->{$method} * $this->unitMultiplier();
        }
        else {
            return parent::__call($method, $parameters);
        }
    }

    /**
     * Get the multiplier for nutrient calculations based on serving data.
     */
    private function unitMultiplier(): float {
        if ($this->unit === 'oz') {
            return $this->amount * 28.349523125 / $this->food->serving_weight;
        }

        if ($this->food->serving_unit === $this->unit) {
            $multiplier = 1;
        }
        elseif ($this->unit === 'tsp') {
            $multiplier = match ($this->food->serving_unit) {
                'tbsp' => 1/3,
                'cup' => 1/48,
            };
        }
        elseif ($this->unit === 'tbsp') {
            $multiplier = match ($this->food->serving_unit) {
                'tsp' => 3,
                'cup' => 1/16,
            };
        }
        elseif ($this->unit === 'cup') {
            $multiplier = match ($this->food->serving_unit) {
                'tsp' => 48,
                'tbsp' => 16,
            };
        }
        else {
            throw new \DomainException("Unhandled unit combination: {$this->unit}, {$this->food->serving_unit}");
        }

        return $multiplier / $this->food->serving_size * $this->amount;
    }
}
