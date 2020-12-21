<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IngredientAmount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'amount',
        'weight',
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
}
