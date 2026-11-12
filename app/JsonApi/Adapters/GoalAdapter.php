<?php

namespace App\JsonApi\Adapters;

use App\Models\Goal;
use CloudCreativity\LaravelJsonApi\Eloquent\BelongsTo;
use Illuminate\Support\Facades\Auth;
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
    protected $defaultSort = ['-name'];

    /**
     * @inheritdoc
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new Goal(), $paging);
    }

    /**
     * Scope every query (collection index and single-resource read) to the authenticated user's
     * own records, so one user cannot read another user's goals via the JSON:API.
     */
    protected function newQuery()
    {
        return parent::newQuery()->where($this->model->getTable() . '.user_id', Auth::id());
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
