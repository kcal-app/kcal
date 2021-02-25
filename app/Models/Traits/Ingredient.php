<?php

namespace App\Models\Traits;

use App\Models\IngredientAmount;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait Ingredient
{
    /**
     * Add special `type` attribute to appends.
     */
    public function initializeIngredient(): void {
        $this->appends[] = 'type';
    }

    /**
     * Get the class name.
     *
     * This is necessary e.g. to provide data in ingredient picker responses.
     */
    public function getTypeAttribute(): string {
        return $this::class;
    }

    /**
     * Get all of the ingredient amounts associated with the ingredient.
     */
    public function ingredientAmountRelationships(): MorphMany {
        return $this->morphMany(IngredientAmount::class, 'ingredient')->with('parent');
    }
}
