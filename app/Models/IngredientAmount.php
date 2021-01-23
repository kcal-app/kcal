<?php

namespace App\Models;

use App\Support\Number;
use App\Support\Nutrients;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property-read Model|\Eloquent $ingredient
 * @property-read Model|\Eloquent $parent
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
            return match ($this->ingredient::class) {
                Food::class => $this->ingredient->{$method} * Nutrients::calculateFoodNutrientMultiplier(
                    $this->ingredient,
                    $this->amount,
                    $this->unit
                ),
                Recipe::class => $this->ingredient->{"{$method}Total"}(),
                default => 0
            };
        }
        else {
            return parent::__call($method, $parameters);
        }
    }
}
