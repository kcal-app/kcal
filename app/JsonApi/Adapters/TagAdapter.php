<?php

namespace App\JsonApi\Adapters;

use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Support\Collection;
use Spatie\Tags\Tag;

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
        $this->filterWithScopes($query, $filters);
    }

}
