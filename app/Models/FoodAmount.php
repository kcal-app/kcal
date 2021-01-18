<?php

namespace App\Models;

use App\Support\Nutrients;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\FoodAmount
 *
 * @property int $id
 * @property int $food_id
 * @property float $amount
 * @property string|null $unit
 * @property int $recipe_id
 * @property int $weight
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $detail
 * @property-read \App\Models\Food $food
 * @property-read \App\Models\Recipe $recipe
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount query()
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount whereFoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount whereRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount whereWeight($value)
 * @mixin \Eloquent
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
