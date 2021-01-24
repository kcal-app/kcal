<?php

namespace App\JsonApi\Adapters;

use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Database\Eloquent\Builder;
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
        parent::__construct(new \App\Models\Food(), $paging);
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

}
