<?php

namespace App\JsonApi\Adapters;

use App\Models\Recipe;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Eloquent\HasMany;
use CloudCreativity\LaravelJsonApi\Eloquent\MorphHasMany;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Support\Collection;

class RecipeAdapter extends AbstractAdapter
{

    /**
     * {@inheritdoc}
     */
    protected $attributes = [];

    /**
     * {@inheritdoc}
     */
    protected $filterScopes = [
        'tags' => 'withAllTags',
        'tags.all' => 'withAllTags',
        'tags.any' => 'withAnyTags',
    ];

    /**
     * {@inheritdoc}
     */
    protected $defaultSort = ['name'];

    /**
     * {@inheritdoc}
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new Recipe(), $paging);
    }

    /**
     * {@inheritdoc}
     */
    protected function filter($query, Collection $filters)
    {
        $this->filterWithScopes($query, $filters->except('search'));
        if ($term = $filters->get('search')) {
            $query->where(function ($query) use ($term) {
                $query->where('recipes.name', 'like', "%{$term}%")
                ->orWhere('recipes.description', 'like', "%{$term}%")
                ->orWhere('recipes.source', 'like', "%{$term}%");
            });
        }
    }

    /**
     * Ingredient amount relationships.
     */
    protected function ingredientAmounts(): MorphHasMany
    {
        return $this->morphMany($this->hasMany('ingredientAmounts'));
    }

    /**
     * Media relationships.
     */
    protected function media(): MorphHasMany
    {
        return $this->morphMany($this->hasMany('media'));
    }

    /**
     * Step relationships.
     */
    protected function steps(): HasMany
    {
        return $this->hasMany();
    }

    /**
     * Tag relationships.
     */
    protected function tags(): HasMany
    {
        return $this->hasMany();
    }

}
