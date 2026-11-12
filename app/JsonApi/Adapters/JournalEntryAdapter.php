<?php

namespace App\JsonApi\Adapters;

use App\Models\JournalEntry;
use CloudCreativity\LaravelJsonApi\Eloquent\BelongsTo;
use Illuminate\Support\Facades\Auth;
use CloudCreativity\LaravelJsonApi\Eloquent\MorphHasMany;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Support\Collection;

class JournalEntryAdapter extends AdapterBase
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
    protected $defaultSort = ['-date'];

    /**
     * @inheritdoc
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new JournalEntry(), $paging);
    }

    /**
     * Scope every query (collection index and single-resource read) to the authenticated user's
     * own records, so one user cannot read another user's journal entries via the JSON:API.
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

    protected function foods(): MorphHasMany
    {
        return $this->morphMany($this->hasMany('foods'));
    }

    protected function recipes(): MorphHasMany
    {
        return $this->morphMany($this->hasMany('recipes'));
    }

}
