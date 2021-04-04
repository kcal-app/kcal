<?php

namespace App\Models\Traits;

use App\Models\IngredientAmount;
use App\Support\Nutrients;
use Illuminate\Database\Eloquent\Collection as DatabaseCollection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
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
    public static function getTagTotals(string $locale = null): DatabaseCollection {
        $locale = $locale ?? app()->getLocale();
        return Tag::query()->join('taggables', 'taggables.tag_id', '=', 'id')
            ->select(['id', 'name', DB::raw('count(*) as total')])
            ->where('taggables.taggable_type', '=', static::class)
            ->groupBy('id')
            ->orderBy("name->{$locale}")
            ->get();
    }

    /**
     * Get a collection of units supported by this ingredient.
     */
    public function getUnitsSupportedAttribute(): Collection {
        $units = Nutrients::units();
        $supported = $units->where('value', 'serving');
        if (!empty($this->serving_unit)) {
            $type = $units->where('value', $this->serving_unit)->pluck('type')->first();
            $supported = $supported->merge($units->where('type', $type));
        }
        if (!empty($this->serving_weight)) {
            $supported = $supported->merge($units->where('type', 'weight'));
        }
        return $supported->sortBy('label');
    }
}
