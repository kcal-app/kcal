<?php

namespace App\JsonApi\Adapters;

use App\Models\Goal;
use CloudCreativity\LaravelJsonApi\Eloquent\BelongsTo;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Support\Collection;

class GoalAdapter extends AdapterBase
{

    /**
     * @inheritdoc
     */
    protected $attributes = [];

    /**
     * @inheritdoc
     */
    protected $filterScopes = [];

    /**
     * {@inheritdoc}
     */
    protected $defaultSort = ['-from', '-to'];

    /**
     * @inheritdoc
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new Goal(), $paging);
    }

    /**
     * @inheritdoc
     */
    protected function filter($query, Collection $filters)
    {
        $this->filterWithScopes($query, $filters);
    }

    protected function user(): BelongsTo
    {
        return $this->belongsTo();
    }

}
