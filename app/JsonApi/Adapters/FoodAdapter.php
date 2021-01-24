<?php

namespace App\JsonApi\Adapters;

use App\Models\Food;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Eloquent\HasMany;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Support\Collection;

class FoodAdapter extends AbstractAdapter
{

    /**
     * {@inheritdoc}
     */
    protected $attributes = [];

    /**
     * {@inheritdoc}
     */
    protected $filterScopes = [];

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
        if ($term = $filters->get('search')) {
            $query->where('foods.name', 'like', "%{$term}%")
                ->orWhere('foods.detail', 'like', "%{$term}%")
                ->orWhere('foods.brand', 'like', "%{$term}%");
        }
        else {
            $this->filterWithScopes($query, $filters);
        }
    }

    /**
     * Tag relationships.
     */
    protected function tags(): HasMany
    {
        return $this->hasMany();
    }

}
