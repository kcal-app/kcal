<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property float amount Amount of ingredient.
 * @property ?string unit Ingredient unit (tsp, tbsp, cup, or grams).
 * @property int weight Weight of ingredient in full ingredient list (lowest first).
 * @property \App\Models\Ingredient ingredient
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
class IngredientAmount extends Model
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
     * Get the Ingredient this amount belongs to.
     */
    public function ingredient(): BelongsTo {
        return $this->belongsTo(Ingredient::class);
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
            return $this->ingredient->{$method} * $this->unitMultiplier();
        }
        else {
            return parent::__call($method, $parameters);
        }
    }

    /**
     * Get the multiplier for the ingredient unit based on weight.
     *
     * Unit weight will be specified for ingredients that are added by unit
     * (e.g. eggs, vegetables, etc.) and cup weight (the weight of the
     * ingredient equal to one cup) will be specified for ingredients that are
     * measured (e.g. flour, milk, etc.).
     */
    private function unitMultiplier(): float {
        return match ($this->unit) {
            null => $this->ingredient->unit_weight,
            'tsp' => 1/48,
            'tbsp' => 1/16,
            default => 1
        } * $this->amount * ($this->ingredient->cup_weight ?? 1) / 100;
    }
}
