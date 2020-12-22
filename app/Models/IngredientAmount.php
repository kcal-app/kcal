<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property float amount
 * @property float unit
 * @property int weight
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
        return $this->ingredient->calories * $this->amount * $this->unitMultiplier();
    }

    /**
     * Get total protein for the ingredient amount.
     */
    public function protein(): float {
        return $this->ingredient->protein * $this->amount * $this->unitMultiplier();
    }

    /**
     * Get total fat for the ingredient amount.
     */
    public function fat(): float {
        return $this->ingredient->fat * $this->amount * $this->unitMultiplier();
    }

    /**
     * Get total carbohydrates for the ingredient amount.
     */
    public function carbohydrates(): float {
        return $this->ingredient->carbohydrates * $this->amount * $this->unitMultiplier();
    }

    /**
     * Get the multiplier for the ingredient unit and ingredient amount unit.
     */
    private function unitMultiplier(): float {
        return match (true) {
            $this->ingredient->unit === 'tsp' && $this->unit === 'tbsp' => 3,
            $this->ingredient->unit === 'tsp' && $this->unit === 'cup' => 48,
            $this->ingredient->unit === 'tbsp' && $this->unit === 'tsp' => 1/3,
            $this->ingredient->unit === 'tbsp' && $this->unit === 'cup' => 16,
            $this->ingredient->unit === 'cup' && $this->unit === 'tsp' => 1/48,
            $this->ingredient->unit === 'cup' && $this->unit === 'tbsp' => 1/16,
            default => 1
        };
    }
}
