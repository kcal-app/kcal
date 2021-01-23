<?php

namespace App\Models\Traits;

use App\Models\IngredientAmount;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;

trait Ingredient
{
    /**
     * Get all of the ingredient amounts associated with the ingredient.
     */
    public function ingredientAmountChildren(): MorphToMany {
        return $this->morphToMany(IngredientAmount::class, 'ingredient');
    }

    /**
     * Gets search results for a term.
     */
    public static function search(string $term, int $limit = 10): Collection {
        return (new static)::where('name', 'like', "%{$term}%")->limit($limit)->get();
    }
}
