<?php

namespace App\Models;

use App\Support\Number;
use App\Support\Nutrients;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Pluralizer;

/**
 * App\Models\IngredientAmount
 *
 * @property int $id
 * @property int $ingredient_id
 * @property string $ingredient_type
 * @property float $amount
 * @property string|null $unit
 * @property string|null $detail
 * @property int $weight
 * @property int $parent_id
 * @property string $parent_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $amount_formatted
 * @property-read \App\Models\Food|\App\Models\Recipe $ingredient
 * @property-read \App\Models\Recipe|\App\Models\JournalEntry $parent
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAmount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAmount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAmount query()
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAmount whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAmount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAmount whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAmount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAmount whereIngredientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAmount whereIngredientType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAmount whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAmount whereParentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAmount whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAmount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngredientAmount whereWeight($value)
 * @mixin \Eloquent
 * @property-read string|null $unit_formatted
 * @property-read string $nutrients_summary
 * @method static \Database\Factories\IngredientAmountFactory factory(...$parameters)
 */
final class IngredientAmount extends Model
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
    protected $appends = [
        'amount_formatted',
        'nutrients_summary',
        'unit_formatted'
    ];

    /**
     * Get the amount as a formatted string (e.g. 0.5 = 1/2).
     */
    public function getAmountFormattedAttribute(): string {
        return Number::rationalStringFromFloat($this->amount);
    }

    /**
     * Get a simple string summary of nutrients for the ingredient amount.
     *
     * TODO: Move to HasIngredients trait.
     */
    public function getNutrientsSummaryAttribute(): string {
        $summary = [];
        foreach (Nutrients::all() as $nutrient) {
            $amount = Nutrients::round($this->{$nutrient['value']}(), $nutrient['value']);
            $summary[] = "{$nutrient['label']}: {$amount}{$nutrient['unit']}";
        }
        return implode(', ', $summary);
    }

    /**
     * Get a "formatted" unit.
     *
     * @see \App\Models\Food::getServingUnitFormattedAttribute()
     */
    public function getUnitFormattedAttribute(): ?string {
        $unit = $this->unit;

        // Inherit formatted unit from Food.
        if ($unit === 'serving' && $this->ingredient->type === Food::class) {
            $unit = $this->ingredient->serving_unit_formatted;
        }

        if ($unit && $unit != 'tsp' && $unit != 'tbsp'&& $unit != 'oz') {
            $unit = Pluralizer::plural($unit, ceil($this->amount));
        }

        return $unit;
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
            return match ($this->ingredient::class) {
                Food::class => $this->ingredient->{$method} * Nutrients::calculateFoodNutrientMultiplier(
                    $this->ingredient,
                    $this->amount,
                    $this->unit
                ),
                Recipe::class => Nutrients::calculateRecipeNutrientAmount(
                    $this->ingredient,
                    $method,
                    $this->amount,
                    $this->unit
                ),
                default => 0
            };
        }
        else {
            return parent::__call($method, $parameters);
        }
    }
}
