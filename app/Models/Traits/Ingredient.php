<?php

namespace App\Models\Traits;

use App\Models\IngredientAmount;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;
use Spatie\Tags\Tag;

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

    /**
     * Get totals for all tags used by the ingredient.
     *
     * This method assumes the ingredient has the `HasTags` trait.
     *
     * @see \Spatie\Tags\HasTags
     */
    public static function getTagTotals(string $locale = null): Collection {
        $locale = $locale ?? app()->getLocale();
        return Tag::query()->join('taggables', 'taggables.tag_id', '=', 'id')
            ->select([
                'id',
                "name->{$locale} as name",
                DB::raw('count(*) as total')
            ])
            ->where('taggables.taggable_type', '=', static::class)
            ->groupBy('id')
            ->orderBy("name->{$locale}")
            ->get();
    }
}
