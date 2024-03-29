<?php

namespace App\JsonApi\Adapters;

use App\Models\Food;
use CloudCreativity\LaravelJsonApi\Eloquent\HasMany;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Support\Collection;

class FoodAdapter extends AdapterBase
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
        parent::__construct(new Food(), $paging);
    }

    /**
     * {@inheritdoc}
     */
    protected function filter($query, Collection $filters)
    {
        $this->filterWithScopes($query, $filters->except('search'));
        if ($term = $filters->get('search')) {
            $query->where(function ($query) use ($term) {
                $query->where('foods.name', 'like', "%{$term}%")
                    ->orWhere('foods.detail', 'like', "%{$term}%")
                    ->orWhere('foods.brand', 'like', "%{$term}%");
            });
        }
    }

    protected function tags(): HasMany
    {
        return $this->hasMany();
    }

}
