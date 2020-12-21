<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Recipe extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'name',
    ];

    /**
     * Get the Ingredient Amounts used for this Recipe.
     */
    public function ingredientAmounts(): HasMany {
        return $this->hasMany(IngredientAmount::class);
    }
}
