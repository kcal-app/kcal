<?php

namespace App\Models\Traits;

use App\Models\IngredientAmount;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasIngredients
{
    /**
     * Get all of the ingredients.
     */
    public function ingredients(): MorphMany {
        return $this->morphMany(IngredientAmount::class, 'parent');
    }
}
