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
     * Get the multiplier for the food unit based on weight.
     *
     * Unit weight will be specified for foods that are added by unit
     * (e.g. eggs, vegetables, etc.) and cup weight (the weight of the
     * food equal to one cup) will be specified for foods that are
     * measured (e.g. flour, milk, etc.).
     */
    private function unitMultiplier(): float {
        return match ($this->unit) {
            null => $this->food->unit_weight,
            'tsp' => 1/48,
            'tbsp' => 1/16,
            default => 1
        } * $this->amount * ($this->food->cup_weight ?? 1) / 100;
    }
}
