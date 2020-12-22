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
 */
class IngredientAmount extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected array $fillable = [
        'amount',
        'unit',
        'weight',
    ];

    /**
     * The attributes that should be cast.
     */
    protected array $casts = [
        'amount' => 'float',
        'weight' => 'int',
    ];

    /**
     * @inheritdoc
     */
    protected array $with = ['ingredient'];

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
     * Get total calories for the ingredient amount.
     */
    public function calories(): float {
        return $this->ingredient->calories * $this->unitMultiplier();
    }

    /**
     * Get total protein for the ingredient amount.
     */
    public function protein(): float {
        return $this->ingredient->protein * $this->unitMultiplier();
    }

    /**
     * Get total fat for the ingredient amount.
     */
    public function fat(): float {
        return $this->ingredient->fat * $this->unitMultiplier();
    }

    /**
     * Get total carbohydrates for the ingredient amount.
     */
    public function carbohydrates(): float {
        return $this->ingredient->carbohydrates * $this->unitMultiplier();
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
