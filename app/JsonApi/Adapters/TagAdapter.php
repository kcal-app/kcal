<?php

namespace App\JsonApi\Adapters;

use App\Models\Tag;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Support\Collection;

class TagAdapter extends AbstractAdapter
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
        parent::__construct(new Tag(), $paging);
    }

    /**
     * {@inheritdoc}
     */
    protected function filter($query, Collection $filters)
    {
        if ($term = $filters->get('name')) {
            $query->where('tags.name', 'like', "%{$term}%");
        }
        else {
            $this->filterWithScopes($query, $filters);
        }
    }

}
